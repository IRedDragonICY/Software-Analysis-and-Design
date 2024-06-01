<?php

class TripayControllers
{

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI = &get_instance();
    }
    public function getPaymentChannels($payload)
    {

        $payload = ['code' => $payload];

        $payment_gateway = $this->CI->db->query("SELECT * FROM payment_gateway WHERE name = 'tripay' AND status = 'enable' ");

        foreach ($payment_gateway->result_array() as $row) {
            $api_url = $row['api_url'];
            $api_key = $row['api_key'];
        }

        $apiKey = $api_key;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => $api_url . '/merchant/payment-channel?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response)->data;

        return $response ? $response : $error;
    }

    public function requestTransaction($invoice, $method, $total, $content, $paket)
    {
        $payment_gateway = $this->CI->db->query("SELECT * FROM payment_gateway WHERE name = 'tripay' AND status = 'enable'");
        if ($payment_gateway == false) {
        }
        foreach ($payment_gateway->result_array() as $row) {
            $code = $row['code_tripay'];
            $api_url = $row['api_tripay'];
            $api_key = $row['key_tripay'];
            $private_key = $row['private_tripay'];
        }

        $apiKey = $api_key;
        $privateKey = $private_key;
        $merchantCode = $code;
        $merchantRef = $invoice;

        $data = [
            'method' => $method,
            'merchant_ref' => $merchantRef,
            'amount' => $total,
            'customer_name' => $content[0]['nama'],
            'customer_email' => $content[0]['email'],
            'customer_phone' => $content[0]['nomor'],
            'order_items' => [
                [
                    'name' => $paket,
                    'price' => $total,
                    'quantity' => 1,

                ],
            ],
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature' => hash_hmac('sha256', $merchantCode . $merchantRef . $total, $privateKey),
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => $api_url . '/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response)->data;

        return $response ?: $error;
    }

    public function detailTransaction($reference)
    {
        $payment_gateway = $this->CI->db->query("SELECT * FROM payment_gateway WHERE name = 'tripay' AND status = 'enable'");

        foreach ($payment_gateway->result_array() as $row) {
            $api_url = $row['api_url'];
            $api_key = $row['api_key'];
        }

        $apiKey = $api_key;

        $payload = [
            'reference' => $reference,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => $api_url . '/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response)->data;

        return $response ?: $error;
    }
    public function verifyCallback($verify = 0)
    {
        $payment_gateway = $this->CI->db->query("SELECT * FROM payment_gateway WHERE id = '1'");

        foreach ($payment_gateway->result_array() as $row) {
            $private_key = $row['private_tripay'];
        }

        $verify = (int) $verify;
        $json = file_get_contents("php://input");
        $signature = hash_hmac('sha256', $json, $private_key);
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

        if ($callbackSignature === $signature) {
            if ($verify == 1) {
                $callback = json_decode($json);

                if (isset($callback->reference)) {
                    $cek = $this->detailTransaction($callback->reference);
                    $cek = json_decode($cek);

                    if ($cek->success === true) {
                        if (
                            $cek->data->reference == $callback->reference &&
                            $cek->data->merchant_ref == $callback->merchant_ref &&
                            $cek->data->amount == $callback->total_amount &&
                            $cek->data->payment_method == $callback->payment_method_code &&
                            $cek->data->status == $callback->status
                        ) {
                            return true;
                        } else {
                            $this->lastError = 'Invalid callback data';
                        }
                    } else {
                        $this->lastError = $cek->message;
                    }
                } else {
                    $this->lastError = 'Invalid callback data';
                }
            } else {
                return true;
            }
        } else {
            $this->lastError = 'Invalid signature. See https://payment.tripay.co.id/developer?tab=callback';
        }

        return false;
    }

    public function getChannels($payload)
    {
        return $this->makeRequest('/merchant/payment-channel', 'GET', ['code' => $payload], ['Authorization: Bearer ' . $this->apiKey]);
    }

    public function getCallback($verify = 0)
    {
        $verify = (int) $verify;
        $json = file_get_contents('php://input');
        $signature = hash_hmac('sha256', $json, $this->privateKey);
    }
}
