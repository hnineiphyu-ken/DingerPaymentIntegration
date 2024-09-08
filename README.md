AYA Payment Integration Package
============

<!-- [![Latest Stable Version](https://packagist.org/packages/kennebula/dingerpaymentintegration)] -->

Requirements
------------

* PHP >= 8.0;
* composer;

Features
--------

* PSR-4 autoloading compliant structure.
* Easy to use with Laravel framework.
* Useful tools for better code included.

Installation
============

    composer require kennebula/dingerpaymentintegration

Set Up Tools
============

Running Command:
--------------------------

    php artisan vendor:publish --provider="KenNebula\DingerPaymentIntegration\PackageServiceProvider" --tag="config"

Config Output
----------

    return [
        #to fill dinger payment url 
        'url' => null,
        #to fill client id 
        'clientId' => null,
        #to fill public key
        'publicKey' => null,
        #to fill project name
        'projectName' => null,
        #to fill merchant name
        'merchantName' => null,
        #to fill encryption key
        'encryptionKey' => null,
        #to fill call back key
        'callBackKey' => null
    ];

* This command will create aya.php file inside config folder like this, 

* Important - You need fill the aya info in this config file for package usage.

Package Usage
------------

Send Payment (to get redirect url) :
----------------

    use KenNebula\DingerPaymentIntegration\Dinger;

    AYA::sendPayment(@multidimensionalArray $items,@String $customer_name, @Int $total_amount, @String $merchant_order_no);
* Note 

* items array must be include name, amount, quantity.
* customerName must be string.
* totalAmount must be integer.
* merchantOrderId must be string.

Load Output 
---------

* This will generate a dinger prebuild form url.    

Extract Callback Data:
----------------

    use KenNebula\DingerPaymentIntegration\Dinger;

    Dinger::callback(@String $paymentResult,@String $checkSum);

* Note 

* paymentResult must be string.
* checkSum must be string.

Callback Output 
------

* This will return decrypted data array include payment information.  

License
=======

KenNebula Reserved Since 2024.