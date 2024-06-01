<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->model('M_website');
        $this->load->library('TripayPayment');
        $this->load->library('TripayControllers');


        $onlogin = $this->session->userdata('status', 'login');
        $this->id = $this->session->userdata('idpel');
        $this->nama = $this->session->userdata('nama');;
        $this->email =  $this->session->userdata('email');

        if (!$onlogin) {
            redirect(base_url('auth'));
            return;
        }
        if ($this->session->userdata('level') === 'admin') {
            redirect(base_url('admin'));
        } else if ($this->session->userdata('level') === 'member') {
            redirect(base_url('member'));
        } elseif ($this->session->userdata('level') === 'developer') {
            redirect(base_url('admin'));
        } elseif ($this->session->userdata('level') === 'reseller') {
            redirect(base_url('reseller'));
        }
    }
    public function index()
    {

        $users = new M_user();

        $data['title'] = "Dashboard";
        $data['content'] = $users->where('idpel', $this->id)
            ->orderBy('id', 'DESC')
            ->get('orders')->result();
        $data['invoice'] = $users->where('idpel', $this->id)
            ->where('status', 'Unpaid')
            ->orderBy('id', 'DESC')
            ->get('invoice')->result();
        $this->load->view('user/home', $data);
    }

    public function service()
    {
        $users = new M_user();


        $data['content'] = $users->where('idpel', $this->id)
            ->orderBy('id', 'DESC')
            ->get('orders')->result();
        $data['title'] = "Layanan Anda";
        $this->load->view('user/service', $data);
    }

    public function invoice()
    {
        $users = new M_user();


        $data['title'] = "Data Invoice";
        $data['invoice'] = $users->where('idpel', $this->id)
            ->orderBy('id', 'DESC')
            ->get('invoice')->result();
        $this->load->view('user/invoice/data', $data);
    }

    public function invoice_print($id = null)
    {
        $dataweb = new M_website();
        $user = new M_user();

        if ($id == null) {
            redirect(base_url('user/invoice/list'));
        } else {
            $cek = $user->where('code', $id)->where('idpel', $this->id)->get('invoice');
            foreach ($cek->result() as $package) {
                $paket = $package->package;
            }
            $service = $user->where('paket', $paket)->get('services');
            if ($cek->num_rows() == 0) {
                redirect(base_url('user/invoice/list'));
            } else {
                $data = array(
                    'title' => 'Invoice #' . $id,
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'service' => $service->result(),
                    'content' => $cek->result(),
                );
                $this->load->view('user/invoice/invoice_detail', $data);
            }
        }
    }

    public function invoice_detail($code = null)
    {
        date_default_timezone_set('Asia/Jakarta');

        $users = new M_user();


        if ($code == null) {
            redirect(base_url('user/invoice'));
        } else {


            $cek = $users->datainvoice($code, $this->id);


            if ($cek->num_rows() == 0) {
                redirect(base_url('user/invoice'));
            } else {
                $data['title'] = "Detail Invoice #$code";
                $data['date'] = date('d-m-Y H:i:s');
                $data['invoice'] = $users->where('code', $code)->first('invoice');
                $data['history'] = $users->where('code', $code)->get('invoice')->result();

                $this->load->view('user/invoice/detail', $data);
            }
        }
    }

    public function invoice_payment($code = null)
    {

        $users = new M_user();

        if ($code == null) {
            redirect(base_url('user'));
        } else {
            $cek = $users->datainvoice($code, $this->id);

            $data = $cek->result_array();

            if ($cek->num_rows() == 0) {
                redirect(base_url('user/invoice'));
            } else if ($data[0]['status'] == 'Paid') {
                redirect(base_url('user/invoice'));
            }

            $data['title'] = "Payment Invoice #$code";
            $data['history'] = $users->where('code', $code)->get('invoice')->result();
            $this->load->view('user/invoice/payment', $data);
            $this->session->set_flashdata('message', 'swal("Berhasil", "Segera lakukan pembayaran pada halaman ini", "success");');
        }
    }

    public function invoice_pembayaran($id = null)
    {

        $users = new M_user();

        if ($id == null) {
            $this->session->set_flashdata('message_err', 'Error System');

            redirect(base_url('user/invoice'));
        } else {
            $cek = $users->where('code', $id)->r_array('invoice');

            $data = $cek[0];

            $invoice = $this->input->post('invoice');
            $paket = $this->input->post('paket');
            $price = $this->input->post('price');

            $post_service = $this->input->post('service');
            $post_category = $this->input->post('category');

            $checkpayment = $users->paymentmethod($post_service);

            $data_payment = $checkpayment[0];

            $note = $data_payment['note'];
            $method = $data_payment['name'];
            $service = $data_payment['service'];

            if (empty($post_category) || empty($post_service)) {
                $this->session->set_flashdata('message_err', 'Pilih metode pembayaran terlebih dahulu ');

                redirect(base_url('user/invoice'));
            } else if ($data['status'] == 'Paid') {
                $this->session->set_flashdata('message_err', 'Error System');

                redirect(base_url('user/invoice'));
            } else {
                date_default_timezone_set("Asia/Jakarta");
                $randangka = rand(1, 999);
                $totharga = $price + $randangka;
                $total = $totharga;
                $satuhari = mktime(0, 0, 0, date("n"), date("j") + 1, date("Y"));
                $expired = date("d-m-Y", $satuhari) . " " . date('H:i:s');
                $user = $this->db->query("SELECT * FROM invoice LEFT JOIN customer on invoice.nama = customer.nama WHERE code = '$id' ")->result_array();
                $content = $user[0];
                if ($data_payment['provider'] == 'tripay') {
                    $check  = $users->where('name', 'tripay')->get('payment_gateway');
                    foreach ($check->result() as $data) {
                        $api = $data->api_url;
                        $code = $data->code_merchant;
                        $key = $data->api_key;
                        $private = $data->private_key;
                        $callback = $data->callback;
                        $tripay = new TripayPayment($api, $code, $key, $private, $callback);
                        $signature = hash_hmac('sha256', $code . $invoice . $total, $private);
                        $tripay->set_params([
                            'method' => $data_payment['provider_code'],
                            'merchant_ref' => $invoice,
                            'amount' => $total,
                            'customer_name' => $content['nama'],
                            'customer_email' => $content['email'],
                            'customer_phone' => $content['nomor'],
                            'order_items' => [
                                [
                                    'name' => $paket,
                                    'price' => $total,
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
                            $mix['data'] = $user;
                            $mix['tripay'] = $result;
                            $mix['payment'] = $ress;
                            $random_price = $result->data->amount;
                            $data = array(
                                'category' => $post_category,
                                'service' => $service,
                                'method' => $method,
                                'penerima' => $note,
                                'random_price' => $random_price,
                                'fix_received' => $total,
                                'reference' => $result->data->reference,
                                'exppay' => $expired,
                                'payment_url' => $paymentUrl,
                                'qr_url' => $qr_url,
                            );
                            $update = $this->db->where('code', $id);
                            $update = $this->db->update('invoice', $data);
                            if ($update == true) {
                                if (!empty($qr_url)) {
                                    $this->load->view('user/invoice/pembayaran', $mix);
                                } else {
                                    $this->load->view('user/invoice/pembayaran', $mix);
                                }
                            } else {
                                $this->session->set_flashdata('message_err', 'Error System');
                                redirect(base_url('user/invoice'));
                            }
                        } else {
                            $this->session->set_flashdata('message_err', $result->message);
                            redirect(base_url('user/invoice'));
                        }
                    }
                } else {
                    if ($data_payment['category'] == 'CSH') {
                        $data = array(
                            'category' => $post_category,
                            'service' => $service,
                            'method' => $method,
                            'exppay' => $expired,
                        );
                        $update = $this->db->where('code', $id);
                        $update = $this->db->update('invoice', $data);
                        if ($update == true) {
                            $pesan = $note;
                            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert"> ' . $pesan . ' </div>');
                            $this->session->set_flashdata('message_success', 'Permintaan berhasil dikirim');
                            redirect(base_url('user/invoice'));
                        } else {
                            $this->session->set_flashdata('message_err', 'Error System');
                        }
                    }
                }
            }
        }
    }

    public function invoice_cek($id = null)
    {

        $users = new M_user();

        date_default_timezone_set('Asia/Jakarta');

        if ($id == null) {
            redirect(base_url('invoice'));
        }


        $sqlcek = $users->datainvoice($id, $this->id);


        if ($sqlcek->num_rows() == 0) {
            redirect(base_url('invoice'));
        }

        $result = $sqlcek->result_array();
        $expiredpay = $result[0]['exppay'];

        $date = date('d-m-Y H:i:s');

        $date = strtotime($date);
        $exp = strtotime($expiredpay);

        if ($date >= $exp) {
            redirect(base_url("user/invoice/detail/" . $id));
        } else if ($result[0]['status'] == 'Paid') {
            redirect(base_url("user/invoice/detail/" . $id));
        } else {
            $reference = $result[0]['reference'];

            $tripay = new TripayControllers();
            $detail = $tripay->detailTransaction($reference);

            $trx = $detail->payment_method;

            // print("<pre>" . print_r($trx, true) . "</pre>");
            // die;

            $getdata = $tripay->getPaymentChannels($trx);

            // print("<pre>" . print_r($getdata[0]->code, true) . "</pre>");
            // die;

            $content['payment'] = $getdata;
            $content['data'] = $result;
            $content['tripay'] = $detail;


            // var_dump($detail);
            // die();

            $this->load->view('user/invoice/info', $content);
        }
    }
    public function invoice_list()
    {
        $users = new M_user();

        $data['invoice'] = $users->where('idpel', $this->id)
            ->orderBy('id', 'DESC')
            ->get('invoice')->result();
        $data['title'] = "Semua Data Invoice";
        $this->load->view('user/invoice/list', $data);
    }

    public function ticket()
    {
        $users = new M_user();

        $data['title'] = 'Tiket';
        $data['tiket'] = $users->where('user', $this->email)
            ->orderBy('id', 'DESC')
            ->get('tickets')->result();
        $this->load->view('user/ticket/index', $data);
    }

    public function createticket()
    {

        $users = new M_user();

        $oid = random_number(15);
        $subject = $this->input->post('subject');
        $pesan = $this->input->post('pesan');
        $date = date("Y-m-d H:i:s");
        $insert = array(
            'code' => $oid,
            'user' => $this->id,
            'subject' => $subject,
            'message' => $pesan,
            'datetime' => $date,
            'last_update' => $date,
            'status' => 'Pending'
        );

        $dbinsert = $users->input('ticket', $insert);
        if ($dbinsert == true) {
            $this->session->set_flashdata('message_success', 'Berhasil membuat tiket baru');
            redirect(base_url('ticket'));
        } else {
            $this->session->set_flashdata('message_err', 'Gagal membuat tiket baru');
            redirect(base_url('ticket'));
        }
    }

    public function account()
    {
        $users = new M_user();


        $data['title'] = "Pengaturan Akun";

        $data['user'] = $users->account($this->email)->row_array();
        $this->load->view('user/account/index', $data);
    }

    public function changepassword()
    {
        $data['title'] = "Ganti Password";
        $data['user'] = $this->db->get_where('users', ['email' =>
        $this->session->userdata('email')])->row_array();

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
            $this->load->view('user/account/changepassword', $data);
        } else {
            $currentpassword = $this->input->post('currentpassword');
            $newpassword    = $this->input->post('new_password');

            if (!password_verify($currentpassword, $data['user']['password'])) {
                $this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert"> Password Sebelumnya Salah </div>');
                $this->session->set_flashdata('message_err', 'Password Sebelumnya Salah');

                redirect('user/account/changepassword');
            } else {
                if ($currentpassword == $newpassword) {
                    $this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert"> Password Tidak Boleh Sama Dengan Sebelumnya</div>');
                    redirect('user/account/changepassword');
                } else {
                    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('users');

                    $this->session->set_flashdata('message_success', 'Password berhasil diganti !');
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"></div>');
                    redirect('user/account/changepassword');
                }
            }
        }
    }
}
