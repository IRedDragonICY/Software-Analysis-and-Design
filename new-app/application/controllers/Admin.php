<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');
        $this->load->model('M_website');

        $this->nama = $this->session->userdata('nama');
        $this->level = $this->session->userdata('level');
        $this->onlogin = $this->session->userdata('status', 'login');

        $this->apikeywa = 'xSnXay3GgZv5S9Uv5rno1XdihFB1nAuP'; // API KEY WA GATEWAY
        $this->apiurlwa = 'http://wa.myserv.my.id/'; // API URL WA GATEWAY 



        if (!$this->onlogin) {
            redirect(base_url('auth'));
            return;
        } else if ($this->level != 'developer' && $this->level != 'admin') {
            redirect(base_url('user'));
        } else if ($this->level == 'member') {
            redirect(base_url('member'));
        }
    }

    public function index()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Dashboard Admin',
            'logo' => $dataweb->website()->logo,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'paid' => $admin->paid(),
            'unpaid' => $admin->unpaid(),
            'close' => $admin->close(),
            'pending' => $admin->pending(),
            'users' => $admin->users(),
            'useraktif' => $admin->useraktif()->num_rows(),
            'userisolir' => $admin->userisolir()->num_rows(),
            'usersend' => $admin->userend()->num_rows(),
            'members' => $admin->members()->num_rows(),
            'reseller' => $admin->reseller()->num_rows(),
        ];
        $this->load->view('admin/home', $data);
    }

    public function customer()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $sqlcek = $admin->join('customer', 'orders', 'idpel', 'left');


        $data = [
            'title' => 'Data Rumahan',
            'logo' => $dataweb->website()->logo,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'cek' => $sqlcek,

        ];

        $this->load->view('admin/customer/index', $data);
    }


    public function customer_member()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $sqlcek = $admin->where('level', 'member')->get('users')->result();

        $data = [
            'title' => 'Data Member',
            'logo' => $dataweb->website()->logo,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'cek' => $sqlcek,

        ];

        $this->load->view('admin/customer/member', $data);
    }

    public function customer_reseller()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $sqlcek = $admin->where('level', 'reseller')->get('users')->result();

        $data = [
            'title' => 'Data Reseller',
            'logo' => $dataweb->website()->logo,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'password' => random_number(8),
            'cek' => $sqlcek,

        ];

        $this->load->view('admin/customer/reseller', $data);
    }

    public function addreseller()
    {
        $nama = $this->input->post('name');
        $email = $this->input->post('email');
        $nowa = $this->input->post('nowa');
        $password = $this->input->post('password');
        $komisi = $this->input->post('komisi');
        $balance = $this->input->post('balance');

        $insert = array(
            'email' => $email,
            'nama' => $nama,
            'nomor' => $nowa,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'balance' => $balance,
            'level' => 'reseller',
            'status_account' => 'Active',
            'komisi' => $komisi,
        );

        $this->db->insert('users', $insert);
        $this->session->set_flashdata('message_success', 'Berhasil menambahkan reseller baru');
        redirect(base_url('admin/customer/reseller'));
    }

    public function customer_service()
    {
        $dataweb = new M_website();
        $admin = new M_admin();
        $cek = $admin->get('services');

        if ($cek->num_rows() == 0) {
            redirect(base_url('admin/services'));
        } else {
            $data = [
                'title' => 'Paket Layanan',
                'logo' => $dataweb->website()->logo,

                'logotext' => $dataweb->website()->logo_text,
                'titleweb' => $dataweb->website()->title,
                'author' => $dataweb->website()->author,
                'package' => $cek->result(),
            ];

            $this->load->view('admin/customer/service', $data);
        }
    }

    public function customer_add($encode = '')
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        if ($encode == null) {
            redirect(base_url('admin/customer/service'));
        } else {
            $decode = $encode;
            $id = array('id' => $decode);


            $data = [
                'title' => 'Input Pelanggan Baru',
                'logo' => $dataweb->website()->logo,

                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'query' => $admin->get_where('services', $id)->result(),
                'idpel' => $admin->idpel(),
                'password' => random_number(8),

            ];

            $this->load->view('admin/customer/add', $data);
        }
    }

    public function customer_prosesadd()
    {

        $admin = new M_admin();

        $oid = random_number(15);
        $package = $this->input->post('package');
        $name = $this->input->post('name');
        $nomor = $this->input->post('nohp');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');

        $idpel = $this->input->post('idpel');
        $password = $this->input->post('password');

        $billpriod = $this->input->post('billpriod');
        $fixdate = $this->input->post('datefix');
        $jenis = $this->input->post('jenip');

        $static = $this->input->post('ipadd');

        $masa = '30';
        $date = date("Y-m-d");


        if (empty($name) || empty($nomor) || empty($email) || empty($alamat)) {
            $this->session->set_flashdata('message_err', 'Mohon mengisi semua input');
            redirect(base_url('admin/customer/service'));
        } else {
            if ($billpriod == 'randomdate') {
                $hasil = $masa;

                date_default_timezone_set('Asia/Jakarta');
                $date = date("Y-m-d");
                $tanggal = date('Y-m-d H:i:s');
                $datepx = date_create($tanggal);
                date_add($datepx, date_interval_create_from_date_string('' . $hasil . 'days'));

                $expired = date_format($datepx, 'Y-m-d');
            } else {
                $expired = $fixdate;
            }

            $image = $_FILES['image'];
            if ($image = '') {
            } else {
                $config['upload_path'] = FCPATH . '/data/document';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['file_name'] = 'data-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $data['error'] = $this->upload->display_errors();
                } else {
                    $image = $this->upload->data('file_name');
                }
            }

            if ($jenis == 'static') {
                $ip = $static;
            } else {
                $ip = null;
            }

            $insert = array(
                'oid' => $oid,
                'idpel' => $idpel,
                'nama' => $name,
                'paket' => $package,
                'status' => 'Active',
                'billpriod' => $billpriod,
                'jenis' => $jenis,
                'ipstatik' => $ip,
                'date' => $date,
                'expdate' => $expired,
            );
            $admin->input('orders', $insert);

            $insert_customer = array(
                'nama' => $name,
                'email' => $email,
                'nomor' => $nomor,
                'alamat' => $alamat,
                'idpel' => $idpel,
                'image' => $image,
            );
            $admin->input('customer', $insert_customer);

            $insert_user = array(
                'email' => $email,
                'nama' => $name,
                'nomor' => $nomor,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'level' => 'user',
                'status_account' => 'Active',
            );

            $admin->input('users', $insert_user);

            $this->session->set_flashdata(
                'pesan',

                '<div class="alert alert-custom" role="alert">
                <div class="alert-content">
                    <span class="alert-title"> <b> Berhasil menambahkan data baru </b></span>
                    <hr>
                    <span class="alert-text">
                        <b> Kode Pesanan </b> : ' . $oid . '<br />
                        <b> ID Pelanggan </b> : ' . $idpel . '<br />
                        <b> Paket </b> : ' . $package . '<br />
                        <br />
                        <hr>
                        <b> Informasi Login Customer Area </b> <br />
                        Email : ' . $email . '<br />
                        Password : ' . $password . ' <br />
                        <hr>
                        Kirimkan informasi login customer area diatas kepada customer yang sudah berlangganan layanan ini
                    </span>
                </div>
            </div>'
            );

            $this->session->set_flashdata('message_success', 'Berhasil menambahkan data pelanggan baru');
            redirect(base_url('orders'));
        }
    }

    public function customer_detail($id = null)
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        if ($id == null) {
            $this->session->set_flashdata('message_err', 'Access Denied');

            redirect(base_url('admin/customer'));
        } else {
            $cek = $admin->where('idpel', $id)->get('customer');

            if ($cek->num_rows() == 0) {
                redirect(base_url('admin/customer'));
            } else {

                $sqlcek = $admin->join_where('customer', 'orders', 'nama', 'idpel', $id, 'left');

                $data = [
                    'title' => 'Detail Pelanggan',
                    'titleweb' => $dataweb->website()->title,
                    'logo' => $dataweb->website()->logo,

                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'customer' => $admin->where('idpel', $id)->first('customer'),
                    'customers' => $admin->where('idpel', $id)->get('customer')->result(),
                    'cek' => $sqlcek,

                ];
                $this->load->view('admin/customer/detail', $data);
            }
        }
    }

    public function customer_edit($id = null)
    {

        $admin = new M_admin();
        $dataweb = new M_website();

        if ($id == null) {
            redirect(base_url('admin/customer'));
        } else {
            $cek = $admin->where('idpel', $id)->get('customer');

            if ($cek->num_rows() == 0) {
                redirect(base_url('admin/customer'));
            } else {
                $server = $admin->get('router');

                foreach ($server->result_array() as $row) {
                    $host = $row['ip'];
                    $uname = $row['username'];
                    $pass = decrypt($row['password']);

                    $API = new API();
                    if ($API->connect($host, $uname, $pass)) {

                        // get hotspot info

                        $pppsecret = $API->comm("/ppp/secret/print");



                        $data = [
                            'alluser' => $pppsecret,
                        ];


                        $datanya = [
                            'title' => "Sinkron Data Pelanggan",
                            'titleweb' => $dataweb->website()->title,
                            'logo' => $dataweb->website()->logo,
                            'logotext' => $dataweb->website()->logo_text,
                            'author' => $dataweb->website()->author,
                            'customer' => $admin->where('idpel', $id)->first('customer'),
                            'customers' => $admin->where('idpel', $id)->get('customer')->result(),
                            'cek' =>  $admin->join_where('customer', 'orders', 'nama', 'idpel', $id, 'left'),
                            'alluser' => $pppsecret,
                        ];


                        $this->load->view('admin/customer/edit', $datanya);
                    } else {
                        $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                        redirect(base_url('router/setting'));
                    }
                }
            }
        }
    }

    public function pool()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $cek = $admin->get('pool');

        if ($cek->num_rows() > 0) {
            redirect(base_url('admin/pool/edit'));
        } else {
            $data = [
                'title' => "IP Address Isolir",
                'titleweb' => $dataweb->website()->title,
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
            ];
            $this->load->view('admin/pool/add', $data);
        }
    }

    public function pool_add()
    {
        $post = $this->input->post(null);

        $data = array(
            'ip_range' => $post['ip'],
            'cidr' => $post['cidr'],
        );

        $this->db->insert('pool', $data);
        $this->session->set_flashdata('message_success', 'Berhasil menambahkan data baru');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
        Berhasil menambahkan data baru
                </div>');
        redirect('admin/pool');
    }

    public function pool_edit()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $data = [
            'title' => 'IP Address Isolir',
            'titleweb' => $dataweb->website()->title,
            'logo' => $dataweb->website()->logo,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'pool' => $admin->get('pool')->result(),
        ];
        $this->load->view('admin/pool/edit', $data);
    }

    public function ip_isolir()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $data =
            [
                'title' => 'IP Address Isolir',
                'titleweb' => $dataweb->website()->title,
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'data' => $admin->get('pool'),
            ];

        $this->load->view('admin/pool/ipisolir', $data);
    }

    public function services()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Layanan',
            'titleweb' => $dataweb->website()->title,
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'packages' => $admin->get('services')->result(),

        ];
        $this->load->view('admin/services/index', $data);
    }

    public function services_create()
    {
        $admin = new M_admin();

        $package = $this->input->post('package');
        $price = $this->input->post('price');
        $ppn = $this->input->post('ppn');
        $insert = array(
            'paket' => $package,
            'harga' => $price,
            'ppn' => $ppn,
            'status' => 'Tersedia'
        );

        $admin->input('services', $insert);
        $this->session->set_flashdata('message_success', 'Berhasil menambahkan layanan baru');
        redirect(base_url('admin/services'));
    }
    public function service_edit($id = null)
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        if ($id == null) {
            redirect(base_url('admin/services'));
        } else {
            $data = [
                'title' => 'Edit Layanan',
                'titleweb' => $dataweb->website()->title,
                'logotext' => $dataweb->website()->logo_text,
                'logo' => $dataweb->website()->logo,

                'author' => $dataweb->website()->author,
                'content' => $admin->where('id', $id)->get('services')->result(),

            ];
            $this->load->view('admin/services/edit', $data);
        }
    }

    public function service_update()
    {
        $admin = new M_admin();
        $name = $this->input->post('nama');
        $harga = $this->input->post('harga');
        $ppn = $this->input->post('ppn');
        $target = $this->input->post('target');

        if ($target == null) {
            $this->session->set_flashdata('message_err', 'Access Denied');

            redirect(base_url('admin/services'));
        } else {

            $update = array(
                'paket' => $name,
                'harga' => $harga,
                'ppn' => $ppn,
            );


            $admin->update('id', $target, 'services', $update);

            $this->session->set_flashdata('message_success', 'Berhasil edit data ');

            redirect(base_url('admin/services'));
        }
    }

    public function service_delete($id = null)
    {
        $admin = new M_admin();

        if ($id == null) {
            $this->session->set_flashdata('message_err', 'Access Denied');

            redirect(base_url('admin/services'));
        } else {
            $where = array('id' => $id);
            $admin->delete('services', $where);
            $this->session->set_flashdata('message_success', 'Berhasil menghapus layanan');

            redirect(base_url('admin/services'));
        }
    }

    public function generate_invoice()
    {
        $dataweb = new M_website();

        $data = [
            'title' => 'Generate Manual Invoice',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'logo' => $dataweb->website()->logo,
        ];

        $this->load->view('admin/invoice/generate', $data);
    }

    public function generate_invoice_proses()
    {
        $disc = $this->input->post('disc');
        $admin = new M_admin();
        $datainv = $admin->get_where('orders', array('status' => 'Active'))->result();

        foreach ($datainv as $value) {
            $idpel = $value->idpel;
            $user = $value->nama;
            $package = $value->paket;
            $billpriod = $value->billpriod;
            $tanggal = time();
            $date = date('Y-m-d');
            $expdate = $value->expdate;
            $tglactive = $value->date;

            $paketnya = $admin->where('paket', $package)->get('services')->result();

            foreach ($paketnya as $services) {
                $harga = $services->harga;
                $ppn = $services->ppn;
            }

            $price = $harga + $harga * $ppn / 100;
            $discount = $price - $price * $disc / 100;

            if (strtotime('-20 days', strtotime($expdate <= date($tanggal)))) {
                $rand = randinv(5);
                $query = "SELECT MAX(code) as kodex FROM invoice";
                $data = $this->db->query($query)->row_array();
                $kode = $data['kodex'];
                $nourut = (int) substr($kode, 3, 4);
                $nourut++;
                $char = "INV";
                $kodebaru = $char . sprintf("%04s", $nourut) . $rand;

                if ($billpriod == 'fixdate') {
                    // Cek Tanggal
                    $kalender = CAL_GREGORIAN;
                    $bulan = date('m');
                    $tahun = date('Y');

                    $masa = cal_days_in_month($kalender, $bulan, $tahun);
                    $active = $tglactive;
                    $expired = $expdate;

                    $tgl1 = strtotime($active);
                    $tgl2 = strtotime($expired);

                    $jarak = $tgl2 - $tgl1;

                    $hari = $jarak / 60 / 60 / 24;

                    // $bayar = $price / $masa * $hari;

                    if ($hari == '31') {
                        $bayar = $price / 30 * 30;
                        $masa = '30';
                        $hari = '30';
                    } else if ($hari == '28') {
                        $bayar = $price / 30 * 30;
                        $masa = '30';
                        $hari = '30';
                    } else {
                        $bayar = $price / $masa * $hari;
                    }
                } else {
                    $bayar = $discount;
                }
                $checkinvoice = $admin->get_where('invoice', array('idpel' => $idpel, 'status' => 'Unpaid'));

                $datainvoice = $checkinvoice->num_rows();
                if ($datainvoice > 0) {
                    $this->session->set_flashdata('message_err', 'Sudah ada data invoice');
                    redirect(base_url('admin/invoice'));
                } else {
                    $cekuser = $admin->where('nama', $user)->get('customer')->result();
                    foreach ($cekuser as $usernya) {
                        $nomor = $usernya->nomor;
                    }
                    $whatsapp = $admin->get('whatsapp')->result();

                    foreach ($whatsapp as $gateway) {
                        $sender = $gateway->sender;
                        $message = $gateway->tagihan_otomatis;
                    }
                    $indo = date('Y-m-d', strtotime($expdate));
                    $tglindo = tanggal_indo($indo);
                    $base_url = base_url();

                    $message = str_replace("{nama_customer}", $user, $message);
                    $message = str_replace("{id_pelanggan}", $idpel, $message);
                    $message = str_replace("{expdate}", $tglindo, $message);
                    $message = str_replace("{link_web}", $base_url, $message);
                    $message = str_replace("{nomor_invoice}", $kodebaru, $message);

                    $sendwa = [
                        'api_key' => $this->apikeywa,
                        'sender' => $sender,
                        'number' => $nomor,
                        'message' => $message,
                    ];
                    $res = $this->guzzle->request('POST', $this->apiurlwa . 'send-message', [
                        'form_params' => $sendwa
                    ]);
                    $result = json_decode($res->getBody()->getContents(), true);


                    $data = [
                        'code' => $kodebaru,
                        'idpel' => $idpel,
                        'nama' => $user,
                        'package' => $package,
                        'price' => $bayar,
                        'status' => 'Unpaid',
                        'date' => $date,
                        'expdate' => $expdate,
                        'account' => 'user',
                    ];
                    $update = [
                        'billpriod' => 'none',
                    ];
                    $orders = $admin->update('idpel', $idpel, 'orders', $update);
                    $invoice = $admin->input('invoice', $data);
                    $this->session->set_flashdata('message_success', 'berhasil membuat invoice manual');
                    redirect(base_url('admin/invoice'));
                }
            }
        }
    }

    public function invoice()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Invoice',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'logo' => $dataweb->website()->logo,

            'invoicehome' => $admin->totalinvoicehome()->num_rows(),
            'invoicemember' => $admin->totalinvoicemember()->num_rows(),
        ];

        $this->load->view('admin/invoice/invoice', $data);
    }


    public function invoice_home()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Invoice Rumahan',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,

            'author' => $dataweb->website()->author,
            'paid' => $admin->paiduser(),
            'unpaid' => $admin->unpaiduser(),
            'totalmonthpaid' => $admin->totalmonthpaid(),
            'totalmonthunpaid' => $admin->totalmonthunpaid(),
            'prevmonthpaid' => $admin->prevmonthpaid(),
            'prevmonthunpaid' => $admin->prevmonthunpaid(),
        ];

        $this->load->view('admin/invoice/home/invoice', $data);
    }

    public function invoice_member()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Invoice Member',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,

            'author' => $dataweb->website()->author,
            'paid' => $admin->paidmember(),
            'unpaid' => $admin->unpaidmember(),
            'totalmonthpaid' => $admin->totalmonthpaidmembers(),
            'totalmonthunpaid' => $admin->totalmonthunpaidmembers(),
            'prevmonthpaid' => $admin->prevmonthpaidmember(),
            'prevmonthunpaid' => $admin->prevmonthunpaidmember(),
        ];

        $this->load->view('admin/invoice/member/invoice', $data);
    }


    public function allinvoice_home()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Invoice',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'data' => $admin->where('account', 'user')->get('invoice')->result(),
        ];

        $this->load->view('admin/invoice/home/allinvoice', $data);
    }

    public function allinvoice_member()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Invoice Member',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'data' => $admin->where('account', 'member')->get('invoice')->result(),
        ];

        $this->load->view('admin/invoice/member/allinvoice', $data);
    }

    public function invoice_thismonth()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Invoice Bulan ini',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'data' => $admin->invoicethismonth(),
        ];

        $this->load->view('admin/invoice/home/thismonth', $data);
    }

    public function invoice_thismonth_member()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Invoice Member Bulan ini',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'data' => $admin->invoicethismonthmember(),
        ];

        $this->load->view('admin/invoice/member/thismonth', $data);
    }


    public function invoice_prevmonth()
    {
        $dataweb = new M_website();
        $admin = new M_admin();


        $data = [
            'title' => 'Data Invoice Bulan Kemarin',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'data' => $admin->invoiceprevmonth(),
        ];

        $this->load->view('admin/invoice/home/prevmonth', $data);
    }

    public function invoice_prevmonth_member()
    {
        $dataweb = new M_website();
        $admin = new M_admin();


        $data = [
            'title' => 'Data Invoice Member Bulan Kemarin',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'data' => $admin->invoiceprevmonthmember(),
        ];

        $this->load->view('admin/invoice/member/prevmonth', $data);
    }

    public function edit_invoice($id = null)
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        if ($id == null) {
            redirect(base_url('admin/invoice'));
        } else {
            $cek = $admin->where('id', $id)->get('invoice');


            if ($cek->num_rows() == 0) {
                redirect(base_url('admin/invoice'));
            } else {
                $data = [
                    'title' => 'Edit Pembayaran',
                    'logo' => $dataweb->website()->logo,

                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'payment' => $admin->where('id', $id)->get('invoice')->result(),

                ];
                $this->load->view('admin/invoice/home/edit', $data);
            }
        }
    }

    public function update_invoice()
    {
        $admin = new M_admin();

        $guzzle = new GuzzleHttp\Client();

        $code = $this->input->post('code');
        $user = $this->input->post('user');
        $idpel = $this->input->post('idpel');
        $status = $this->input->post('status');
        $target = $this->input->post('target');
        $expdate = $this->input->post('expdate');
        $package = $this->input->post('package');
        $category = $this->input->post('category');
        $metode = $this->input->post('metode');
        $price = $this->input->post('price');
        $image = $_FILES['image'];
        if ($image = null) {
            $this->session->set_flashdata('message_err', 'Harap melampirkan bukti kwitansi !');
            redirect(base_url('admin/invoice'));
        } else {
            $config['upload_path'] = FCPATH . '/data/bukti';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name'] = 'bukti-pembayaran-' . $code . '-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
            $config['overwrite'] = true;
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $image = $this->upload->data('file_name');
            }

            if ($status === 'Paid') {
                date_default_timezone_set('Asia/Jakarta');
                $date = date("Y-m-d");

                $tglexp = $expdate;

                $tgl2 = date('Y-m-d', strtotime('+1 month', strtotime($tglexp)));

                $cek = $admin->where('idpel', $idpel)->get('orders');
                foreach ($cek->result() as $cekdata) {

                    $statusorder = $cekdata->status;
                    $jenis = $cekdata->jenis;
                    $users = $cekdata->pppoe_user;
                }

                $server = $admin->get('router');
                foreach ($server->result() as $row) {
                    $ip = $row->ip;
                    $uname = $row->username;
                    $pass = decrypt($row->password);
                }

                if ($statusorder == 'Isolir') {
                    if ($jenis == 'statis') {
                        $static = $cekdata->ipstatik;

                        $API = new API();
                        if ($API->connect($ip, $uname, $pass)) {
                            $all = $API->comm(
                                "/ppp/secret/getall",
                                array(
                                    ".proplist" => ".id",
                                    "?name" => $users,
                                )
                            );

                            $API->comm(
                                "/ppp/secret/set",
                                array(
                                    ".id" => $all[0][".id"],
                                    "remote-address" => $static,
                                )
                            );
                            $active = $API->comm("/ppp/active/getall", array(
                                ".proplist" => ".id",
                                "?name" => $users,
                            ));

                            $API->comm(
                                "/ppp/active/remove",
                                array(
                                    ".id" => $active[0][".id"],
                                )
                            );
                        }

                        $cekuser = $admin->where('nama', $user)->get('customer')->result();
                        foreach ($cekuser as $usernya) {
                            $nomor = $usernya->nomor;
                        }
                        $whatsapp = $admin->get('whatsapp')->result();
                        foreach ($whatsapp as $gateway) {

                            $sender = $gateway->sender;
                            $message = $gateway->tagihan_terbayar;
                        }
                        $message = str_replace("{nama_customer}", $user, $message);
                        $message = str_replace("{id_pelanggan}", $idpel, $message);
                        $message = str_replace("{nomor_invoice}", $code, $message);



                        $data = [
                            'api_key' => $this->apikeywa,
                            'sender' => $sender,
                            'number' => $nomor,
                            'message' => $message,
                        ];

                        $res = $guzzle->request('POST', $this->apiurlwa . 'send-message', [
                            'form_params' => $data
                        ]);
                        $result = json_decode($res->getBody()->getContents(), true);
                        // 


                        $update = array(
                            'status' => $status,
                            'category' => $category,
                            'service' => $metode,
                            'method' => $metode,
                            'last_update' => $date,
                            'update_by' => $this->session->userdata('nama'),
                            'bukti_pembayaran' => $image,
                        );
                        $updateinvoice = $admin->update('id', $target, 'invoice', $update);

                        $update_orders = array(
                            'status' => 'Active',
                            'expdate' => $tgl2,
                        );
                        $updateorders = $admin->update('idpel', $idpel, 'orders', $update_orders);

                        $this->session->set_flashdata('message_success', 'Berhasil edit data');
                        redirect(base_url('admin/invoice'));
                    } else {
                        $API = new API();
                        if ($API->connect($ip, $uname, $pass)) {
                            $all = $API->comm(
                                "/ppp/secret/getall",
                                array(
                                    ".proplist" => ".id",
                                    "?name" => $users,
                                )
                            );

                            $API->comm(
                                "/ppp/secret/unset",
                                array(
                                    ".id" => $all[0][".id"],
                                )
                            );
                            $active = $API->comm("/ppp/active/getall", array(
                                ".proplist" => ".id",
                                "?name" => $users,
                            ));

                            $API->comm(
                                "/ppp/active/remove",
                                array(
                                    ".id" => $active[0][".id"],
                                )
                            );
                        }
                    }
                } else {
                    $cekuser = $admin->where('nama', $user)->get('customer')->result();
                    foreach ($cekuser as $usernya) {
                        $nomor = $usernya->nomor;
                    }
                    $whatsapp = $admin->get('whatsapp')->result();
                    foreach ($whatsapp as $gateway) {

                        $sender = $gateway->sender;
                        $message = $gateway->tagihan_terbayar;
                    }
                    $message = str_replace("{nama_customer}", $user, $message);
                    $message = str_replace("{id_pelanggan}", $idpel, $message);
                    $message = str_replace("{nomor_invoice}", $code, $message);



                    $data = [
                        'api_key' => $this->apikeywa,
                        'sender' => $sender,
                        'number' => $nomor,
                        'message' => $message,
                    ];

                    $res = $guzzle->request('POST', $this->apiurlwa . 'send-message', [
                        'form_params' => $data
                    ]);
                    $result = json_decode($res->getBody()->getContents(), true);
                    // 

                    $update = array(
                        'status' => $status,
                        'category' => $category,
                        'service' => $metode,
                        'method' => $metode,
                        'last_update' => $date,
                        'update_by' => $this->session->userdata('nama'),
                        'bukti_pembayaran' => $image,
                    );


                    $updateinvoice = $admin->update('id', $target, 'invoice', $update);

                    $update_orders = array(
                        'status' => 'Active',
                        'expdate' => $tgl2,
                    );
                    $updateorders = $admin->update('idpel', $idpel, 'orders', $update_orders);

                    $this->session->set_flashdata('message_success', 'Berhasil edit data');
                    redirect(base_url('admin/invoice/home/allinvoice'));
                }
            }
        }
    }

    public function report()
    {
        $dataweb = new M_website();
        $admin = new M_admin();


        $data = [
            'title' => 'Laporan Keuangan',
            'logo' => $dataweb->website()->logo,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'report' => $admin->report(),
            'debit' => $admin->debit(),
            'psb' => $admin->psb(),
            'credit' => $admin->credit(),
            'bersih' => $admin->bersih(),
        ];

        $this->load->view('admin/report/home', $data);
    }

    public function report_masuk()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Pemasukan',
            'logo' => $dataweb->website()->logo,
            'report' => $admin->report_masuk(),
            'tahun' => $admin->gettahunmasuk(),
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'titleweb' => $dataweb->website()->title,

        ];

        $this->load->view('admin/report/masuk', $data);
    }
    public function report_keluar()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Pengeluaran',
            'logo' => $dataweb->website()->logo,

            'report' => $admin->report_keluar(),
            'tahun' => $admin->gettahun(),
            'logotext' => $dataweb->website()->logo_text,
            'titleweb' => $dataweb->website()->title,
            'author' => $dataweb->website()->author,

        ];

        $this->load->view('admin/report/keluar', $data);
    }

    public function report_psb()
    {

        $dataweb = new M_website();
        $admin = new M_admin();


        $data = [
            'title' => 'Data Pemasukan PSB',
            'report' => $admin->report_psb(),
            'logo' => $dataweb->website()->logo,

            'tahun' =>  $admin->gettahun(),
            'logotext' => $dataweb->website()->logo_text,
            'titleweb' => $dataweb->website()->title,
            'author' => $dataweb->website()->author,

        ];

        $this->load->view('admin/report/psb', $data);
    }

    public function ticket()
    {

        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Data Tiket',
            'logo' => $dataweb->website()->logo,

            'logotext' =>  $dataweb->website()->logo_text,
            'author' =>  $dataweb->website()->author,
            'content' => $admin->orderBy('id', 'DESC')->get('tickets')->result(),

        ];
        $this->load->view('admin/ticket/home', $data);
    }

    public function ticket_reply($id = null)
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $cek = $admin->where('id', $id)->get('tickets')->result();

        foreach ($cek as $datanya) {
            $status = $datanya->status;
        }

        if ($id == null) {
            redirect(base_url('admin/ticket'));
        } else if ($status == 'Closed') {
            $this->session->set_flashdata('message_err', 'Status tiket sudah closed !');
            redirect(base_url('admin/ticket'));
        } else {
            $data = [
                'title' => "Reply Tiket #$id",
                'logo' => $dataweb->website()->logo,

                'logotext' =>  $dataweb->website()->logo_text,
                'author' =>  $dataweb->website()->author,
                'ticket' => $cek,

            ];
            $this->load->view('admin/ticket/reply', $data);
        }
    }

    public function reply_ticket()
    {

        $admin = new M_admin();

        $post_message = $this->input->post('message');
        $target = $this->input->post('id');
        $user = $this->input->post('user');
        $date = date('Y-m-d H:i:s');

        $insert = array(
            'ticket_id' => $target,
            'sender' => 'Admin',
            'message' => $post_message,
            'user' => $this->nama,
            'datetime' => $date,
        );

        $update = array(
            'last_update' => $date,
            'seen_user' => '0',
            'seen_admin' => '1',
            'status' => 'Responded',
        );

        $updatenya = $admin->update('id', $target, 'tickets', $update);
        $insertnya = $admin->input('tickets_message', $insert);

        $this->session->set_flashdata('message_success', 'Berhasil mengirimkan pesan');
        redirect('admin/ticket/reply/' . $target);
    }

    public function ticket_closed($id = null)
    {
        $admin = new M_admin();

        if ($id == null) {
            redirect(base_url());
        } else {


            $update = array(
                'status' => 'Closed',
            );
            $update = $admin->update('id', $id, 'tickets', $update);

            $this->session->set_flashdata('message_success', 'Berhasil menutup Ticket');
            redirect('admin/ticket');
        }
    }

    public function ticket_open($id = null)
    {
        $dataweb = new M_website();
        $admin = new M_admin();


        if ($id == null) {
            redirect(base_url('admin/ticket'));
        } else {
            $data = [
                'title' => "Reply Tiket #$id",
                'logo' => $dataweb->website()->logo,

                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'ticket' => $admin->where('id', $id)->get('tickets')->result()

            ];

            $this->load->view('admin/ticket/open', $data);
        }
    }

    public function ticket_delete($id = null)
    {
        $admin = new M_admin();

        if ($id == null) {
            redirect(base_url());
        } else {
            $where = array('id' => $id);
            $admin->delete('tickets', $where);
            $this->session->set_flashdata('message_success', 'Berhasil menghapus tiket');
            redirect('admin/ticket');
        }
    }


    public function infouser()
    {
        $dataweb = new M_website();


        $data = [
            'title' => 'Kirim Informasi',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,

        ];

        $this->load->view('admin/kiriminfo', $data);
    }

    public function kiriminfo()
    {
        $admin = new M_admin();


        $post = $this->input->post('message');

        // Ambil Data WA Server
        $whatsapp = $admin->get('whatsapp')->result();

        foreach ($whatsapp as $gateway) {
            $sender = $gateway->sender;
        }

        // Ambil data nomor whatsapp client 

        $client = $admin->where('status_account', 'Active')->get('users')->result();
        foreach ($client as $number) {

            $nowa = $number->nomor;

            $datanya = [
                'api_key' => $this->apikeywa,
                'sender' => $sender,
                'number' => $nowa,
                'message' => $post,
            ];

            $guzzle = new GuzzleHttp\Client();

            $guzzle->request('POST', $this->apiurlwa . 'send-message', [
                'form_params' => $datanya
            ]);
        }
        $this->session->set_flashdata('message_success', 'Berhasil mengirimkan pesan ke pelanggan');
        redirect('admin/infouser');
    }

    public function whatsapp()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $datawa = $admin->get('whatsapp');
        foreach ($datawa->result() as $gateway) {
            $status = $gateway->status;
        }

        if ($datawa->num_rows() == '0') {
            redirect(base_url('admin/whatsapp/setup'));
        } else if ($status == '0') {
            redirect(base_url('admin/whatsapp/setup'));
        } else {
            $data = [
                'title' => 'Pengaturan Whatsapp Gateway',
                'logo' => $dataweb->website()->logo,

                'logotext' =>  $dataweb->website()->logo_text,
                'author' =>  $dataweb->website()->author,
                'content' => $datawa->result(),

            ];
            $this->load->view('admin/whatsapp/home', $data);
        }
    }

    public function update_whatsapp()
    {
        $admin = new M_admin();


        $sender = $this->input->post('sender');
        $notif = stripslashes(strip_tags(htmlspecialchars($this->input->post('notif', ENT_QUOTES))));
        $terbayar = stripslashes(strip_tags(htmlspecialchars($this->input->post('terbayar', ENT_QUOTES))));
        $register = stripslashes(strip_tags(htmlspecialchars($this->input->post('register', ENT_QUOTES))));


        $update = array(

            'tagihan_otomatis' => $notif,
            'tagihan_terbayar' => $terbayar,
            'register' => $register
        );



        $admin->update('sender', $sender, 'whatsapp', $update);




        $this->session->set_flashdata('message_success', 'Berhasil edit data');
        redirect(base_url('admin/whatsapp'));
    }


    public function whatsapp_setup()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $datawa = $admin->get('whatsapp');


        $data = [
            'title' => 'Setup Whatsapp Gateway',
            'logo' => $dataweb->website()->logo,

            'logotext' =>  $dataweb->website()->logo_text,
            'author' =>  $dataweb->website()->author,
            'content' => $datawa,

        ];
        $this->load->view('admin/whatsapp/setup', $data);
    }

    public function proses_whatsapp()
    {
        $admin = new M_admin();

        $client = new GuzzleHttp\Client();


        $sender = $this->input->post('sender');

        $data = [
            'api_key' => $this->apikeywa,
            'number' => $sender,
        ];

        $res = $client->request('POST', $this->apiurlwa . 'generate-qr', [
            'form_params' => $data
        ]);
        $result = json_decode($res->getBody()->getContents(), true);

        //Type respon (json)
        // { "status" : "processing", "message" : "processing"  }
        // { "status" : true, "message" : "Already Connected"  }
        // { "status" : false, "qrcode" : "qr url",  "message" : "Please Scan qr

        if (is_array($result)) {

            $status = $result['status'];
            $message = $result['message'];

            if ($status == false) {
                $qrcode =  $result['qrcode'];
            }
        }
        $insert = array(
            'sender' => $sender,
            'status' => '0'

        );
        $admin->input('whatsapp', $insert);

        $this->session->set_flashdata('message_success', $message);

        redirect(base_url('admin/whatsapp/setup'));
    }

    public function scanqr_whatsapp()
    {

        $client = new GuzzleHttp\Client();


        $sender = $this->input->post('sender');

        $data = [
            'api_key' => $this->apikeywa,
            'number' => $sender,
        ];

        $res = $client->request('POST', $this->apiurlwa . 'generate-qr', [
            'form_params' => $data
        ]);
        $result = json_decode($res->getBody()->getContents(), true);

        //Type respon (json)
        // { "status" : "processing", "message" : "processing"  }
        // { "status" : true, "message" : "Already Connected"  }
        // { "status" : false, "qrcode" : "qr url",  "message" : "Please Scan qr

        if (is_array($result)) {

            $status = $result['status'];
            $message = $result['message'];

            if ($status == false) {
                $qrcode =  $result['qrcode'];
            }
        }

        $this->session->set_flashdata(
            'pesan',

            '
            <div class="alert alert-light" role="alert">Silahkan Scan Kode QR dibawah ini, <br /> setelah di scan harap klik tombol refresh .</div>
            <div class="alert alert-danger" role="alert">Jika Kode QR tidak muncul klik tombol dibawah ini <br/> <a href=" ' . base_url('admin/whatsapp/setup ') . '" class="btn btn-light">Scan QR </a></div>

                <img src=" ' .  $qrcode   . ' " class="img-thumbnail" alt="QRCode">
'
        );



        redirect(base_url('admin/whatsapp/setup'));
    }

    public function refresh_whatsapp()
    {
        $admin = new M_admin();

        $client = new GuzzleHttp\Client();

        $sender = $this->input->post('sender');

        $data = [
            'api_key' => $this->apikeywa,
            'number' => $sender,
        ];

        $res = $client->request('POST', $this->apiurlwa . 'generate-qr', [
            'form_params' => $data
        ]);
        $result = json_decode($res->getBody()->getContents(), true);

        //Type respon (json)
        // { "status" : "processing", "message" : "processing"  }
        // { "status" : true, "message" : "Already Connected"  }
        // { "status" : false, "qrcode" : "qr url",  "message" : "Please Scan qr

        if (is_array($result)) {

            $status = $result['status'];
            $message = $result['message'];

            if ($status == true) {
                $update = array(
                    'status' => 1,
                );


                $admin->update('sender', $sender, 'whatsapp', $update);

                $this->session->set_flashdata('message_success', $message);

                redirect(base_url('admin/whatsapp'));
            } else {
                $this->session->set_flashdata('message_err', $message);

                redirect(base_url('admin/whatsapp/setup'));
            }
        }
    }

    public function cekactive_whatsapp()
    {
        $admin = new M_admin();

        $datawa = $admin->get('whatsapp');


        foreach ($datawa->result() as $datanya) {
            $sender = $datanya->sender;
        }
        $client = new GuzzleHttp\Client();


        $data = [
            'api_key' => $this->apikeywa,
            'number' => $sender,
        ];

        $res = $client->request('POST', $this->apiurlwa . 'generate-qr', [
            'form_params' => $data
        ]);
        $result = json_decode($res->getBody()->getContents(), true);

        //Type respon (json)
        // { "status" : "processing", "message" : "processing"  }
        // { "status" : true, "message" : "Already Connected"  }
        // { "status" : false, "qrcode" : "qr url",  "message" : "Please Scan qr

        if (is_array($result)) {

            $status = $result['status'];
            $message = $result['message'];

            if ($status == true) {
                $this->session->set_flashdata(
                    'pesan',

                    '
                    <div class="alert alert-light" role="alert">Koneksi Oke.</div>
        
        '
                );

                $this->session->set_flashdata('message_success', $message);

                redirect(base_url('admin/whatsapp'));
            } else if ($status = 'processing') {
                $this->session->set_flashdata('message_err', $message);

                redirect(base_url('admin/whatsapp/setup'));
            } else {
                $this->session->set_flashdata('message_err', $message);

                redirect(base_url('admin/whatsapp/setup'));
            }
        }
    }

    public function note()
    {

        $dataweb = new M_website();
        $admin = new M_admin();


        $data = [
            'title' => 'Catatan',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,

            'author' => $dataweb->website()->author,
            'cek' => $admin->get('note')->result(),

        ];

        $this->load->view('admin/note/home', $data);
    }

    public function addnote()
    {
        $admin = new M_admin();


        date_default_timezone_set('Asia/Jakarta');
        $date = date("Y-m-d H:i:s");

        $pesan = $this->input->post('pesan');
        $image = $_FILES['image'];
        if ($image = '') {
        } else {
            $config['upload_path'] = FCPATH . '/data/catatan';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name'] = 'catatan-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $image = $this->upload->data('file_name');
            }
        }

        $insert = array(
            'message' => stripslashes(strip_tags(htmlspecialchars($pesan, ENT_QUOTES))),
            'date' => $date,
            'image' => $image,
            'account' => $this->session->userdata('nama'),
        );

        $insert = $admin->input('note', $insert);

        $this->session->set_flashdata('message_success', 'Berhasil menambahkan catatan baru');
        redirect(base_url('admin/note'));
    }

    public function ceknote($id = null)
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        if ($id == null) {
            redirect(base_url('admin/note'));
        } else {
            $cek = $admin->where('id', $id)->get('note');

            if ($cek->num_rows() == 0) {
                redirect(base_url('admin/note'));
            }

            $data = [
                'title' => "Catatan",
                'logo' => $dataweb->website()->logo,

                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'cek' => $cek->result(),

            ];

            $this->load->view('admin/note/ceknote', $data);
        }
    }


    public function coupon()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $data = [
            'title' => 'Pengaturan Diskon Kupon',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,

            'content' => $admin->get('coupon')->result(),

        ];

        $this->load->view('admin/coupon', $data);
    }

    public function addcoupon()
    {

        $admin = new M_admin();

        $post = $this->input->post(null, true);

        $insert = array(
            'code' => $post['code'],
            'rate' => $post['rate'],
            'otp' => $post['otp'],
        );
        $admin->input('coupon', $insert);
        $this->session->set_flashdata('message_success', 'Berhasil menambahkan kode kupon baru');
        redirect(base_url('admin/coupon'));
    }


    public function account()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $email = array('email' => $this->session->userdata('email'));

        $data = [
            'title' => 'Pengaturan Akun',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,

            'user' => $admin->get_where('users', $email)->result(),

        ];

        $this->load->view('admin/account/home', $data);
    }

    public function changepassword()
    {
        $admin = new M_admin();
        $email = array('email' => $this->session->userdata('email'));
        $dataweb = new M_website();

        $data = [
            'title' => 'Ganti Password',
            'logo' => $dataweb->website()->logo,

            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'user' => $admin->get_where('users', $email)->row_array(),
        ];

        $this->form_validation->set_rules('currentpassword', 'currentpassword', 'trim|required', array(
            'required' => 'Masukan Password saat ini',
        ));

        $this->form_validation->set_rules('new_password', 'new_password', 'trim|required|matches[repeat_password]', array(
            'required' => 'Masukan Password Baru.',
            'matches' => 'Password Tidak Sama.',
        ));
        $this->form_validation->set_rules('repeat_password', 'repeat_password', 'trim|required|matches[new_password]', array(
            'required' => 'Masukan Password Konfirmasi.',
            'matches' => 'Password Tidak Sama.',
        ));

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/account/changepassword', $data);
        } else {
            $currentpassword = $this->input->post('currentpassword');
            $newpassword = $this->input->post('new_password');

            if (!password_verify($currentpassword, $data['user']['password'])) {
                $this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert"> Password Sebelumnya Salah </div>');
                redirect('admin/account/changepassword');
            } else {
                if ($currentpassword == $newpassword) {
                    $this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert"> Password Tidak Boleh Sama Dengan Sebelumnya</div>');
                    redirect('admin/account/changepassword');
                } else {
                    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('users');

                    $this->session->set_flashdata('message_success', 'Password berhasil diganti !');
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"></div>');
                    redirect('admin/account/changepassword');
                }
            }
        }
    }

    public function website()
    {
        $dataweb = new M_website();

        $data = [
            'title' => "Pengaturan Website",
            'logo' => $dataweb->website()->logo,

            'titledata' => $dataweb->website()->title,
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'logo' => $dataweb->website()->logo,
        ];

        $this->load->view('admin/website/home', $data);
    }

    public function update_website()
    {
        $admin = new M_admin();

        $post = $this->input->post(null);
        $image = $_FILES['image'];
        if ($image = '') {
        } else {
            $config['upload_path'] = FCPATH . '/assets/logo';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name'] = 'logo-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
            $config['overwrite'] = true;
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $image = $this->upload->data('file_name');
            }

            if ($image == true) {
                $update = array(
                    'title' => $post['title'],
                    'logo_text' => $post['logotext'],
                    'author' => $post['author'],
                    'logo' => $image,
                );
            } else {
                $update = array(
                    'title' => $post['title'],
                    'logo_text' => $post['logotext'],
                    'author' => $post['author'],
                    'logo' => $post['logo'],
                );
            }



            $admin->update('id', '1', 'website', $update);

            $this->session->set_flashdata('message_success', 'Data website berhasil di ganti');
            redirect(base_url('admin/website'));
        }
    }

    public function smtp()
    {
        $dataweb = new M_website();
        $admin = new M_admin();


        $smtp = $admin->get('smtp_setting');
        $cek = $smtp->num_rows();

        if ($cek == 0) {
            redirect('admin/smtp/setup');
        } else {
            foreach ($smtp->result() as $row) {
                $apikey = $row->api_key;
                $name = $row->nama_smtp;
                $email = $row->email_smtp;
                $target = $row->id;
            }
            $data = [
                'title' => 'SMTP Mail',
                'logo' => $dataweb->website()->logo,

                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'api_key' => $apikey,
                'nama' => $name,
                'email' => $email,
                'target' => $target,
            ];
            $this->load->view('admin/smtp/home', $data);
        }
    }

    public function smtp_setup()
    {
        $dataweb = new M_website();
        $admin = new M_admin();

        $datasmtp = $admin->get('smtp_setting');


        $data = [
            'title' => 'Setup SMTP Sendinblue',
            'logo' => $dataweb->website()->logo,

            'logotext' =>  $dataweb->website()->logo_text,
            'author' =>  $dataweb->website()->author,
            'content' => $datasmtp,

        ];
        $this->load->view('admin/smtp/setup', $data);
    }

    public function proses_smtp()
    {
        $admin = new M_admin();

        $apikey = $this->input->post('apikey');
        $name = $this->input->post('name');
        $email = $this->input->post('email');




        $insert = array(
            'api_key' => $apikey,
            'nama_smtp' => $name,
            'email_smtp' => $email,

        );
        $admin->input('smtp_setting', $insert);

        $this->session->set_flashdata('message_success', 'Berhasil menambahkan data smtp ');

        redirect(base_url('admin/smtp'));
    }

    public function update_smtp()
    {
        $admin = new M_admin();

        $post = $this->input->post(null);
        $target = $this->input->post('target');
        $update = array(
            'api_key' => $post['api_key'],
            'nama_smtp' => $post['name'],
            'email_smtp' => $post['email'],
        );
        $admin->update('id', $target, 'smtp_setting', $update);
        $this->session->set_flashdata('message_success', 'SMTP Berhasil diganti !');
        redirect(base_url('admin/smtp'));
    }
    public function company()
    {
        $admin = new M_admin();
        $dataweb = new M_website();


        $company = $admin->where('id', '1')->get('company');
        foreach ($company->result_array() as $row) {
            $logo = $row['logo'];
            $addr = $row['address'];
            $city = $row['city'];
            $prov = $row['province'];
            $country = $row['country'];
            $zip = $row['postal_code'];
        }

        $data = [
            'logo' => $logo,
            'addr' => $addr,
            'city' => $city,
            'prov' => $prov,
            'country' => $country,
            'zip' => $zip,
            'title' => 'Pengaturan Company',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'logo' => $dataweb->website()->logo,

        ];
        $this->load->view('admin/company', $data);
    }

    public function company_update()
    {
        $admin = new M_admin();
        $logo = $this->input->post('logo');
        $addr = $this->input->post('address');
        $city = $this->input->post('city');
        $prov = $this->input->post('province');
        $country = $this->input->post('country');
        $zip = $this->input->post('postal_code');
        $image = $_FILES['image'];
        if ($image = '') {
        } else {
            $config['upload_path']          = FCPATH . '/assets/logo/';
            $config['allowed_types']    = 'jpg|png|jpeg';
            $config['file_name'] = 'logo-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
            $config['overwrite'] = true;
            $config['max_size']         = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $image = $this->upload->data('file_name');
            }
        }

        if ($image == true) {
            $data = array(
                'logo'  => $image,
                'address'  => $addr,
                'city'  => $city,
                'province'  => $prov,
                'country'   => $country,
                'postal_code' => $zip,
            );
        } else {
            $data = array(
                'logo'  => $logo,
                'address'  => $addr,
                'city'  => $city,
                'province'  => $prov,
                'country'   => $country,
                'postal_code' => $zip,
            );
        }


        $admin->update('id', '1', 'company', $data);

        $this->session->set_flashdata('message_success', 'Berhasil edit data');
        redirect(base_url('admin/company'));
    }
    public function tambahuser()
    {
        $dataweb = new M_website();

        $data = [
            'title' => 'Tambah User',
            'logo' => $dataweb->website()->logo,
            'logotext' =>  $dataweb->website()->logo_text,
            'author' =>  $dataweb->website()->author,
            'password' => random_number(8),

        ];

        $this->load->view('admin/account/adduser', $data);
    }

    public function adduser()
    {
        $admin = new M_admin();

        $nama = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $level = $this->input->post('level');

        if (empty($nama) || empty($email)) {
            $this->session->set_flashdata('message_err', 'Mohon mengisi semua input');
            redirect(base_url('admin/tambahuser'));
        } else {

            $insert = array(
                'email' => $email,
                'nama' => $nama,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'level' => $level,
            );
            $admin->input('users', $insert);

            $smtp = $admin->get('smtp_setting');
            foreach ($smtp->result_array() as $row) {
                $api_key = $row['api_key'];
                $name = $row['nama_smtp'];
                $email_smtp = $row['email_smtp'];
            }

            $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $api_key);

            $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
                new GuzzleHttp\Client(),
                $config
            );
            $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
            $sendSmtpEmail['params'] = array('subject' => 'Akun Members Fiber Delta Network telah aktif !');

            $sendSmtpEmail['subject'] = '{{params.subject}}';

            $sendSmtpEmail['htmlContent'] = '
                <html>
                <body>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tbody>
                <tr>
                <td bgcolor="#f2f2f2" style="font-size:0px">&nbsp;</td>
                <td bgcolor="#ffffff" width="660" align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tbody>
                <tr>
                <td align="center" width="600" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <tr>
                <td bgcolor="#f2f2f2" style="padding-top:10px"></td>
                </tr>
                <tr>
                <td bgcolor="#f2f2f2" style="padding-top:10px"></td>
                </tr>
                <tr>
                <td align="center" valign="top" bgcolor="#ffffff">
                <table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px;padding-top:20px" width="100%">
                <tbody>
                <tr valign="bottom">
                <td width="20" align="center" valign="top">&nbsp;</td>
                <td>
                <span>
                <center>
                <p><img src="https://dev.fiberdelta.net/assets/logo/logo-220724-3d2c90bd45.png" height="120" alt="logo"></p>
                </center>
                </span>
                </td>
                <td width="20" align="center" valign="top">&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px;padding-top:10px;margin-bottom:10px" width="100%">
                <tbody>
                <tr valign="bottom">
                <td width="20" align="center" valign="top">&nbsp;</td>
                <td valign="top" style="font-family:Calibri,Trebuchet,Arial,sans serif;font-size:15px;line-height:22px;color:#333333">
                <p>Hai ' . $nama . '</a></p>
                <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                Akun anda saat ini telah aktif, dengan info akun :  <br>
                Email : ' . $email . ' <br/>
                Password : ' . $password . ' <br/><br/>
                silahkan login pada website klik tombol dibawah ini
                </p>
                <a href="' . base_url() . '"
                style="background:#4054B2;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login Sekarang !</a>
                <p><br><br>Fiber Delta Network<br>Jakarta, DKI Jakarta<br>Indonesia, 13930<br>
                </td>
                <td width="20" align="center" valign="top">&nbsp;</td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tbody>
                <tr>
                <td align="center" width="600" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <tr>
                <td bgcolor="#f2f2f2" style="padding-top:20px"></td>
                </tr>
                <tr>
                <td align="center" valign="top" bgcolor="#f2f2f2">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr valign="bottom">
                <td width="20" align="center" valign="top">&nbsp;</td>
                <td>
                <table align="left" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                <td style="font-family:Calibri,Trebuchet,Arial,sans serif;font-size:13px;color:#666;font-weight:bold">
                <span id="m_-6118667421211539915bottomLinks">
                <div style="margin:5px 0;padding:0">
                <span style="display:inline">
                <span>
                <a href="https://www.fiberdelta.net" style="text-decoration:none" target="_blank">
                Bantuan&nbsp;
                </a>
                </span>
                <span style="color:#ccc"><span> | </span></span>
                <span>
                <a href="https://www.fiberdelta.net" style="text-decoration:none" target="_blank" >
                Website&nbsp;
                </a>
                </span>
                </span>
                </div>
                </span>
                </td>
                </tr>
                </tbody>
                </table>
                </td>
                <td width="20" align="center" valign="top">&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr valign="bottom">
                <td width="20" align="center" valign="top">&nbsp;</td>
                <td>
                <p> Jangan balas ke email ini. Untuk menghubungi kami, klik
                <strong><a href="" style="text-decoration:none" target="_blank" >Bantuan dan Hubungi</a></strong>.
                </p>
                </td>
                <td width="20" align="center" valign="top">&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr valign="bottom">
                <td width="20" align="center" valign="top">&nbsp;</td>
                <td>
                <span>
                <table border="0" cellpadding="0" cellspacing="0" id="m_-6118667421211539915emailFooter" style="padding-top:10px;font:12px Arial,Verdana,Helvetica,sans-serif;color:#292929" width="100%">
                <tbody>
                <tr>
                <td>
                <p>Hak Cipta © 2022 Fiber Delta Network </p>
                </td>
                </tr>
                </tbody>
                </table>
                </span>
                </td>
                <td width="20" align="center" valign="top">&nbsp;</td>
                </tr>
                </tbody>
                </table>

                </td>
                </tr>
                </tbody>
                </table>
                </td>

                </tr>
                </tbody>
                </table>
                </td>
                <td bgcolor="#f2f2f2" style="font-size:0px">&nbsp;</td>
                </tr>
                </tbody>
                </table>
                </body>
                </html>';
            $sendSmtpEmail['sender'] = array('name' => 'System FDN', 'email' => 'noreply@vpnkuid.my.id');
            $sendSmtpEmail['to'] = array(
                array('email' => $email),
            );

            $sendSmtpEmail['replyTo'] = array('email' => 'noreply@vpnkuid.my.id', 'name' => 'System FDN');
            if ($apiInstance->sendTransacEmail($sendSmtpEmail)) {
                $this->session->set_flashdata('message_success', 'Berhasil menambahkan data akun baru');
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Berhasil menambahkan data akun baru
                        </div>');
                redirect('admin/tambahuser');
            }
        }
    }

    public function payment()
    {
        $admin = new M_admin();
        $dataweb = new M_website();


        $getDataRekening = $admin->get('payment_method')->result();
        $data = [

            'title' => 'Metode Pembayaran',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'logo' => $dataweb->website()->logo,
            'payment' => $admin->where('id', '1')->get('payment_gateway')->result(),
            'metode' => $getDataRekening,
        ];

        $this->load->view('admin/payment/method', $data);
    }

    public function payment_update()
    {
        $admin = new M_admin();
        $code = $this->input->post('code_merchant');
        $api_url = $this->input->post('api_url');
        $api_key = $this->input->post('api_key');
        $private = $this->input->post('private_key');
        $status = $this->input->post('status');

        $update = array(
            'code_merchant' => $code,
            'api_url' => $api_url,
            'api_key' => $api_key,
            'private_key' => $private,
            'status' => $status,
        );
        $admin->update('id', '1', 'payment_gateway', $update);

        $this->session->set_flashdata('message_success', 'Berhasil edit data');
        redirect(base_url('admin/payment'));
    }
}
