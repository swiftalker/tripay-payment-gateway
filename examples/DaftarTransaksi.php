<?php require 'vendor/autoload.php';
use Tripay\Main;
use Tripay\Request\DaftarTransaksi;

$main =  new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
    'sandbox' //mode available in sandbox or live, leave it to be live, fill in 'sandbox' for sandbox mode
);

$page = 1;
$per_page = 50; 
$sort = 'desc';
$reference = 'T0001000000455HFGRY';
$merchant_ref = 'INV57564';
$method = 'BRIVA';
$status = 'PAID';

$init = $main->initDaftarTransaksi(
    $page,
    $per_page, 
    $sort, 
    $reference, 
    $merchant_ref, 
    $method, 
    $status
);

$init->getDaftarTransaksi(); // return guzzle http client

$daftarTransaksiRequest = DaftarTransaksi::URL_SANDBOX; // available URL_SANDBOX or URL_PRODUCTION

$init->getRequest($daftarTransaksiRequest); // return guzzle http client

$init->getJson(); //return json decode

$init->getStatusCode(); // return status code

$init->getSuccess(); // return success, return bool type

$init->getResponse(); // return response

$init->getData(); // return data response