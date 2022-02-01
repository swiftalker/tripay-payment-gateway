<?php require 'vendor/autoload.php';
use Tripay\Main;
use Tripay\Request\MerchantChannelPembayaran;

$main =  new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
//mode available in sandbox or live, leave it to be live, fill in 'sandbox' for sandbox mode
);
$code = 'BRIVA'; //more info code, check your account
$init = $main->initMerchantChannelPembayaran($code);

$init->getMerchantChannelPembayaran(); // return guzzle http client

$merchantChannelPembayaran = MerchantChannelPembayaran::URL_SANDBOX; // available URL_SANDBOX or URL_PRODUCTION
$init->getRequest($merchantChannelPembayaran); // return guzzle http client

$init->getJson(); //return json decode

$init->getStatusCode(); // return status code

$init->getSuccess(); // return success, return bool type

$init->getResponse(); // return response

$init->getData(); // return data response