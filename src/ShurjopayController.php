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
        $response_data = simplexml_load_string($response_decrypted) or die("Error: Cannot create object");       

        $success_url = $request->get('success_url');

        if ($success_url) 
        {
            
            if(is_object($response_data))
            {
                $html = '<form action=".$success_url."  method="post" id="sp_response">';
            	foreach($response_data as $key => $val)
                {
                    $html .= '<input type="hidden" name=".$key." value=".$val." />'; 
                }
                $html .='</form>'; 
                $html .= '<script>document.getElementById("sp_response").submit();</script>';
                echo $html;
            }
        }
        else
        {
            // Get response from shurjoPay in with spCode 000 or 001. '000' for successful and '001' for failed transaction.
            if ( isset($response_data->spCode) && $response_data->spCode == '000' ) 
            {
               die( "Success" );
            } 
            else
            {
               die( "Fail" );
            }
        }

    }
}
