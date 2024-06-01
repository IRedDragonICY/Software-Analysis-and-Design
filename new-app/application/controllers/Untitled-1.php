<?php defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['coupon_m']);
    }
    public function index()
    {
        $data['title'] = 'Kode Kupon';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['coupon'] = $this->coupon_m->get()->result();
        $this->template->load('backend', 'backend/coupon/data', $data);
    }

    public function add()
    {
        $role_id = $this->session->userdata('role_id');
        if ($role_id != 1) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $post = $this->input->post(null, TRUE);
        $this->coupon_m->add($post);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kupon berhasil ditambahkan');
        }
        redirect('coupon');
    }
    public function edit()
    {

        $role_id = $this->session->userdata('role_id');
        if ($role_id != 1) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $post = $this->input->post(null, TRUE);
        $this->coupon_m->edit($post);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kupon berhasil diperbaharui');
        }
        redirect('coupon');
    }
    public function del()
    {
        $role_id = $this->session->userdata('role_id');
        if ($role_id != 1) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $id = $this->input->post('coupon_id');

        $this->coupon_m->del($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kupon berhasil dihapus');
        }

        redirect('coupon');
    }

    public function cekcoupon()
    {
        $post = $this->input->post(null, TRUE);
        $code = $post['code'];
        $coupon = $this->db->get_where('coupon', ['code' => $code])->row_array();
        if ($coupon > 0) {
            if ($coupon['is_active'] == 1) {
                if ($coupon['one_time'] == 1) {
                    $invoice = $this->coupon_m->cekcoupon($post)->row_array();
                    if ($invoice > 0) {
                        $data = [
                            'disc' => 0,
                            'remark' => '<span style="color: red;">Kode kupon sudah anda digunakan ditagihan sebelumnya ! </span>',
                        ];
                        echo json_encode($data);
                    } else {

                        $disc = $post['amount'] * ($coupon['percent'] / 100);

                        $data = [
                            'disc' => round($disc),
                            'remark' => '<span style="color: green;">Anda mendapatkan diskon sebesar ' . indo_currency($disc) . '  </span>',
                        ];
                        echo json_encode($data);
                    }
                } else {

                    $disc = $post['amount'] * ($coupon['percent'] / 100);

                    $data = [
                        'disc' => round($disc),
                        'remark' => '<span style="color: green;">Anda mendapatkan diskon sebesar ' . indo_currency($disc) . '  </span>',
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    'disc' => 0,
                    'remark' => '<span style="color: red;">Kode kupon sudah tidak aktif !  </span>',
                ];
                echo json_encode($data);
            }
        } else {
            $data = [
                'disc' => 0,
                'remark' => '<span style="color: red;">Kode kupon tidak ditemukan !  </span>',
            ];
            echo json_encode($data);
        }
    }
}