<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reseller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_reseller');
        $this->load->model('M_website');

        $this->nama = $this->session->userdata('nama');
        $this->level = $this->session->userdata('level');
        $this->email = $this->session->userdata('email');
        $this->onlogin = $this->session->userdata('status', 'login');

        $this->apikeywa = 'xSnXay3GgZv5S9Uv5rno1XdihFB1nAuP'; // API KEY WA GATEWAY
        $this->apiurlwa = 'http://wa.myserv.my.id/'; // API URL WA GATEWAY 


        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth/signin'));
        } else if ($this->session->userdata('level') === 'developer' || $this->session->userdata('level') === 'admin') {
            redirect(base_url('admin'));
        } else if ($this->session->userdata('level') == 'user') {
            redirect(base_url('user'));
        } else if ($this->session->userdata('level') == 'member') {
            redirect(base_url('member'));
        }
    }

    public function index()
    {
        $reseller = new M_reseller();
        $dataweb = new M_website();


        $data = [
            'title' => 'Dashboard Reseller',
            'logotext' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
            'content' => $reseller->where('email', $this->email)->get('users')->result(),
            'totalorder' => $reseller->where('email', $this->email)->get('orders_voucher')->num_rows(),
            'totalnya' => $reseller->where('email', $this->email)->get('orders_voucher')->result(),
            'ordertoday' => $reseller->today($this->email),
            'voctoday' => $reseller->voctoday($this->email),
            'orderyesterday' => $reseller->yesterday($this->email),
            'vocyesterday' => $reseller->vcrystrdy($this->email),
            'totalincome' => $reseller->totalincome($this->email),
            'profitmonth' => $reseller->profitmonth($this->email),
            'profitprevmonth' => $reseller->profitprevmonth($this->email),
        ];
        $this->load->view('reseller/home', $data);
    }
}
