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
        $xml_data = 'spdata=<?xml version="1.0" encoding="utf-8"?>
                            <shurjoPay><merchantName>' . $this->merchant_username . '</merchantName>
                            <merchantPass>' . $this->merchant_password . '</merchantPass>
                            <userIP>' . $this->client_ip . '</userIP>
                            <uniqID>' . $this->tx_id . '</uniqID>
                            <totalAmount>' . $amount . '</totalAmount>
                            <paymentOption>shurjopay</paymentOption>
                            <returnURL>' . $return_url . '</returnURL></shurjoPay>';

        $ch = curl_init();
        $server_url = config('shurjopay.server_url');
        $url = $server_url . "/sp-data.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response);

    }
}
