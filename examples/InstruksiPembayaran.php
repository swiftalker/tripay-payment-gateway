<?php require 'vendor/autoload.php';
use Tripay\Main;

$main =  new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
    //mode available in sandbox or live, leave it to be live, fill in 'sandbox' for sandbox mode
);
$code = 'BRIVA'; //more info code, https://payment.tripay.co.id/developer
$init  = $main->initInstruksiPembayaran($code);

$init->getChannelPembayaran(); // return guzzle http client

$init->getRequest(); // return guzzle http client

$init->getJson(); //return json decode

$init->getStatusCode(); // return status code

$init->getSuccess(); // return success, return bool type

$init->getResponse(); // return response

$init->getData(); // return data response