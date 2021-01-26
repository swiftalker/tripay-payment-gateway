<?php require 'vendor/autoload.php';
use Tripay\Main;

$main =  new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
    //sandbox mode not available on open payment
);

$merchantRef = 'your-merchant-ref';//your merchant reference
$init = $main->initTransaction($merchantRef);

$init->setMethod('BRIVAOP');//IMPORTANT, this field is required and u must set it before use open payment, for more code https://payment.tripay.co.id/developer

$init->getMethod(); // return set method

$init->createSignature(); // for generate signature, you can take this

$transaction = $init->openTransaction(); // define your transaction type, for close transaction use `closeTransaction()`

$transaction->setPayload([
    'method'            => $this->getMethod(),
    'merchant_ref'      => $merchantRef,
    'customer_name'     => 'Nama Pelanggan',
    'signature'         => $init->createSignature()
]); // set your payload, with more examples https://payment.tripay.co.id/developer

$transaction->getPayload(); // get payload from set payload

$transaction->getOpenTransaction(); // return guzzle http client

$transaction->getRequest(); // return guzzle http client

$transaction->getJson(); //return json decode

$transaction->getStatusCode(); // return status code

$transaction->getSuccess(); // return success, return bool type

$transaction->getResponse(); // return response

$transaction->getData(); // return data response

$uuidCode = 'your-uuid-code'; // fill by reference code

$detail = $transaction->getDetail($uuid); // return get detail your open transaction with your uuid code

$detail->getDetailTransaction(); // return guzzle http client

$detail->getRequest(); // return guzzle http client

$detail->getJson(); //return json decode

$detail->getStatusCode(); // return status code

$detail->getSuccess(); // return success, return bool type

$detail->getResponse(); // return response

$detail->getData(); // return data response

$daftar_pembayaran = $transaction->getDaftarPembayaran($uuid); // return get daftar pembayaran your open transaction with your uuid code

$daftar_pembayaran->getDaftarPembayaran(); // return guzzle http client

$daftar_pembayaran->getRequest(); // return guzzle http client

$daftar_pembayaran->getJson(); //return json decode

$daftar_pembayaran->getStatusCode(); // return status code

$daftar_pembayaran->getSuccess(); // return success, return bool type

$daftar_pembayaran->getResponse(); // return response

$daftar_pembayaran->getData(); // return data response