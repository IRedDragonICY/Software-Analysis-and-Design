<?php defined('BASEPATH') or exit('No direct script access allowed');

public function checkout()
    {
        is_logged_in();
        $post = $this->input->post(null, TRUE);
        $customer = $this->db->get_where('customer', ['no_services' => $post['no_services']])->row_array();
        $invoice = $this->db->get_where('invoice', ['invoice' => $post['invoice']])->row_array();
        $pg = $this->db->get('payment_gateway')->row_array();
        if ($pg['mode'] == 1) {
            $url = "https://tripay.co.id/api/transaction/create"; // Production
        } else {
            $url = 'https://tripay.co.id/api-sandbox/transaction/create'; // Sandbox
        }
        $company = $this->db->get('company')->row_array();
        $apiKey =  $pg['api_key'];
        $privateKey =  $pg['server_key'];
        $merchantCode =  $pg['kodemerchant'];
        $merchantRef = substr(intval(rand()), 0, 3) . '-' . $post['invoice'];
        $amount = $post['amount'];
        $hari = $pg['expired'] * 24;
        $data = [
            'method'            => $post['selectpaymenttripay'],
            'merchant_ref'      => $merchantRef,
            'amount'            => $amount,
            'customer_name'     => $customer['name'],
            'customer_email'    => $customer['email'],
            'customer_phone'    => $customer['no_wa'],
            'order_items'       => [
                [
                    'sku'       => $company['company_name'],
                    'name'      => 'Tagihan Internet ' . $post['no_services'] . ' Periode ' . indo_month($invoice['month']) . ' ' . $invoice['year'],
                    'price'     => $amount,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => base_url('tripay'),
            'return_url'        => base_url('member'),
            'expired_time'      => (time() + ($hari * 60 * 60)), // 24 jam
            'signature'         => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $url,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $apiKey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        // $response = json_encode($response);
        $response = json_decode($response, true);
        // echo $response;
        // echo !empty($err) ? $err : $response;
        if (!empty($post['codecoupontripay'])) {
            $code = $post['codecoupontripay'];
            $disc = $post['disccoupontripay'];
        } else {
            $code = '';
            $disc = '';
        }
        if ($response['success'] == 'true') {
            $update = [
                'x_external_id' => $response['data']['merchant_ref'],
                'transaction_time' => time(),
                'x_method' => $post['selectpaymenttripay'],
                'x_account_number' => $response['data']['pay_code'],
                'x_amount' => $response['data']['amount'],
                'expired' => $pg['expired'],
                'code_coupon' => $code,
                'disc_coupon' => $disc,
                'payment_url' => $response['data']['checkout_url'],
            ];
            $this->db->where('invoice', $post['invoice']);
            $this->db->update('invoice', $update);
            redirect($response['data']['checkout_url']);
        } else {
            echo "Chekout Gagal, silahkan hubungi developer website anda <br>";
            echo $err;
        }
    }