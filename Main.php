<?php
require 'vendor/autoload.php';
use Tripay\Main;

$main =  new Main(
    'DEV-wU6LroIcogT3Pff4voUUbJUZF5UoQiXlmRM5C1Tu',
    'khyk4-7z0vE-rII0y-PKJZR-dgFPo',
    'T2154',
    'sandbox'
);


$ref = rand(1, 1000);

$init = $main
    ->initTransaction($ref);
$init->setAmount(10000);
$transaction = $init->closeTransaction();

$transaction->setPayload([
    'method'            => 'BRIVA',
    'merchant_ref'      => $ref,
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
]);
dd($transaction->getDetail('DEV-T21540000004807BAJ6M')->getData());


//$main =  new Main(
//    'Epb0VSXaac9V0Y5Vw3kO62rQRKaXEeNiNNSRDkEg',
//    'wZcAV-OBuZr-3PLQU-ZTnmu-AqH5Q',
//    'T2184',
////'sandbox'
//);
//
//
//$ref = rand(1, 1000);
//
//$init = $main->initTransaction(12345678);
//$init->setMethod('BRIVAOP');
//$transaction = $init->openTransaction();
//
//$transaction->setPayload([
//    'method'            => $init->getMethod(),
//    'merchant_ref'      => 12345678,
//    'customer_name'     => 'Nama Pelanggan',
//    'signature'         => $init->createSignature()
//]);
//dd($transaction->getDaftarPembayaran('T2184-OP53-ZVEHCF')->getData());