<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Router extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');
        $this->load->model('M_website');

        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('login'));
        } else if ($this->session->userdata('level') !=  'developer') {
            redirect(base_url('home'));
        }
    }



    public function index()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');


        if ($server->num_rows() == 0) {
            redirect(base_url('admin/router/setup'));
        } else {
            foreach ($server->result_array() as $row) {
                $host = $row['ip'];
                $uname = $row['username'];
                $pass = decrypt($row['password']);
                $inter = $row['traffic-interface'];
            }

            $API = new API();
            if ($API->connect($host, $uname, $pass)) {

                // get hotspot info
                $hotspotuser = $API->comm("/ip/hotspot/user/print");
                $hotspotactive = $API->comm("/ip/hotspot/active/print");
                $hotspotprofile = $API->comm("/ip/hotspot/user/profile/print");

                //get ppp info

                $pppsecret = $API->comm("/ppp/secret/print");
                $pppactive = $API->comm("/ppp/active/print");
                $pppprofile = $API->comm("/ppp/profile/print");

                //get mikrotik system clock
                $getclock = $API->comm("/system/clock/print");
                $clock = $getclock[0];
                $timezone = $getclock[0]['time-zone-name'];

                // get MikroTik system clock
                $getresource = $API->comm("/system/resource/print");
                // print("<pre>" . print_r($getresource[0], true) . "</pre>");
                // die;
                $resource = $getresource[0];

                // get routeboard info
                $getrouterboard = $API->comm("/system/routerboard/print");

                // print("<pre>" . print_r($getrouterboard[0], true) . "</pre>");
                // die;

                $routerboard = $getrouterboard[0];


                //get interface
                $getinterface = $API->comm("/interface/print");

                //get intraface db
                $monitor = $inter;


                $data = [
                    'title' => 'Dashboard Mikrotik',
                    'logo' => $dataweb->website()->logo,
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'hotspotuser' => count($hotspotuser),
                    'hotspotactive' => count($hotspotactive),
                    'hotspotprofile' => count($hotspotprofile),
                    'pppuser' => count($pppsecret),
                    'pppactive' => count($pppactive),
                    'pppprofile' => count($pppprofile),
                    'clock' => $clock['time'],
                    'uptime' => $resource['uptime'],
                    'timezone' => $timezone,
                    'model' => $routerboard['model'],
                    'architecture' => $resource['architecture-name'],
                    'version' => $resource['version'],
                    'interface' => $getinterface,
                    'traffics' => $monitor,



                ];

                $this->load->view('admin/router/index', $data);
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('admin/router/setting'));
            }
        }
    }

    public function traffic()
    {
        $admin = new M_admin();
        $server = $admin->get('router');


        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
            $interfaces =  $row['traffic-interface'];
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            $getinterface = $API->comm("/interface/monitor-traffic", array(
                'interface' => $interfaces,
                'once' => '',
            ));

            $rows = array();
            $rows2 = array();


            $ftx = $getinterface[0]['rx-bits-per-second'];
            $frx = $getinterface[0]['tx-bits-per-second'];

            $rows['name'] = 'Tx';
            $rows['data'][] = $ftx;
            $rows2['name'] = 'Rx';
            $rows2['data'][] = $frx;
            $result = array();

            array_push($result, $rows);
            array_push($result, $rows2);
            print json_encode($result);
        }
    }

    public function router_setup()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        if ($server->num_rows() > 0) {
            redirect(base_url('admin/router'));
        } else {
            $data = [
                'title' => 'Dashboard Admin',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
            ];
            $this->load->view('admin/router/setup', $data);
        }
    }

    public function router_save()
    {
        $admin = new M_admin();

        $post = $this->input->post(null, true);

        $input = array(
            'nama' => $post['name'],
            'dns' => $post['dns'],
            'ip' => $post['host'],
            'username' => $post['username'],
            'password' => encrypt($post['password']),
            'traffic-interface' => $post['traffic-interface'],
        );

        $admin->input('router', $input);
        $this->session->set_flashdata('message_success', 'Berhasil menambahkan router baru');
        redirect(base_url('admin/router/setting'));
    }



    public function hotspot_users()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');


        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info
            $hotspotuser = $API->comm("/ip/hotspot/user/print");

            $hotspotuser = json_encode($hotspotuser);
            $hotspotuser = json_decode($hotspotuser, true);

            $data = [
                'title' => 'Hotspot Users',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'totalhotspotuser' => count($hotspotuser),
                'hotspotuser' => $hotspotuser,


            ];
            $this->load->view('admin/router/hotspot/users', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function hotspot_adduser()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info
            $hotspotuser = $API->comm("/ip/hotspot/user/print");

            $server = $API->comm("/ip/hotspot/print");
            $profile = $API->comm("/ip/hotspot/user/profile/print");


            $data = [
                'title' => 'Hotspot Add User',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'totalhotspotuser' => count($hotspotuser),
                'hotspotuser' => $hotspotuser,
                'server' => $server,
                'profile' => $profile,


            ];
            $this->load->view('admin/router/hotspot/adduser', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }



    public function hotspot_active()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info
            $hotspotactive = $API->comm("/ip/hotspot/active/print");


            $data = [
                'title' => 'Hotspot Active',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'totalhotspotactive' => count($hotspotactive),
                'hotspotactive' => $hotspotactive,


            ];
            $this->load->view('admin/router/hotspot/active', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function hotspot_deleteactive($id = null)
    {
        $admin = new M_admin();



        if ($id == null) {
            redirect(base_url('hotspot/active'));
        } else {
            $server = $admin->get('router');

            foreach ($server->result_array() as $row) {
                $host = $row['ip'];
                $uname = $row['username'];
                $pass = decrypt($row['password']);
            }

            $API = new API();
            if ($API->connect($host, $uname, $pass)) {
                $API->comm("/ip/hotspot/active/remove", array(
                    ".id" => '*' . $id,
                ));
                $this->session->set_flashdata('message_success', 'User tersebut berhasil di hapus dari hotspot active');
                redirect('admin/router/hotspot/active');
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('admin/router/setting'));
            }
        }
    }

    public function ppp_profile()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info
            $getprofile = $API->comm("/ppp/profile/print");
            $countprofile =  count($getprofile);

            $getpool = $API->comm("/ip/pool/print");

            $getallqueue = $API->comm("/queue/simple/print", array(
                "?dynamic" => "false",
            ));
            $data = [
                'title' => 'PPP Profile',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'totalprofile' => $countprofile,
                'getprofile' => $getprofile,
                'pool' => $getpool,
                'queue' => $getallqueue,


            ];
            $this->load->view('admin/router/ppp/profile', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function addprofile()
    {
        $admin = new M_admin();

        $post = $this->input->post(null, true);

        $server = $admin->get('router');
        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $API->comm("/ppp/profile/add", array(
                "name" => $post['name'],
                "local-address" => $post['localaddr'],
                "remote-address" => $post['remoteaddr'],
                "rate-limit" => $post['ratelimit'],
                "only-one" => $post['onlyone'],
                "parent-queue" => $post['parent']
            ));

            $this->session->set_flashdata('message_success', 'Berhasil tambah profil ppp');
            redirect(base_url('admin/router/ppp/profile'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function ppp_edit_profile($id = null)
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        if ($id == null) {
            redirect(base_url('admin/router/ppp/profile'));
        } else {
            $server = $admin->get('router');

            foreach ($server->result_array() as $row) {
                $host = $row['ip'];
                $uname = $row['username'];
                $pass = decrypt($row['password']);
            }

            $API = new API();
            if ($API->connect($host, $uname, $pass)) {

                $getpool = $API->comm("/ip/pool/print");
                $getprofile = $API->comm("/ppp/profile/print", array(
                    "?.id" => '*' . $id,
                ));


                $data = [
                    'title' => "Edit Profile",
                    'logo' => $dataweb->website()->logo,
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'profile' => $getprofile[0],
                    'pool' => $getpool,
                ];
                $this->load->View('admin/router/ppp/edit-profile', $data);
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('admin/router/setting'));
            }
        }
    }

    public function saveprofile()
    {
        $post = $this->input->post(null, true);
        $admin = new M_admin();

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }


        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $secretid = $post['edit-id'];

            $updt['.id'] = $secretid;
            $updt['name'] = $post['user'];
            $updt['rate-limit'] = $post['ratelimit'];

            $localaddr = $post['localaddr'];
            if ($localaddr != "") {
                $updt['local-address'] = $localaddr;
            }
            $remoteaddr = $post['remoteaddr'];
            if ($remoteaddr != "") {
                $updt['remote-address'] = $remoteaddr;
            } else {
                $API->comm("/ppp/profile/unset", array(
                    ".id" => $secretid,
                    "value-name" => "remote-address"
                ));
            }

            $API->comm("/ppp/profile/set", $updt);

            $this->session->set_flashdata('message_success', 'Berhasil edit profile');
            redirect(base_url('admin/router/ppp/profile'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function ppp_secret()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info
            $getsecret = $API->comm("/ppp/secret/print");
            $countsecret =  count($getsecret);
            $getprofile = $API->comm("/ppp/profile/print");


            $data = [
                'title' => 'PPP Secret',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'totalsecret' => $countsecret,
                'getsecret' => $getsecret,
                'profile' => $getprofile,

            ];
            $this->load->view('admin/router/ppp/secret', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function addsecret()
    {
        $post = $this->input->post(null, true);
        $admin = new M_admin();

        $server = $admin->get('router');
        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $API->comm("/ppp/secret/add", array(
                'name' => $post['name'],
                'password' => $post['password'],
                'service' => $post['service'],
                'profile' => $post['profile'],
                "remote-address" => $post['remoteaddr'],
            ));
            $this->session->set_flashdata('message_success', 'Berhasil tambah secret');
            redirect(base_url('admin/router/ppp/secret'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function ppp_edit_secret($id = null)
    {
        $admin = new M_admin();
        $dataweb = new M_website();
        if ($id == null) {
            redirect(base_url('ppp/secret'));
        } else {
            $server = $admin->get('router');

            foreach ($server->result_array() as $row) {
                $host = $row['ip'];
                $uname = $row['username'];
                $pass = decrypt($row['password']);
            }

            $API = new API();
            if ($API->connect($host, $uname, $pass)) {
                $getsecret = $API->comm("/ppp/secret/print", array(
                    "?.id" => '*' . $id,
                ));


                $getprofile = $API->comm("/ppp/profile/print");


                $data = [
                    'title' => "Edit Secret",
                    'logo' => $dataweb->website()->logo,
                    'logotext' => $dataweb->website()->logo_text,
                    'author' => $dataweb->website()->author,
                    'secret' => $getsecret[0],
                    'profile' => $getprofile,
                ];
                $this->load->View('admin/router/ppp/edit-secret', $data);
            } else {
                $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
                redirect(base_url('admin/router/setting'));
            }
        }
    }

    public function ppp_proses_edit()
    {
        $admin = new M_admin();

        $post = $this->input->post(null, true);

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }


        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $secretid = $post['edit-id'];

            $localaddr = $post['localaddr'];
            $remoteaddr = $post['remoteaddr'];

            if ($localaddr != null) {
                $localaddr;
            } else {
                $API->comm("/ppp/secret/unset", array(
                    ".id" => $secretid,
                    "value-name" => "local-address"
                ));
            }
            if ($remoteaddr != null) {
                $remoteaddr;
            } else {
                $API->comm("/ppp/secret/unset", array(
                    ".id" => $secretid,
                    "value-name" => "remote-address"
                ));
            }

            $API->comm("/ppp/secret/set", array(

                ".id" => $secretid,
                "name" => $post['user'],
                "password" => $post['password'],
                "profile" => $post['profile'],
                "local-address" => $localaddr,
                "remote-address" => $remoteaddr,
                "service" => $post['service'],
            ));


            $this->session->set_flashdata('message_success', 'Berhasil edit secret');
            redirect(base_url('admin/router/ppp/secret'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function ppp_active()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {

            // get hotspot info
            $getsecret = $API->comm("/ppp/active/print");
            $countsecret =  count($getsecret);


            $data = [
                'title' => 'PPP Active',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'totalsecret' => $countsecret,
                'getsecret' => $getsecret,
            ];
            $this->load->view('admin/router/ppp/active', $data);
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }




    public function setting()
    {
        $admin = new M_admin();
        $dataweb = new M_website();

        $server = $admin->get('router');

        if ($server->num_rows() == 0) {
            redirect(base_url('admin/router/setup'));
        } else {
            $data = [
                'title' => 'Pengaturan Router',
                'logo' => $dataweb->website()->logo,
                'logotext' => $dataweb->website()->logo_text,
                'author' => $dataweb->website()->author,
                'router' => $server->result_array(),
            ];

            $this->load->view('admin/router/setting', $data);
        }
    }

    public function update()
    {

        $admin = new M_admin();

        $server = $admin->get('router');

        foreach ($server->result() as $router) {
            $target = $router->id;
        }

        $post = $this->input->post(null);

        $update = array(
            'nama' => $post['name'],
            'dns' => $post['dns'],
            'ip' => $post['host'],
            'username' => $post['username'],
            'password' => encrypt($post['password']),
            'traffic-interface' => $post['traffic-interface'],
        );

        $admin->update('id', $target, 'router', $update);
        $this->session->set_flashdata('message_success', 'Data mikrotik berhasil diganti ');
        redirect(base_url('router/setting'));
    }

    public function ping()
    {
        $admin = new M_admin();


        $server = $admin->get('router');


        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }
        $API = new API();
        $API->debug = false;
        if ($API->connect($host, $uname, $pass)) {
            $this->session->set_flashdata('message_success', 'Mikrotik berhasil konek ! silahkan lanjutkan ke halaman dashboard');
            redirect(base_url('admin/router/setting'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }
}
