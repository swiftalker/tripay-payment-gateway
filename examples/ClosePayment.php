<?php require 'vendor/autoload.php';
use Tripay\Main;

$main =  new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
    //mode available in sandbox or live, leave it to be live, fill in 'sandbox' for sandbox mode
);

$merchantRef = 'your-merchant-ref';//your merchant reference
$init = $main->initTransaction($merchantRef);

$init->setAmount(1000);//IMPORTANT, this field is required and u must set it before use close payment

$init->getAmount(); // return set amount

$init->createSignature(); // for generate signature, you can take this

$transaction = $init->closeTransaction(); // define your transaction type, for close transaction use `closeTransaction()`

$transaction->setPayload([
    'method'            => 'BRIVA', // IMPORTANT, dont fill by `getMethod()`!, for more code method you can check here https://payment.tripay.co.id/developer
    'merchant_ref'      => $merchantRef,
    'amount'            => $init->getAmount(),
    'customer_name'     => 'Nama Pelanggan',
    'customer_email'    => 'emailpelanggan@domain.com',
    'customer_phone'    => '081234567890',
    'order_items'       => [
        [
            'sku'       => 'PRODUK1',
            'name'      => 'Nama Produk 1',
            'price'     => $init->getAmount(),
            'quantity'  => 1
        ]
    ],
    'callback_url'      => 'https://domainanda.com/callback',
    'return_url'        => 'https://domainanda.com/redirect',
    'expired_time'      => (time()+(24*60*60)), // 24 jam
    'signature'         => $init->createSignature()
]); // set your payload, with more examples https://payment.tripay.co.id/developer

$transaction->getPayload(); // get payload from set payload

$transaction->getCloseTransaction(); // return guzzle http client

$transaction->getRequest(); // return guzzle http client

$transaction->getJson(); //return json decode

$transaction->getStatusCode(); // return status code

$transaction->getSuccess(); // return success, return bool type

$transaction->getResponse(); // return response

$transaction->getData(); // return data response

$referenceCode = 'your-reference-code'; // fill by reference code
$detail = $transaction->getDetail($referenceCode); // return get detail your transaction with your reference code

$detail->getDetailTransaction(); // return guzzle http client

$detail->getRequest(); // return guzzle http client

$detail->getJson(); //return json decode

$detail->getStatusCode(); // return status code

$detail->getSuccess(); // return success, return bool type

$detail->getResponse(); // return response

$detail->getData(); // return data response
