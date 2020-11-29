# README #

### Authorization of the contributor ##
*	shurjoPay v 1.00 API
*	@authore: abdullah md. ayman
*	@date: 31 May 2020
*	@email: abdullahwasim42@gmail.com

* Summary of set up


Installation: 
Use composer to install this package:

composer require smasif/shurjopay-laravel-package

Open  config/app.php file and append the following line in providers array:

         smasif\ShurjopayLaravelPackage\ShurjopayServiceProvider::class,

Configuration:
Publish through configuration file:

         php artisan vendor:publish --provider="smasif\ShurjopayLaravelPackage\ShurjopayServiceProvider"

It will create a config file 'shurjopay.php' in config folder.

  Modify shurjopay.php or add the following Keys in .env file with the credentials provided from shurjomukhi

      SHURJOPAY_SERVER_URL=

      MERCHANT_USERNAME=

      MERCHANT_PASSWORD=

      MERCHANT_KEY_PREFIX=

How to Use:

Add this in the Class or Controller where the functionality will be used
 use smasif\ShurjopayLaravelPackage\ShurjopayService;

 In the method:

 $shurjopay_service = new ShurjopayService(); //Initiate the object

 $tx_id = $shurjopay_service->generateTxId(); // Get transaction id. You can use custom id like: $shurjopay_service->generateTxId('123456');

 $success_route = route('Your route'); // optional.

 $shurjopay_service->sendPayment(2, $success_route); // You can call simply $shurjopay_service->sendPayment(2) without success route




