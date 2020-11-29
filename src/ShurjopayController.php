<?php

namespace smasif\ShurjopayLaravelPackage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShurjopayController extends Controller
{
    public function response(Request $request)
    {
        $server_url = config('shurjopay.server_url');
        $response_encrypted = $request->spdata;
        $response_decrypted = file_get_contents($server_url . "/merchant/decrypt.php?data=" . $response_encrypted);
        $data = simplexml_load_string($response_decrypted) or die("Error: Cannot create object");
        $tx_id = $data->txID;
        $bank_tx_id = $data->bankTxID;
        $amount = $data->txnAmount;
        $bank_status = $data->bankTxStatus;
        $sp_code = $data->spCode;
        $sp_code_des = $data->spCodeDes;
        $sp_payment_option = $data->paymentOption;
        $status = "";
        switch ($sp_code) {
            case '000':
                $res = array('status' => false, 'msg' => 'Action Successful');
                $status = "Success";
                break;
            case '001':
                $status = "Failed";
                $res = array('status' => false, 'msg' => 'Action Failed');
                break;
        }

        $success_url = $request->get('success_url');

        if ($success_url) {
            header("location:" . $success_url . "?status={$status}&msg={$res['msg']}&tx_id={$tx_id}&bank_tx_id={$bank_tx_id}"
                . "&amount={$amount}&bank_status={$bank_status}&sp_code={$sp_code}" .
                "&sp_code_des={$sp_code_des}&sp_payment_option={$sp_payment_option}");
        }
        if ($res['status']) {
            echo "Success";
            die();
        } else {
            echo "Fail";
            die();
        }
    }
}
