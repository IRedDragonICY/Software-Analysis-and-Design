<?php
class Auto extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');

        $this->apikeywa = 'xSnXay3GgZv5S9Uv5rno1XdihFB1nAuP'; // API KEY WA GATEWAY
        $this->apiurlwa = 'http://wa.myserv.my.id/'; // API URL WA GATEWAY 
        $this->guzzle  = new GuzzleHttp\Client();
    }


    public function update_status()
    {
        $admin = new M_admin();

        $admin->update_status();
    }

    public function cekvoucher()
    {
        $admin = new M_admin();
        $API = new API();


        $server = $admin->get('router');

        foreach ($server->result() as $router) {
            $host = $router->ip;
            $uname = $router->username;
            $pass = decrypt($router->password);
        }
        if ($API->connect($host, $uname, $pass)) {
            $hotspotactive = $API->comm("/ip/hotspot/active/print");
            foreach ($hotspotactive as $data) {
                $kodevoucher = $data['user'];
            }

            $voucheractive = $admin->where('status_v', 'Belum digunakan')->get('orders_voucher');
            foreach ($voucheractive->result() as $voucher) {
                $kode = $voucher->kode;
                $paket = $voucher->service;
                $harga = $voucher->harga;
                $date = date('Y-m-d');
                $time = date('H:i:s');
                if ($kodevoucher == $kode) {
                    $update = array(
                        'status_v' => "Sudah digunakan",
                    );
                    $update = $admin->update('kode', $kode, 'orders_voucher', $update);

                    $datanya = array(
                        'service' => $paket,
                        'kode' => $kode,
                        'harga' => $harga,
                        'date' => $date,
                        'time' => $time,
                    );
                    $admin->input('logs_voucher', $datanya);
                }
            }
        } else {
            $whatsapp = $this->db->get('whatsapp')->result();

            foreach ($whatsapp as $gateway) {
                $sender = $gateway->sender;
                $noowner = $gateway->no_owner;
            }
            $message = 'Cek Voucher tidak berjalan, silahkan cek data router di pengaturan';

            $sendwa = [
                'api_key' => $this->apikeywa,
                'sender' => $sender,
                'number' => $noowner,
                'message' => $message,
            ];
            $res = $this->guzzle->request('POST', $this->apiurlwa . 'send-message', [
                'form_params' => $sendwa
            ]);
            $result = json_decode($res->getBody()->getContents(), true);
        }
    }

    public function isolir()
    {

        $admin = new M_admin();

        $isolir = $admin->get_where('orders', array('status' => 'Isolir'))->result();

        foreach ($isolir as $data) {
            $idpel = $data->idpel;
            $client = $data->nama;
            $users = $data->pppoe_user;

            if ($isolir == true) {
                $whatsapp = $this->db->get('whatsapp')->result();

                foreach ($whatsapp as $gateway) {
                    $sender = $gateway->sender;
                    $noowner = $gateway->no_owner;
                }
                $server = $this->db->get('router')->result();

                foreach ($server as $row) {
                    $ip = $row->ip;
                    $uname = $row->username;
                    $pass = decrypt($row->password);
                }

                $pool = $this->db->get('pool')->result();

                foreach ($pool as $data) {
                    $range = $data->poo_range;
                    $randIP = $range . mt_rand(2, 255);
                }
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
                            "remote-address" => $randIP,
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

                    $message = '
Berhasil di isolir otomatis !

ID Pelanggan ' . $idpel . '
Atas Nama ' . $client . '

';
                    $data = [
                        'api_key' => $this->apikeywa,
                        'sender' => $sender,
                        'number' => $noowner,
                        'message' => $message,
                    ];
                    $res = $this->guzzle->request('POST', $this->apiurlwa . 'send-message', [
                        'form_params' => $data
                    ]);
                    $result = json_decode($res->getBody()->getContents(), true);
                } else {

                    $message = '
*Gagal dimatikan !*
ID Pelanggan *' . $idpel . '*
Atas Nama *' . $client . '*


Silahkan cek kembali IP Publik / VPN Mikrotik anda
Atau
Isolirkan secara manual
';
                    $data = [
                        'api_key' => $this->apikeywa,
                        'sender' => $sender,
                        'number' => $noowner,
                        'message' => $message,
                    ];
                    $res = $this->client->request('POST', $this->apiurlwa . 'send-message', [
                        'form_params' => $data
                    ]);
                    $result = json_decode($res->getBody()->getContents(), true);
                }
            }
        }
    }

    public function cetakinv()
    {
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
                    $bayar = $price;
                }
                $checkinvoice = $admin->get_where('invoice', array('idpel' => $idpel, 'status' => 'Unpaid'));

                $datainvoice = $checkinvoice->num_rows();
                if ($datainvoice > 0) {
                    echo "Sudah ada data invoice, ID Pelanggan : $idpel <br/>";
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
                }
            }
        }
    }

    public function simulatedisc()
    {
        $harga = '150000';
        $ppn = '11';
        $disc = '30';

        $total = $harga + $harga * $ppn / 100;

        $hasilnya = $total;
        $discount = $hasilnya - $hasilnya * $disc / 100;
        $hasil = $hasilnya - $disc / 100;

        echo $discount;
    }
}
