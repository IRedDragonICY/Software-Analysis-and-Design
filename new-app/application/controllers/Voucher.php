<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_voucher');
        $this->load->model('M_website');

        $this->nama = $this->session->userdata('nama');
        $this->level = $this->session->userdata('level');
        $this->onlogin = $this->session->userdata('status', 'login');




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
        $voucher = new M_voucher();

        $data = [
            'title' => 'Dashboard Voucher Wifi',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,
            'author' => $dataweb->website()->author,
            'month' => $voucher->month(),
            'vcrmonth' => $voucher->vcrmonth(),
            'today' => $voucher->today(),
            'vcrtoday' => $voucher->vcrtoday(),
            'yesterday' => $voucher->yesterday(),
            'vcrystrdy' => $voucher->vcrystrdy(),

        ];

        $this->load->view('admin/voucher/home', $data);
    }

    public function users()
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();


        $data = [
            'title' => 'Users List',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,
            'author' => $dataweb->website()->author,
            'totalhotspotuser' => $voucher->totalhotspotuser(),
            'hotspotuser' => $voucher->hotspotuser(),
            'comment' => $voucher->comment(),

        ];




        $this->load->view('admin/voucher/hotspot/users', $data);
    }

    public function print_default($comment = null)
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();
        if ($comment == null) {
            $this->session->set_flashdata('message_err', 'Access Denied');
            redirect(base_url('admin/voucher/hotspot/users'));
        } else {
            $check  = $voucher->where('comment', $comment)->get('orders_voucher');
            $resultcheck = $check->result();
            foreach ($resultcheck as $datanya) {
                $service = $datanya->service;
            }

            $checkservice = $voucher->where('service', $service)->get('services_voucher');
            $router = $voucher->get('router');
            $data = [
                'title' => 'Print Voucher ' . $comment,
                'logotext' => $dataweb->website()->logo_text,
                'logo' => $dataweb->website()->logo,
                'author' => $dataweb->website()->author,
                'comment' => $check->result(),
                'service' => $checkservice->result(),
                'router' => $router->result(),
                'total' => $check->num_rows(),

            ];

            $this->load->view('admin/voucher/print/print', $data);
        }
    }

    public function cekdatabycomment($comment = null)
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();
        if ($comment == null) {
            $this->session->set_flashdata('message_err', 'Access Denied');
            redirect(base_url('admin/voucher/hotspot/users'));
        } else {
            $check  = $voucher->where('comment', $comment)->get('orders_voucher');
            if ($check->num_rows() == 0) {
                $this->session->set_flashdata('message_err', 'Tidak ada comment tersebut');
                redirect(base_url('admin/voucher/hotspot/user'));
            } else {
                $data = [
                    'title' => 'Cek Voucher ' . $comment,
                    'logotext' => $dataweb->website()->logo_text,
                    'logo' => $dataweb->website()->logo,
                    'author' => $dataweb->website()->author,
                    'totalhotspotuser' => $check->num_rows(),
                    'comment' => $check->result_array(),

                ];

                $this->load->view('admin/voucher/hotspot/cekdatabycomment', $data);
            }
        }
    }





    public function generate()
    {
        $voucher = new M_voucher();
        $dataweb = new M_website();

        $datadb = $voucher->get('services_voucher');

        if ($datadb->num_rows() == 0) {
            redirect(base_url('voucher/profile'));
        } else {
            $server = $voucher->get('router');

            foreach ($server->result_array() as $row) {
                $host = $row['ip'];
                $uname = $row['username'];
                $pass = decrypt($row['password']);
            }

            $reseller = $voucher->where('level', 'reseller')->get('users')->result();



            $API = new API();
            if ($API->connect($host, $uname, $pass)) {

                // get hotspot info

                $server = $API->comm("/ip/hotspot/print");
                $profile = $datadb->result();
                $data = [
                    'title' => 'Generate Voucher',
                    'logotext' => $dataweb->website()->logo_text,
                    'logo' => $dataweb->website()->logo,
                    'author' => $dataweb->website()->author,
                    'server' => $server,
                    'profile' => $profile,
                    'reseller' => $reseller,


                ];
                $this->load->view('admin/voucher/hotspot/generate', $data);
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('admin/router/setting'));
            }
        }
    }

    public function prosesgenerate()
    {
        $voucher = new M_voucher();


        $post = $this->input->post(null);
        $profile = $post['profile'];

        $date = date("Y-m-d");

        $checkdb = $voucher->where('id', $profile)->get('services_voucher');
        foreach ($checkdb->result() as $datadb) {
            $price = $datadb->harga;
            $nameservice = $datadb->service;
        }

        $server = $voucher->get('router');
        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }
        $quantity = $post['quantity'];

        for ($n = 1; $n <= $quantity; $n++) {
            if ($post['character'] == 'lower1') {
                $voc[$n] = randLC($post['lenght']);
            } else if ($post['character'] == 'upper1') {
                $voc[$n] = randUC($post['lenght']);
            } else if ($post['character'] == 'upplow1') {
                $voc[$n] = randULC($post['lenght']);
            } else if ($post['character'] == 'mix') {
                $voc[$n] = randNLC($post['lenght']);
            } else if ($post['character'] == 'mix1') {
                $voc[$n] = randNUC($post['lenght']);
            } else if ($post['character'] == 'mix2') {
                $voc[$n] = randNULC($post['lenght']);
            }


            if ($post['timelimit'] == "") {
                $timelimit = "0";
            } else {
                $timelimit = $post['timelimit'];
            }

            $oid = random_number(3) . random_number(4);


            $API = new API();
            if ($API->connect($host, $uname, $pass)) {

                $API->comm("/ip/hotspot/user/add", array(
                    'server' => $post['server'],
                    'name' => $voc[$n],
                    'password' => $voc[$n],
                    'profile' => $nameservice,
                    'limit-uptime' => $timelimit,
                    'comment' => $post['comment']

                ));

                $data = array(
                    'oid' => $oid,
                    'email' => $post['voucherfor'],
                    'service' => $nameservice,
                    'kode' => $voc[$n],
                    'harga' => $price,
                    'date' => $date,
                    'comment' => $post['comment']
                );

                $this->db->insert('orders_voucher', $data);
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('admin/router/setting'));
            }
        }
        $this->session->set_flashdata('message_success', 'Berhasil generate voucher hotspot');
        redirect(base_url('admin/voucher/hotspot/user'));
    }

    public function profile()
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();

        $data = [
            'title' => 'Profile List',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,
            'author' => $dataweb->website()->author,
            'totalhotspotprofile' => $voucher->get('services_voucher')->num_rows(),
            'hotspotprofile' => $voucher->get('services_voucher')->result(),
        ];
        $this->load->view('admin/voucher/hotspot/profile', $data);
    }

    public function addprofile()
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();
        $server = $voucher->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {


            $data = [
                'title' => 'Add User Profile',
                'logotext' => $dataweb->website()->logo_text,
                'logo' => $dataweb->website()->logo,
                'author' => $dataweb->website()->author,
            ];
            $this->load->view('admin/voucher/hotspot/addprofile', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('router/setting'));
        }
    }


    public function prosesprofile()
    {
        $voucher = new M_voucher();


        $post = $this->input->post(null, true);
        $server = $voucher->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        if ($post['mac'] == 'Ya') {
            $lock = '; [:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';
        } else {
            $lock = '';
        }

        $scheduler = '{:local usernya $user;:if ([/system schedule find name=$usernya]="") do={/system schedule add name=$usernya interval=' . $post['uptime'] . ' on-event="/ip hotspot user remove [find name=$usernya]\r\n/ip hotspot active remove [find user=$usernya]\r\n/system schedule remove [find name=$usernya]"}}' . $lock;

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $API->comm("/ip/hotspot/user/profile/add", array(
                "name" => $post['name'],
                "rate-limit" => $post['ratelimit'],
                "shared-users" => $post['shared'],
                "on-login" =>  $scheduler,
                "transparent-proxy" => $post['proxy'],
                "status-autorefresh" => "1m",
            ));

            $data = array(
                'service' => $post['name'],
                'shared' => $post['shared'],
                'ratelimit' => $post['ratelimit'],
                'uptime' => $post['uptime'],
                'harga' => $post['price'],
            );

            $this->db->insert('services_voucher', $data);
            $this->session->set_flashdata('message_success', 'Berhasil tambah user profile hotspot');
            redirect(base_url('admin/voucher/hotspot/profile'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function edit_profile_hotspot($id = null)
    {
        $voucher = new M_voucher();
        $dataweb = new M_website();


        if ($id == null) {
            redirect(base_url('admin/voucher/hotspot/profile'));
        } else {
            $service =  $voucher->where('id', $id)->get('services_voucher');
            foreach ($service->result() as $datanya) {
                $nameservice = $datanya->service;
            }

            $server = $voucher->get('router');
            foreach ($server->result() as $row) {
                $host = $row->ip;
                $uname = $row->username;
                $pass = decrypt($row->password);
            }

            $API = new API();

            if ($API->connect($host, $uname, $pass)) {
                $getpool = $API->comm("/ip/pool/print");


                $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
                    "?name" => $nameservice,
                ));


                if ($getprofile == null) {
                    $this->session->set_flashdata('message_err', 'User Profile tidak ada di mikrotik');
                    redirect(base_url('admin/voucher/hotspot/profile'));
                } else {
                    $data = [
                        'title' => 'Edit Profile',
                        'logotext' => $dataweb->website()->logo_text,
                        'logo' => $dataweb->website()->logo,
                        'author' => $dataweb->website()->author,
                        'profile' => $getprofile[0],
                        'pool' => $getpool,
                    ];
                    $this->load->view('admin/voucher/hotspot/editprofile', $data);
                }
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('router/setting'));
            }
        }
    }

    public function save_profile_hotspot()
    {
    }

    public function logs_voucher()
    {
        $voucher = new M_voucher();
        $dataweb = new M_website();

        $data = $voucher->get('logs_voucher');
        $total = $data->num_rows();
        $datavoucher = $data->result();

        $data =  [
            'title' => 'Logs Voucher',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,
            'author' => $dataweb->website()->author,
            'totaldata' => $total,
            'voucher' => $datavoucher,
        ];
        $this->load->view('admin/voucher/logs', $data);
    }

    public function report()
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();

        $data = [
            'title' => 'Report Voucher',
            'logotext' => $dataweb->website()->logo_text,
            'logo' => $dataweb->website()->logo,
            'author' => $dataweb->website()->author,
            'voucher' => $voucher->datavcrmonth(),
            'tahun' => $voucher->gettahunmasuk(),
            'credit' => $voucher->credit(),

        ];
        $this->load->view('admin/voucher/report', $data);
    }

    public function report_filter()
    {
        $dataweb = new M_website();
        $voucher = new M_voucher();

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if (empty($bulan) || empty($tahun)) {
            redirect(base_url('admin/voucher/report'));
        } else {
            if ($bulan ==  '1') {
                $sebut = 'Januari';
            } else if ($bulan == '2') {
                $sebut = 'Februari';
            } else if ($bulan == '3') {
                $sebut = 'Maret';
            } else if ($bulan == '4') {
                $sebut = 'April';
            } else if ($bulan == '5') {
                $sebut = 'Mei';
            } else if ($bulan == '6') {
                $sebut = 'Juni';
            } else if ($bulan == '7') {
                $sebut = 'Juli';
            } else if ($bulan == '8') {
                $sebut = 'Agustus';
            } else if ($bulan == '9') {
                $sebut = 'September';
            } else if ($bulan == '10') {
                $sebut = 'Oktober';
            } else if ($bulan == '11') {
                $sebut = 'November';
            } else if ($bulan == '12') {
                $sebut = 'Desember';
            }


            $data = [
                'title' => 'Report Voucher',
                'logotext' => $dataweb->website()->logo_text,
                'logo' => $dataweb->website()->logo,
                'author' => $dataweb->website()->author,
                'subtitle' => $sebut,
                'tahun' => $tahun,
                'datafilter' => $voucher->filter($bulan, $tahun),
                'credit' => $voucher->creditfilter($bulan, $tahun),

            ];

            if ($data['datafilter']->num_rows() == 0) {
                $this->session->set_flashdata('message_err', 'Tidak ada data di bulan tersebut');
                redirect(base_url('admin/voucher/report'));
            } else {
                $this->load->view('admin/voucher/report_filter', $data);
            }
        }
    }

    public function setting()
    {
        $voucher = new M_voucher();
        $dataweb = new M_website();
        $server = $voucher->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info

            $server = $API->comm("/ip/hotspot/print");
            $data = [
                'title' => 'Setting Voucher',
                'logotext' => $dataweb->website()->logo_text,
                'logo' => $dataweb->website()->logo,
                'author' => $dataweb->website()->author,
                'server' => $server,
                'voucher' => $voucher->get('setting_voucher')->result(),

            ];
            $this->load->view('admin/voucher/setting', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }
}
