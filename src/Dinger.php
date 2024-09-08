<?php
namespace KenNebula\DingerPaymentIntegration;

use ErrorException;
use Illuminate\Support\Facades\Http;

class Dinger {
    public function sendPayment(Array $items, String $customer_name, String $total_amount, String $merchant_order_no)
    {
        $payload = json_encode(array(
            "clientId" => config('dinger.clientId'),
            "publicKey" => config('dinger.publicKey'),
            "items" => json_encode($items),
            "customerName" => "$customer_name",
            "totalAmount" => "$total_amount",
            "merchantOrderId" => "$merchant_order_no",
            "merchantKey" => config('dinger.merchantKey'),
            "projectName" => config('dinger.projectName'),
            "merchantName" => config('dinger.merchantName')
        ));

        $encryptData = static::encryptData($payload);

        $redirect_url = config('dinger.url') . "?hashValue=".$encryptData['encryptedHashValue']."&payload=".$encryptData['urlencode_value'];

        return $redirect_url;
    }

    public static function encrypt($payload) 
    {
        $publicKey = config('dinger.encryptionKey');
        $rsa = new RSA();
        extract($rsa->createKey(1024));
        $rsa->loadKey($publicKey); // public key
        $rsa->setEncryptionMode(2);
        $ciphertext = $rsa->encrypt($payload);
        $value = base64_encode($ciphertext);

        $urlencode_value = urlencode($value);

        $encryptedHashValue = hash_hmac('sha256', $payload, config('dinger.secretKey'));

        return [
            "encryptedHashValue" => $encryptedHashValue,
            "urlencode_value" => $urlencode_value
        ];
    }

    public static function callback(String $paymentResult,String $checkSum)
    {
        $callbackKey =  config('dinger.callback_key');
        $decrypted = openssl_decrypt($paymentResult,"AES-256-ECB", $callbackKey);
 
        if(hash("sha256", $decrypted) !== $checkSum){
            return throw new ErrorException('Payment result is incorrect Singanature.');
        } elseif (hash("sha256", $decrypted) == $checkSum) {
            $decryptedValues = json_decode($decrypted, true);
    
            return json_decode($decrypted, true);
        }
    }

    public static function checkConfigData(){
        $config_data = [
            "url" => config('dinger.url'),
            "clientId" => config('dinger.clientId'),
            "publicKey" => config('dinger.publicKey'),
            "merchantKey" => config('dinger.merchantKey'),
            "projectName" => config('dinger.projectName'),
            "merchantName" => config('dinger.merchantName'),
            "encryptionKey" => config('dinger.encryptionKey'),
            "secretKey" => config('dinger.secretKey'),
            "callBackKey" => config('dinger.callBackKey'),
        ];
       
        foreach($config_data as $key => $data){
            $data == null ? throw new ErrorException($key . ' cannot be null in config/dinger.php') : '';
        }
    }

}