
# README #

### Authorization of the contributor ##
*	shurjoPay v 1.00 API
*	@date: 08 JAN 2021


To integrate the shurjoPay Payment Gateway in your Laravel project do the following tasks sequentially.

Installation and Configuration
Go to your project directory and use composer to install this package. Run the following command.

composer require smasif/shurjopay-laravel-package

After successful installation of shurjopay-laravel-package, go to your project and open config folder and then click on app.php file. Append the following line in providers array.

smasif\ShurjopayLaravelPackage\ShurjopayServiceProvider::class,

Now in order to publish ShurjopayServiceProvider class and run the following command

php artisan vendor:publish –provider = "smasif\ShurjopayLaravelPackage\ShurjopayServiceProvider"

It will automatically create a 'shurjopay.php' file in your project config folder

After successfully doing the above steps do the following Modify shurjopay.php file or add the following Keys in .env file with the credentials provided from shurjoMukhi Limited

SHURJOPAY_SERVER_URL =
MERCHANT_USERNAME =
MERCHANT_PASSWORD =
MERCHANT_KEY_PREFIX =

Implementation
Add the following line in the Class or Controller where the functionality will be implemented
use smasif\ShurjopayLaravelPackage\ShurjopayService;

Now add this line of code in your method where you want to call shurjoPay Payment Gateway. You can use any code segment of below

$shurjopay_service = new ShurjopayService();
$tx_id = $shurjopay_service->generateTxId();
$shurjopay_service->sendPayment(2); //You will pass the amount variable in place of 2

                     *OR*
$shurjopay_service = new ShurjopayService();
$tx_id = $shurjopay_service->generateTxId();
$success_route = route('Your route'); //This is your custom route where you want to back after completing the transaction.
$shurjopay_service->sendPayment(2, $success_route);


Note: (Optional) In the sendPayment method you can add as much parameter as you want but if you want to add more parameters in sendPayment method you need to add this parameters in sendPayment method of ShurjopayService.php file which is located in
vendor/smasif/ shurjopay-laravel-package/src

7) Go to this (vendor/smasif/ shurjopay-laravel-package/src) path and open the ShurjopayController.php file .There has a method called response.



In order to save the payment response in database do the following
a) Add the following line of code in the ShurjopayController.php.

use DB;

b) Write the necessary query you want to add response in your database. It may be update database or insert into database.
if ($res['status']){
echo "Success";
die();
}

c) Write the necessary query you want to add after failing transaction. It may be update database or insert into database.
if ($res['status']){
echo "Fail";
die();
}

Now Test your application and oversees the response and interaction
