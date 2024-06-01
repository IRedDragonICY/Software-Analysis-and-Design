<?php

class TripayPayment
{
    protected $merchantCode, $apiKey, $privateKey;
    protected $baseApiUrl = 'https://tripay.co.id/api-sandbox';
    protected $params = [];
    public $lastError = null;

    public function __construct($baseApiUrl = null, $merchantCode = null, $apiKey = null, $privateKey = null, $callback = null)
    {
        $this->baseApiUrl = $baseApiUrl;
        $this->merchantCode = $merchantCode;
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->callback = $callback;

        return $this;
    }

    public function _set($name, $value, $force = false)
    {
        if (isset($this->$name) && !$force) {
            throw new \Exception("Failed to set `" . $name . "`. Property already exists!. Please set `force` (3rd parameter) to `true` to overwrite the property");
        }

        $this->$name = $value;

        return $this;
    }

    protected function makeRequest($endpoint, $method = 'GET', array $payload = [], array $headers = [])
    {
        $ch = curl_init();

        $url = rtrim($this->baseApiUrl, '/') . '/' . ltrim($endpoint, '/');

        if ($method == 'GET') {
            $url = $url . (count($payload) ? '?' . http_build_query($payload) : '');
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        }

        curl_setopt_array($ch, [
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_HTTPHEADER      => $headers,
            CURLOPT_FRESH_CONNECT   => true,
            CURLOPT_FAILONERROR     => false,
        ]);

        $result = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno) {
            $result = json_encode([
                'success'   => false,
                'message'   => $error
            ]);
        }

        return $result;
    }

    public function set_param($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    public function set_params(array $value)
    {
        $this->params = $value;
        return $this;
    }

    private function reset_param()
    {
        $this->params = [];
        return $this;
    }

    public function createTransaction()
    {
        return $this->makeRequest('/transaction/create', 'POST', $this->params, ['Authorization: Bearer ' . $this->apiKey]);
    }

    public function getTransaction($reference)
    {
        return $this->makeRequest('/transaction/detail', 'GET', ['reference' => $reference], ['Authorization: Bearer ' . $this->apiKey]);
    }

    public function getChannels($payload)
    {
        return $this->makeRequest('/merchant/payment-channel', 'GET',  ['code' => $payload], ['Authorization: Bearer ' . $this->apiKey]);
    }

    public function verifyCallback($verify = 0)
    {
        $verify = (int) $verify;
        $json = file_get_contents("php://input");
        $signature = hash_hmac('sha256', $json, $this->privateKey);
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

        if ($callbackSignature === $signature) {
            if ($verify == 1) {
                $callback = json_decode($json);

                if (isset($callback->reference)) {
                    $cek = $this->getTransaction($callback->reference);
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
}
