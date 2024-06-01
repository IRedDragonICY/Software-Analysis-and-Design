<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth');
        $this->load->model('M_website');
    }

    public function index()
    {
        redirect(base_url('auth/signin'));
    }

    public function signin()
    {
        $onlogin = $this->session->userdata('status', 'login');
        if ($onlogin) {
            redirect(base_url());
            return;
        }

        $dataweb = new M_website();
        $data = [
            'title' => $dataweb->website()->title,
            'titleweb' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
        ];
        $this->load->view('auth/signin', $data);
    }

    public function do_signin()
    {
        $email = htmlspecialchars($this->input->POST('email'));
        $password = $this->input->POST('password');


        $user = $this->db->where('email', $email)->or_where('nomor', $email)
            ->get('users')->row_array();

        $sqlcek = $this->db->query("SELECT * FROM customer WHERE email = '$email' OR nomor = '$email'")->result_array();
        $data = $sqlcek[0];


        if ($user) {
            if ($user['level'] == 'admin') {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'level' => $user['level'],
                        'nohp' => $user['nomor'],
                        'status' => "login",
                    ];
                    $this->session->set_userdata($data);
                    redirect(base_url('admin'));
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Password salah !</div>');
                    $this->session->set_flashdata('message_err', 'Password Salah !');

                    redirect(base_url('auth/signin'));
                }
            } else if ($user['level'] == 'developer') {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'level' => $user['level'],
                        'nohp' => $user['nomor'],
                        'status' => "login",
                    ];
                    $this->session->set_userdata($data);
                    redirect(base_url('admin'));
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Password salah !</div>');
                    $this->session->set_flashdata('message_err', 'Password Salah !');

                    redirect(base_url('auth/signin'));
                }
            } else if ($user['level'] == 'user') {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'idpel' => $data['idpel'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'level' => $user['level'],
                        'nohp' => $user['nomor'],
                        'status' => "login",
                    ];
                    $this->session->set_userdata($data);
                    redirect(base_url('user'));
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Password salah !</div>');
                    $this->session->set_flashdata('message_err', 'Password Salah !');

                    redirect(base_url('auth/signin'));
                }
            } else if ($user['level'] == 'member') {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'level' => $user['level'],
                        'nohp' => $user['nomor'],
                        'status' => "login",
                    ];
                    $this->session->set_userdata($data);
                    redirect(base_url('member'));
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Password salah !</div>');
                    $this->session->set_flashdata('message_err', 'Password Salah !');
                    redirect(base_url('auth/signin'));
                }
            } else if ($user['level'] == 'reseller') {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'level' => $user['level'],
                        'nohp' => $user['nomor'],
                        'status' => "login",
                    ];
                    $this->session->set_userdata($data);
                    redirect(base_url('reseller'));
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Password salah !</div>');
                    $this->session->set_flashdata('message_err', 'Password Salah !');
                    redirect(base_url('auth/signin'));
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Email tidak terdaftar !</div>');
                $this->session->set_flashdata('message_err', 'Email tidak terdaftar !');

                redirect(base_url('auth/signin'));
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Email tidak terdaftar !</div>');
            $this->session->set_flashdata('message_err', 'Email tidak terdaftar !');
            redirect(base_url('auth/signin'));
        }
    }

    public function signout()
    {
        session_destroy();
        redirect(base_url('auth/signin'));
    }

    public function forgot()
    {
        $dataweb = new M_website();
        $data = [
            'title' => $dataweb->website()->title,
            'titleweb' => $dataweb->website()->logo_text,
            'author' => $dataweb->website()->author,
        ];
        $this->load->view('auth/forgot-password', $data);
    }
    public function sendforgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array(
            'required' => 'Email Wajib Di isi.',
            'valid_email' => 'Masukan Email Dengan Benar',
        ));
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Data belum terisi</div>');
            $this->session->set_flashdata('message_err', 'Data belum terisi !');

            redirect('auth/forgot');
        } else {
            $email = $this->input->post('email');
            $sqlcek = $this->db->get_where('users', ['email' => $email])->row_array();
            $cekdata = $this->db->query("SELECT * FROM users WHERE email = '$email'")->result_array();
            $datapengguna = $cekdata[0];


            // $nama = $datapengguna['nama'];
            // 
            // print("<pre>" . print_r($nama, true) . "</pre>");
            // die;


            if ($sqlcek) {
                $token = md5($email . date("d-m-Y H:i:s"));
                $data = array(
                    'data_token' => $token,
                    'email' => $email,
                    'date_create' => time()
                );
                $this->db->insert('token_user', $data);

                $smtp = $this->db->query("SELECT * FROM smtp_setting WHERE id = '1'");
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
                $sendSmtpEmail['params'] = array('subject' => 'Request Reset Password Members Fiber Delta Network');

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
                <p>Hai ' . $datapengguna['nama'] . '</a></p>
                <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                Ada permintaan untuk mengubah kata sandi Anda! Jika Anda tidak membuat permintaan ini, abaikan email ini. Jika tidak, silakan klik di bawah ini untuk mengubah kata sandi Anda
                </p>
                <a href="' . base_url('auth/resetpassword?email=' . $this->input->post('email') . '&token=' . $token) . '"
                style="background:#4054B2;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
                Password</a>
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
                    array('email' => $email)
                );

                $sendSmtpEmail['replyTo'] = array('email' => 'noreply@vpnkuid.my.id', 'name' => 'System FDN');
                if ($apiInstance->sendTransacEmail($sendSmtpEmail)) {
                    $this->session->set_flashdata('message_success', 'Berhasil Reset Password Harap Cek inbox / spam !');
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                    Berhasil Reset Password Harap Cek inbox / spam !
                        </div>');
                    redirect('auth/forgot');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                              Gagal, ada kesalahan pada sistem
                            </div>');
                    redirect('auth/forgot');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                          Email Tidak Ada 
                        </div>');
                redirect('auth/forgot');
            }
        }
    }
    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $sqlcek = $this->db->get_where('users', ['email' => $email])->row_array();
        if ($sqlcek) {
            $sqlcek_token = $this->db->get_where('token_user', ['data_token' => $token])->row_array();
            if ($sqlcek_token) {
                $this->session->set_userdata('resetemail', $email);
                $this->changepassword();
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
						  Gagal ! Token Salah
						</div>');
                redirect('auth/signin');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
						  Gagal ! Email Salah
						</div>');
            redirect('auth/signin');
        }
    }
    public function changepassword()
    {
        if (!$this->session->userdata('resetemail')) {
            redirect('login');
        }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[8]', array(
            'min_length' => 'Password Minimal 8 Karakter.'
        ));
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|required|min_length[8]|matches[password1]', array(
            'matches' => 'Password Tidak Sama.',
            'min_length' => 'Password Minimal 8 Karakter.'
        ));


        if ($this->form_validation->run() == false) {
            $website = $this->ModelWebsite->website();

            $data = [
                'title' => $website->title,
                'titleweb' => $website->logo_text,
                'author' => $website->author,
            ];

            $this->load->view('reset-password', $data);
        } else {
            $email = $this->session->userdata('resetemail');
            $update = array(
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT)
            );
            $where = array('email' => $email);
            $this->db->update('users', $update, $where);
            $this->session->unset_userdata('resetemail');
            $this->db->delete('token_user', ['email' => $email]);
            $this->session->set_flashdata('message_success', 'Password berhasil di ganti ! ');

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
					Password berhasil di ganti, silahkan login kembali
					</div>');
            redirect('auth/signin');
        }
    }
}
