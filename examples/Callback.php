<?php require 'vendor/autoload.php';
use Tripay\Main;

$main =  new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
);

$init = $main->initCallback(); // return callback

$init->get(); // get all callback

$init->getJson(); // get json callback

$init->signature(); // callback signature

$init->callbackSignature(); // callback signature

$init->callEvent(); // callback event, return `payment_status`

$init->validateSignature(); // return `true` is valid signature, `false` invalid signature

$init->validateEvent(); // return `true` is PAID, `false` meaning UNPAID,REFUND,etc OR call event undefined