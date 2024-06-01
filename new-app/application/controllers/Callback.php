<?php

class Callback extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('TripayPayment');
        $this->load->model('M_callback');
    }


    public function TripayCallback()
    {
        $m_callback = new M_callback();
        $check = $m_callback->where('name', 'tripay')->get('payment_gateway');
        $data = $check[0];

        $api = $data->api_url;
        $code = $data->code_merchant;
        $key = $data->api_key;
        $private = $data->private_key;
        $callback = $data->callback;

        $tripay = new TripayPayment($api, $code, $key, $private, $callback);


        if ($tripay->verifyCallback($callback) !== true) {
            exit("Callback verification failed: " . $tripay->lastError);
        }

        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $event = isset($_SERVER['HTTP_X_CALLBACK_EVENT']) ? $_SERVER['HTTP_X_CALLBACK_EVENT'] : '';



        if ($event == 'payment_status') {
            if ($data->status == 'PAID') {
                $uniqueRef  = $data->merchant_ref;

                if ($result = $m_callback->where('code', $uniqueRef)->where('status', 'Unpaid')->where('account', 'user')->first('invoice')) {


                    date_default_timezone_set('Asia/Jakarta');

                    $date = date("Y-m-d");

                    $expdate = $result->expdate;
                    $user = $result->nama;
                    $idpel = $result->idpel;
                    $kodebaru = $uniqueRef;
                    $bayar = $result->price;
                    $package = $result->package;


                    $tgl2 = date('Y-m-d', strtotime('+1 month', strtotime($expdate)));

                    $orders = $this->db->query("SELECT * FROM orders WHERE idpel = $idpel ");

                    foreach ($orders->result() as $dataorders) {
                        $statusorder = $dataorders->status;
                        $jenis = $dataorders->jenis;
                        $users = $dataorders->pppoe_user;
                    }

                    if ($statusorder == 'Isolir') {

                        // ambil data mikrotik server
                        $server = $this->db->query("SELECT * FROM router WHERE id = '1'");

                        foreach ($server->result() as $row) {
                            $ip = $row->ip;
                            $uname = $row->username;
                            $pass = decrypt($row->password);
                        }

                        if ($jenis == 'statis') {
                            $static = $dataorders->ipstatik;

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
                    }


                    $cekuser = $this->db->query("SELECT * FROM customer WHERE nama = '$user'")->result();
                    $nomor = $cekuser[0]->nomor;


                    // Kirim Notifikasi ke client
                    $whatsapp = $this->db->query("SELECT * FROM whatsapp WHERE id = '1'")->result();

                    foreach ($whatsapp as $gateway) {
                        $APIUrl = $gateway->api_url;
                        $APIKey = $gateway->api_key;
                        $sender = $gateway->sender;
                        $message = $gateway->tagihan_terbayar;
                    }


                    $message = str_replace("{nama_customer}", $user, $message);
                    $message = str_replace("{id_pelanggan}", $idpel, $message);
                    $message = str_replace("{nomor_invoice}", $kodebaru, $message);

                    $data = [
                        'api_key' => $APIKey,
                        'sender' => $sender,
                        'number' => $nomor,
                        'message' => $message,
                    ];
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $APIUrl . 'send-message',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($data),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);

                    $company = $this->db->query("SELECT * FROM company WHERE id = '1' ")->result();

                    $company = [
                        'address' => $company[0]->address,
                        'city' => $company[0]->city,
                        'province' => $company[0]->province,
                        'country' => $company[0]->country,
                        'postal' => $company[0]->postal_code,
                    ];

                    $website = $this->db->query("SELECT * FROM website WHERE id = '1 '")->result();

                    $website = [
                        'title' => $website[0]->title,
                        'logo' => $website[0]->logo,
                    ];

                    $base_url = base_url();


                    $pdfhtml = [
                        'code' => $kodebaru,
                        'idpel' => $idpel,
                        'nama' => $user,
                        'package' => $package,
                        'price' => $bayar,
                        'status' => 'Paid',
                        'date' => $date,
                        'expdate' => $expdate,
                    ];

                    $html['website'] = $website;
                    $html['company'] = $company;

                    $html['cetak'] = $pdfhtml;

                    $mpdf = new \Mpdf\Mpdf();
                    $pdfFilePath = "data/invoice/paid/Paid-" . $kodebaru . ".pdf";
                    $html = $this->load->view('invoice', $html, true);
                    $mpdf->writehtml($html);
                    $mpdf->output($pdfFilePath);

                    $data = [
                        'api_key' => $APIKey,
                        'sender' => $sender,
                        'number' => $nomor,
                        'url' => $base_url . $pdfFilePath
                    ];
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $APIUrl . 'send-document',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($data),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);

                    $update = array(
                        'status' => 'Paid',
                        'last_update' => $date,
                        'update_by' => 'System Payment Gateway Tripay',
                        'data_invoice' => $pdfFilePath,

                    );
                    $this->db->where('code', $result->code);
                    $this->db->update('invoice', $update);



                    $update_orders = array(
                        'status' => 'Active',
                        'expdate' => $tgl2,
                    );
                    $this->db->where('idpel', $result->idpel);
                    $this->db->update('orders', $update_orders);

                    echo json_encode(['success' => true]);
                    exit;
                } else if ($result = $m_callback->where('code', $uniqueRef)->where('status', 'Unpaid')->where('account', 'member')->first('invoice')) {

                    date_default_timezone_set('Asia/Jakarta');
                    $date = date("Y-m-d H:i:s");


                    $user = $result->nama;
                    $kodebaru = $uniqueRef;
                    $price = $result->price;

                    $update = array(
                        'status' => 'Paid',
                        'last_update' => $date,
                        'update_by' => 'System Payment Gateway',
                    );

                    $input = $this->db->where('code', $uniqueRef);
                    $input = $this->db->update('invoice', $update);

                    if ($input == true) {
                        $this->db->query("UPDATE users SET balance = balance+$price WHERE email = '$user' ");
                    }
                }
            } else {
                echo json_encode(['error' => 'Unrecognized payment status']);
                exit;
            }
        } else {
            exit('Invalid callback event, no action was taken');
        }
    }
}
