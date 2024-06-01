<?php

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_member');
        $this->load->model('M_admin');
    }

    public function ambilcategory()
    {
        $member = new M_member();
        if (isset($_POST['category'])) {
            $category = $this->input->post('category');
            $data = $member->where('category', $category)->where('status', '1')->get('payment_method');
?>
            <option value="0"> Pilih salah satu ...</option>
            <?php
            foreach ($data->result() as $row) {
            ?>
                <option value="<?= $row->id ?>"> <?= $row->service ?></option>
            <?php
            }
        } else {
            ?>
            <option value="0">Error..</option>
            <?php
        }
    }

    public function ambilservice()
    {
        $member = new M_member();

        if (isset($_POST['service'])) {
            $service = $this->input->post('service');
            $data = $member->where('service', $service)->get('services_voucher');
            if ($data->num_rows() == 1) {
                foreach ($data->result() as $row) {
            ?>
                    <div class="row mb-3">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                <input type="text" class="form-control" id="harga" name="harga" value="Rp <?php echo number_format($row->harga, 0, ',', '.'); ?>" disabled>
                            </div>
                        </div>
                    </div>


                <?php
                }
            } else {
                ?>
                <div class="alert alert-danger alert-style-light" role="alert">
                    Silahkan pilih paket terlebih dahulu !
                </div>

<?php
            }
        } else {
            redirect(base_url());
        }
    }

    public function update_payment_method()
    {
        $admin = new M_admin();
        $status = $this->input->post('status');
        if ($status == null) {
            redirect(base_url());
        } else {
            $kode = $this->input->post('kodepm');
            $update = $admin->update_payment_method($status, $kode);
            if ($update) {
                $this->session->set_flashdata('message_success', 'Berhasil edit data');
            } else {
                $this->session->set_flashdata('message_err', 'Gagal');
            }
        }
    }


    public function cekcoupon()
    {
        $admin = new M_admin();

        $post = $this->input->post(null, TRUE);
        $code = $post['code'];
        $coupon = $this->db->get_where('coupon', ['code' => $code])->row_array();
        if ($coupon > 0) {
            if ($coupon['status'] == 'Enable') {
                if ($coupon['otp'] == 'ya') {
                    $invoice = $admin->cekcoupon($post)->row_array();
                    if ($invoice > 0) {
                        $data = [
                            'disc' => 0,
                            'remark' => '<span style="color: red;">Kode kupon sudah anda gunakan ditagihan sebelumnya ! </span>',
                        ];
                        echo json_encode($data);
                    } else {

                        $disc = $post['tagihan'] * ($coupon['rate'] / 100);

                        $data = [
                            'disc' => round($disc),
                            'remark' => '<span style="color: green;">Anda mendapatkan diskon sebesar Rp ' . number_format($disc) . '  </span>',
                        ];
                        echo json_encode($data);
                    }
                } else {

                    $disc = $post['tagihan'] * ($coupon['rate'] / 100);

                    $data = [
                        'disc' => round($disc),
                        'remark' => '<span style="color: green;">Anda mendapatkan diskon sebesar Rp ' . number_format($disc) . '  </span>',
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
    public function deletevoucherbycomment($comment)
    {
        $admin = new M_admin();
        $server = $admin->get('router');

        $data = $admin->where('comment', $comment)->get('orders_voucher');
        $totaldata = $data->num_rows();
        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }
        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?comment" => "$comment",
                "?uptime" => "00:00:00",
            ));

            for ($i = 0; $i < $totaldata; $i++) {
                $usersdetails = $getuser[$i];
                $uid = $usersdetails['.id'];

                $API->comm("/ip/hotspot/user/remove", array(
                    ".id" => "$uid",
                ));
            }
            $where = array('comment' => $comment);
            $admin->delete('orders_voucher', $where);
            $this->session->set_flashdata('message_success', 'Berhasil menghapus data voucher');

            redirect(base_url('admin/voucher/hotspot/user'));
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function delete_profile_hotspot($service)
    {
        $admin = new M_admin();
        $server = $admin->get(' router');
        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }
        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
                "?name" => $service,
            ));

            if ($getprofile == null) {
                $this->session->set_flashdata('message_err', 'User Profile tidak ada di mikrotik');
                redirect(base_url('admin/voucher/hotspot/profile'));
            } else {
                foreach ($getprofile as $data) {
                    $id = $data['.id'];
                    $idstr = str_replace('*', '', $id);
                }
                $API->comm("/ip/hotspot/user/profile/remove", array(
                    ".id" =>  $idstr,
                ));
                $where = array(
                    "service" => $service,
                );
                $admin->delete('services_voucher', $where);
                $this->session->set_flashdata('message_success', 'Profile berhasil di hapus');
                redirect('admin/voucher/hotspot/profile');
            }
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }

    public function delete_profile_ppp($id = null)
    {
        if ($id == null) {
            redirect(base_url('admin/router/ppp/profile'));
        }

        $admin = new M_admin();
        $server = $admin->get(' router');
        foreach ($server->result_array() as $row) {
            $host = $row['ip'];
            $uname = $row['username'];
            $pass = decrypt($row['password']);
        }

        $API = new API();
        if ($API->connect($host, $uname, $pass)) {
            $API->comm("/ppp/profile/remove", array(
                ".id" => '*' . $id,
            ));
            $this->session->set_flashdata('message_success', 'Profile berhasil di hapus');
            redirect('admin/router/ppp/profile');
        } else {
            $this->session->set_flashdata('message_err', 'Mikrotik tidak konek ! Harap dicek kembali data mikrotik anda');
            redirect(base_url('admin/router/setting'));
        }
    }
}
