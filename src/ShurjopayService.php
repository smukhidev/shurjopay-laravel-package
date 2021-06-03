<?php

namespace smasif\ShurjopayLaravelPackage;

class ShurjopayService
{
    protected $merchant_username;
    protected $merchant_password;
    protected $client_ip;
    protected $merchant_key_prefix;
    protected $tx_id;

    public function __construct()
    {
        $this->merchant_username = config('shurjopay.merchant_username');
        $this->merchant_password = config('shurjopay.merchant_password');
        $this->client_ip = $_SERVER["REMOTE_ADDR"] ?? '127.0.0.1';
        $this->merchant_key_prefix = config('shurjopay.merchant_key_prefix');
    }

    public function generateTxId($unique_id = null)
    {
        if ($unique_id) {
            $tx_id = $this->merchant_key_prefix . $unique_id;
        } else {
            $tx_id = $this->merchant_key_prefix . uniqid();
        }
        $this->tx_id = $tx_id;
        return $tx_id;
    }

    public function sendPayment($amount, $success_url = null)
    {
        $return_url = route('shurjopay.response');
        if ($success_url) {
            $return_url .= "?success_url={$success_url}";
        }
        $data = array(
            'merchantName' => 'spaytest',
            'merchantPass' => 'JehPNXF58rXs',
            'userIP' => '127.0.0.1',
            'uniqID' => 'NOK'.'_playpen_'.rand(10,587458),
            'custom1' => '',
            'custom2' => '',
            'custom3' => '',
            'custom4' => '',
            'school' => '',
            'paymentterm' => '',
            'minimumamount' => '',
            'totalAmount' => '10',
            'paymentOption' => 'shurjopay',
            'returnURL' => 'http://localhost/return.php',
        );
        $payload = array("spdata" => json_encode($data));

        $ch = curl_init();
        $server_url = config('shurjopay.server_url');
        $url = $server_url . "/sp-pp.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response);

    }
}
