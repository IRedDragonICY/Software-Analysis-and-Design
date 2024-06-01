<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_website');
        $this->load->model('M_member');

        $this->load->library('TripayControllers');
        $this->load->library('TripayPayment');

        $this->email = $this->session->userdata('email');
        $this->nama = $this->session->userdata('nama');

        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth/signin'));
        } else if ($this->session->userdata('level') === 'developer' || $this->session->userdata('level') === 'admin') {
            redirect(base_url('admin'));
        } else if ($this->session->userdata('level') == 'user') {
            redirect(base_url('user'));
        } else if ($this->session->userdata('level') == 'reseller') {
            redirect(base_url('reseller'));
        }
    }

    public function index()
    {
        $dataweb = new M_website();
        $member = new M_member();

        $data = [
            'title' => 'Dashboard',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'content' => $member->where('email', $this->email)->get('users')->result(),
            'total' => $member->where('email', $this->email)->get('orders_voucher')->num_rows(),
        ];
        $this->load->view('member/home', $data);
    }

    public function beli()
    {
        $dataweb = new M_website();

        $data = [
            'title' => 'Beli Voucher Wifi',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,


        ];
        $this->load->view('member/order/new', $data);
    }

    public function createvoucher()
    {
        $member = new M_member();

        $service = $this->input->post('service');

        $date = date("Y-m-d");
        $time = date('H:i:s');

        $checkuser = $member->where('email', $this->email)->get('users');

        foreach ($checkuser->result() as $datauser) {
            $balance = $datauser->balance;
        }

        $checkdb = $member->where('service', $service)->get('services_voucher');
        foreach ($checkdb->result() as $datadb) {
            $timelimit = $datadb->timelimit;
            $price = $datadb->harga;
        }

        if (empty($service)) {
            $this->session->set_flashdata('message_err', 'Silahkan memilih paket terlebih dahulu');
            redirect(base_url('member/beli'));
        } else if ($balance < $price) {
            $this->session->set_flashdata('message_err', 'Saldo anda tidak mencukupi untuk melakukan pembelian ini');
            redirect(base_url('member/beli'));
        } else {
            $checkdb = $member->where('service', $service)->get('services_voucher');
            foreach ($checkdb->result() as $datadb) {
                $timelimit = $datadb->timelimit;
                $price = $datadb->harga;
            }

            $server = $member->where('id', '1')->get('router');
            foreach ($server->result_array() as $row) {
                $host = $row['ip'];
                $uname = $row['username'];
                $pass = decrypt($row['password']);
            }

            $setvoucher = $member->where('id', '1')->get('setting_voucher');
            foreach ($setvoucher->result() as $settingv) {
                $servernya = $settingv->server;
                $lenght = $settingv->lenght;
                $karakter = $settingv->karakter;
            }
            if ($karakter == 'lower1') {
                $voc = randLC($lenght);
            } else if ($karakter == 'upper1') {
                $voc = randUC($lenght);
            } else if ($karakter == 'upplow1') {
                $voc = randULC($lenght);
            } else if ($karakter == 'mix') {
                $voc = randNLC($lenght);
            } else if ($karakter == 'mix1') {
                $voc  = randNUC($lenght);
            } else if ($karakter == 'mix2') {
                $voc = randNULC($lenght);
            }

            $oid = random_number(3) . random_number(4);


            $API = new API();
            if ($API->connect($host, $uname, $pass)) {

                $API->comm("/ip/hotspot/user/add", array(
                    'server' => $servernya,
                    'name' => $voc,
                    'password' => $voc,
                    'profile' => $service,
                    'limit-uptime' => $timelimit
                ));

                $data = array(
                    'oid' => $oid,
                    'email' => $this->email,
                    'service' => $service,
                    'kode' => $voc,
                    'harga' => $price,
                    'date' => $date,
                );



                $update = $member->update_set('email', $this->email, 'users', 'balance', $price);

                if ($update == true) {
                    $insert = array(
                        'email' => $this->email,
                        'type' => 'Minus',
                        'category' => 'Pembelian',
                        'balance' => $price,
                        'message' => 'Melakukan Pembelian Voucher #' . $oid,
                        'date' => $date,
                        'time' => $time,
                    );

                    $masuk = $member->input('balance_history', $insert);
                    $this->db->insert('orders_voucher', $data);
                    $this->session->set_flashdata('message_success', 'Berhasil membeli voucher !');
                    redirect(base_url('member/order/detail/' . $oid));
                } else {
                    $this->session->set_flashdata('message_err', 'Database error !');
                    redirect(base_url('member/beli'));
                }
            } else {
                $this->session->set_flashdata('message_err', 'Server tidak konek ! Harap hubungi admin !');
                redirect(base_url('member/beli'));
            }
        }
    }

    public function topup()
    {

        $dataweb = new M_website();


        $data = [
            'title' => 'Isi Saldo',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,

        ];
        $this->load->view('member/deposit/topup', $data);
    }

    public function pembayaran()
    {
        $post_service = $this->input->post('service');
        $post_category = $this->input->post('category');

        $quantity = $this->input->post('quantity');

        $check_payment = $this->db->query("SELECT * FROM payment_method WHERE id = '$post_service' AND status = '1' ")->result();
        $data_payment = $check_payment[0];

        $note = $data_payment->note;
        $method = $data_payment->name;
        $service = $data_payment->service;

        $rand = randinv(5);
        $query = "SELECT MAX(code) as kodex FROM deposits";
        $data = $this->db->query($query)->row_array();
        $kode = $data['kodex'];
        $nourut = (int) substr($kode, 3, 4);
        $nourut++;
        $char = "INV";
        $kodebaru = $char . sprintf("%04s", $nourut) . $rand;

        $checkuser = $this->db->query("SELECT * FROM users WHERE email = '$this->email'");

        foreach ($checkuser->result() as $datauser) {
            $name = $datauser->nama;
            $nomor = $datauser->nomor;
        }


        if (empty($quantity)) {
            $this->session->set_flashdata('message_err', 'Harap mengisi jumlah isi saldo !');
            redirect(base_url('member/topup'));
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $date = date('Y-m-d');
            $randangka = rand(000, 999);

            $quantity = $quantity + $randangka;
            $balance = $quantity;

            $satuhari = mktime(0, 0, 0, date("n"), date("j") + 1, date("Y"));
            $expired = date("d-m-Y", $satuhari) . " " . date('H:i:s');

            if ($data_payment->provider == 'tripay') {
                $check = $this->db->query("SELECT * FROM payment_gateway WHERE name = 'tripay'")->result();
                $data = $check[0];

                $api = $data->api_url;
                $code = $data->code_merchant;
                $key = $data->api_key;
                $private = $data->private_key;
                $callback = $data->callback;

                $tripay = new TripayPayment($api, $code, $key, $private, $callback);

                $signature = hash_hmac('sha256', $code . $kodebaru . $balance, $private);

                $tripay->set_params([
                    'method' => $data_payment->provider_code,
                    'merchant_ref' => $kodebaru,
                    'amount' => $balance,
                    'customer_name' => $name,
                    'customer_email' => $this->email,
                    'customer_phone' => $nomor,
                    'order_items' => [
                        [
                            'name' => 'Deposit Saldo Member',
                            'price' => $balance,
                            'quantity' => 1,

                        ],
                    ],
                    'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
                    'signature' => $signature,
                ]);
                $result = $tripay->createTransaction();
                $result = json_decode($result);

                if ($result->success === true) {
                    $paymentUrl = null;
                    $qr_url = null;

                    if (!empty($result->data->pay_code)) {
                        $note = $result->data->pay_code;
                    } elseif (!empty($result->data->pay_url)) {
                        $paymentUrl = $result->data->pay_url;
                    } elseif (!empty($result->data->qr_url)) {
                        $qr_url = $result->data->qr_url;
                    }
                    $getdata = $tripay->getChannels($result->data->payment_method);
                    $ress = json_decode($getdata);

                    $mix['tripay'] = $result;
                    $mix['payment'] = $ress;

                    $data = array(
                        'code' => $kodebaru,
                        'idpel' => $this->email,
                        'nama' => $this->nama,
                        'category' => $post_category,
                        'service' => $service,
                        'method' => $method,
                        'penerima' => $note,
                        'package' => 'Deposit Member',
                        'price' => $balance,
                        'status' => 'Unpaid',
                        'reference' => $result->data->reference,
                        'date' => $date,
                        'exppay' => $expired,
                        'payment_url' => $paymentUrl,
                        'qr_url' => $qr_url,
                        'account' => 'member',
                    );

                    $insert = $this->db->insert('invoice', $data);
                    if ($insert == true) {
                        if (!empty($qr_url)) {
                            $this->load->view('member/deposit/invoice', $mix);
                        } else {
                            $this->load->view('member/deposit/invoice', $mix);
                        }
                    } else {
                        $this->session->set_flashdata('message_err', 'Error System');
                        redirect(base_url('member/topup'));
                    }
                } else {

                    $this->session->set_flashdata('message_err', $result->message);
                    redirect(base_url('member/topup'));
                }
            } else {
                if ($data_payment['category'] == 'CSH') {
                    $data = array(
                        'category' => $post_category,
                        'service' => $service,
                        'method' => $method,
                        'exppay' => $expired,
                    );
                    $insert = $this->db->insert('invoice', $data);
                    if ($insert == true) {
                        $pesan = $note;
                        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert"> ' . $pesan . ' </div>');
                        $this->session->set_flashdata('message_success', 'Permintaan berhasil dikirim');
                        redirect(base_url('member/topup'));
                    } else {
                        $this->session->set_flashdata('message_err', 'Error System');
                    }
                }
            }
        }
    }


    public function history_order()
    {

        $dataweb = new M_website();
        $member = new M_member();


        $data = [
            'title' => "History Pembelian",
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'content' => $member->where('email', $this->email)->orderBy('id', 'DESC')->get('orders_voucher')->result(),
        ];

        $this->load->view('member/history/order', $data);
    }

    public function detail_order($id = null)
    {
        $dataweb = new M_website();
        $member = new M_member();

        if ($id == null) {
            redirect(base_url('member/history/order'));
        } else {

            $cek = $member->where('oid', $id)->where('email', $this->email)->get('orders_voucher');
            if ($cek->num_rows() == 0) {
                redirect(base_url());
            } else {
                $data = array(
                    'title' => 'Detail Pembelian #' . $id,
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'content' => $cek->result(),
                );
                $this->load->view('member/order/detail', $data);
            }
        }
    }
    public function history_balance()
    {
        $dataweb = new M_website();
        $member = new M_member();


        $data = [
            'title' => "History Saldo",
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'content' => $member->where('email', $this->email)->orderBy('id', 'DESC')->get('balance_history')->result(),
        ];

        $this->load->view('member/history/balance', $data);
    }

    public function history_topup()
    {
        $dataweb = new M_website();
        $member = new M_member();


        $data = [
            'title' => "History Isi Saldo",
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'content' => $member->where('idpel', $this->email)->orderBy('id', 'DESC')->get('invoice')->result(),
        ];

        $this->load->view('member/history/topup', $data);
    }

    public function invoice_detail($id = null)
    {
        $dataweb = new M_website();
        $member = new M_member();

        if ($id == null) {
            redirect(base_url('member/history/topup'));
        } else {
            $cek = $member->where('code', $id)->where('idpel', $this->email)->get('invoice');
            if ($cek->num_rows() == 0) {
                redirect(base_url('member/history/topup'));
            } else {
                $data = array(
                    'title' => 'Invoice #' . $id,
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'content' => $cek->result(),
                );
                $this->load->view('member/deposit/invoice_detail', $data);
            }
        }
    }

    public function topup_detail($id = null)
    {
        date_default_timezone_set('Asia/Jakarta');


        $dataweb = new M_website();
        $member = new M_member();

        if ($id == null) {
            redirect(base_url('member/history/topup'));
        } else {
            $cek = $member->where('code', $id)->where('idpel', $this->email)->get('invoice');
            if ($cek->num_rows() == 0) {
                redirect(base_url('member/history/topup'));
            } else {
                foreach ($cek->result() as $result) {
                    $expiredpay = $result->exppay;
                    $date = date('d-m-Y H:i:s');
                    $date = strtotime($date);
                    $exp = strtotime($expiredpay);
                    if ($date >= $exp) {
                        redirect(base_url("member/history/topup"));
                    } else if ($result->status == 'Paid') {
                        redirect(base_url("member/history/topup"));
                    } else {
                        $reference = $result->reference;

                        $tripay = new TripayControllers();
                        $detail = $tripay->detailTransaction($reference);

                        $trx = $detail->payment_method;


                        $getdata = $tripay->getPaymentChannels($trx);

                        $content = [
                            'payment' => $getdata,
                            'data' => $result,
                            'tripay' => $detail,
                        ];



                        $this->load->view('member/deposit/info', $content);
                    }
                }
            }
        }
    }

    public function ticket()
    {
        $dataweb = new M_website();
        $member = new M_member();

        $data = [
            'title' => 'Tiket',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'tiket' => $member->where('user', $this->email)->orderBy('id', 'DESC')->get('tickets')->result(),
        ];

        $this->load->view('member/tiket/home', $data);
    }

    public function tiket_create()
    {
        $member = new M_member();

        $oid = random_number(15);
        $subject = $this->input->post('subject', TRUE);
        $pesan = $this->input->post('pesan', TRUE);
        $date = date("Y-m-d H:i:s");
        $insert = array(
            'code' => $oid,
            'user' => $this->email,
            'subject' => $subject,
            'message' => $pesan,
            'datetime' => $date,
            'last_update' => $date,
            'status' => 'Pending'
        );

        $input = $member->input('tickets', $insert);
        if ($input == true) {
            $this->session->set_flashdata('message_success', 'Berhasil membuat tiket baru');
            redirect(base_url('member/ticket'));
        } else {
            $this->session->set_flashdata('message_err', 'Database Error');
            redirect(base_url('member/ticket'));
        }
    }

    public function tiket_open($id = null)
    {
        $member = new M_member();
        $dataweb = new M_website();

        if ($id == null) {
            redirect(base_url('ticket'));
        } else {
            $cek = $member->where('id', $id)->where('user', $this->email)->get('tickets');
            if ($cek->num_rows() == 0) {
                redirect(base_url('member/ticket'));
            } else {
                $data = [
                    'title' => 'Data Tiket',
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'ticket' => $cek->result(),
                    'check' => $member,
                ];

                $this->load->view('member/tiket/open', $data);
            }
        }
    }

    public function ticket_reply()
    {

        $member = new M_member();
        $dataweb = new M_website();

        $post_message = $this->input->post('message');
        $target = $this->input->post('id');
        $user = $this->input->post('user');
        $date = date('Y-m-d H:i:s');

        $insert = array(
            'ticket_id' => $target,
            'sender' => 'User',
            'user' => $user,
            'message' => $post_message,
            'datetime' => $date
        );

        $update = array(
            'last_update' => $date,
            'status' => 'Waiting',
            'seen_admin' => '0',
            'seen_user' => '1'
        );


        $tickets = $member->update('id', $target, ' tickets', $update);
        if ($tickets == true) {
            $masuk = $member->input('tickets_message', $insert);
            $this->session->set_flashdata('message_success', 'Pesan terkirim');
            redirect('member/tiket/open/' . $target);
        } else {
            $this->session->set_flashdata('message_err', 'Database Error');
            redirect('member/tiket/open/' . $target);
        }
    }



    public function account()
    {
        $member = new M_member();
        $dataweb = new M_website();

        $email = array('email' => $this->email);


        $data = [
            'title' => 'Pengaturan Akun',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'user' => $member->get_where('users', $email),

        ];
        $this->load->view('member/account/home', $data);
    }

    public function changepassword()
    {
        $member = new M_member();
        $dataweb = new M_website();

        $email = array('email' => $this->email);
        $data = [
            'title' => 'Ganti Password',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'user' => $member->get_where('users', $email),
        ];


        $this->form_validation->set_rules('currentpassword', 'currentpassword', 'trim|required', array(
            'required' => 'Masukan Password saat ini'
        ));

        $this->form_validation->set_rules('new_password', 'new_password', 'trim|required|matches[repeat_password]', array(
            'required' => 'Masukan Password.',
            'matches' => 'Password Tidak Sama.',
        ));
        $this->form_validation->set_rules('repeat_password', 'repeat_password', 'trim|required|matches[new_password]', array(
            'required' => 'Masukan Password.',
            'matches' => 'Password Tidak Sama.',
        ));

        if ($this->form_validation->run() == false) {
            $this->load->view('member/account/changepassword', $data);
        } else {
            $currentpassword = $this->input->post('currentpassword');
            $newpassword    = $this->input->post('new_password');

            if (!password_verify($currentpassword, $data['user'][0]->password)) {
                $this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert"> Password Sebelumnya Salah </div>');
                redirect('member/account/changepassword');
            } else {
                if ($currentpassword == $newpassword) {
                    $this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert"> Password Tidak Boleh Sama Dengan Sebelumnya</div>');
                    redirect('member/account/changepassword');
                } else {
                    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('users');

                    $this->session->set_flashdata('message_success', 'Password berhasil diganti !');
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"></div>');
                    redirect('member/account/changepassword');
                }
            }
        }
    }
}
