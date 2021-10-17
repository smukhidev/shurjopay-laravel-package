
# README #

### Authorization of the contributor ##
*	shurjoPay v 1.00 API
*	@date: 08 JAN 2021


To integrate the shurjoPay Payment Gateway in your Laravel project do the following tasks sequentially.

Installation and Configuration
Go to your project directory and use composer to install this package. Run the following command.

	composer require  smukhidev/shurjopay-laravel-package

After successful installation of shurjopay-laravel-package, go to your project and open config folder and then click on app.php file. Append the following line in providers array.

	smukhidev\shurjopay-laravel-package\ShurjopayServiceProvider::class,

Now in order to publish ShurjopayServiceProvider class and run the following command

        php artisan vendor:publish –provider = "smukhidev\ShurjopayLaravelPackage\ShurjopayServiceProvider"

It will automatically create a 'shurjopay.php' file in your project config folder

After successfully doing the above steps do the following Modify shurjopay.php file or add the following Keys in .env file with the credentials provided from shurjoMukhi Limited

	SHURJOPAY_SERVER_URL =
	MERCHANT_USERNAME =
	MERCHANT_PASSWORD =
	MERCHANT_KEY_PREFIX =

Implementation
Add the following line in the Class or Controller where the functionality will be implemented
use smukhidev\shurjopay-laravel-package\ShurjopayService;

Now add this line of code in your method where you want to call shurjoPay Payment Gateway. You can use any code segment of below              
                  
	$shurjopay_service = new ShurjopayService();
	$tx_id = $shurjopay_service->generateTxId();
	$success_route = route('Your route'); //This is your custom route where you want to back after completing the transaction.
	$data=array(
		'amount'=>$request->amount,
		'custom1'=>$request->company_name,
		'custom2'=>$request->email,
		'custom3'=>$request->name,
		'custom4'=>$request->number,
		'is_emi'=>0 //0 No EMI 1 EMI active
	);
	$shurjopay_service->sendPayment($data, $success_route);


Note: (Optional) In the sendPayment method you can add as much parameter as you want but if you want to add more parameters in sendPayment method you need to add this parameters in sendPayment method of ShurjopayService.php file which is located in
vendor/smukhidev/shurjopay-laravel-package/src

7) Go to successurl .There call a method $shurjopay_service->decrypt($request->spdata); it will return object.

 {
  "txID": "NOK20210615081852_100",
  "bankTxID":"Xid70lopzz",
  "bankTxStatus": "SUCCESS",
  "txnAmount": "100",
  "spCode": "000",
  "spCodeDes": "Cancel",
  "custom1": "Shurjomukhi Ltd",
  "custom2": "nazmus.shahadat@shurjomukhi.com.bd",
  "custom3": "Nazmus Shahadat",
  "custom4": "01829616787",
  "paymentOption": "CARD",
  "paymentTime": "2021-06-16 02:18:51"
}


Now Test your application and oversees the response and interaction

# Demo Card Infromation:
Card Number: 1111 1111 1111 1111

EXPIRE DATE: 12/30

cvc: 123

CARD OWNER: TEST
