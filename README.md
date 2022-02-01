Unofficial Tripay Payment Gateway
===============
[![Latest Stable Version](https://poser.pugx.org/muhammadnan/tripay-payment-gateway/v)](//packagist.org/packages/muhammadnan/tripay-payment-gateway)
[![Total Downloads](https://poser.pugx.org/muhammadnan/tripay-payment-gateway/downloads)](//packagist.org/packages/muhammadnan/tripay-payment-gateway)
[![License](https://poser.pugx.org/muhammadnan/tripay-payment-gateway/license)](//packagist.org/packages/muhammadnan/tripay-payment-gateway)

This package is un-official, already compatible with Composer, for more details please visit [Documentation](https://tripay.co.id/developer).
_This package is made to make it easier for php users_

IMPORTANT: Make sure you read the documentation and understand what these methods are used for!

need PHP 7 and above to use this package
## Instalation
```
composer require muhammadnan/tripay-payment-gateway
```

## Configuration

before starting further, you must define or import a tripay for further configuration
```php
use Tripay\Main;
```

then after that configure api-key, private-key, merchant-code
```php
$main = new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
    'sandbox' // fill for sandbox mode, leave blank if in production mode
);
```

or you can create or add env variable in your project (such as laravel, codeigniter) like this
```env
TRIPAY_API_KEY='your-api-key'
TRIPAY_PRIVATE_KEY='your-private-key'
TRIPAY_MERCHANT_CODE='your-merchant-code'
TRIPAY_MODE='sandbox' // fill for sandbox mode, leave blank if in production mode
```

and after add env variable in your project declare main class like this

```php
$main = new Main();
```

For mode by default it will be in production mode, to change it to sandbox mode, you can add a 'sandbox' after the merchant code

## Contents available
content method available so far

| Method  | Contents  | Status |
|---|---|---|
| `initChannelPembayaran()` | `Channel Pembayaran` | OK |
| `initInstruksiPembayaran(string $code)` | `Instruksi Pembayaran` | OK |
| `initMerchantChannelPembayaran(string $code)` | `Merchant Channel Pembayaran` | OK |
| `initKalkulatorBiaya(string $code, int $amount)` | `Kalkulator Biaya` | OK |
| `initDaftarTransaksi(int $page, int $per_page, string $sort, string $reference, string $merchant_ref, string $method, string $status)` | `Daftar Transaksi` | OK |
| `initTransaction(string $merchantRef)` | `Transaksi Open/Close` | OK |
| `initCallback()` | `Callback` | OK |

## Request available

request can return the available content, the list of available methods is as follows

| Method  | Description  |
|---|---|
| `getRequest(string $url)`  | return return guzzle http client |
| `getResponse()`  | return response |
| `getJson()`  | return json decode  |
| `getStatusCode()`  | return status code  |
| `getSuccess()`  | return boolean  |
| `getData()`  | return data response  |

## Channel Pembayaran

This API is used to get a list of all available payment channels along with complete information including transaction fees for each channel

```php
$main->initChannelPembayaran()
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

## Instruksi Pembayaran

This API is used to retrieve payment instructions from each channel

```php
$code = 'BRIVA'; //more info code, https://tripay.co.id/developer
$init = $main->initInstruksiPembayaran($code)
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

## Merchant Channel Pembayaran

This API is used to obtain a list of payment channels available in your Merchant account along with complete information including transaction fees for each channel

```php 
$code = 'BRIVA'; //more info code, https://tripay.co.id/developer
$init = $main->initMerchantChannelPembayaran($code);
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

## Kalkulator Biaya
This API is used to obtain detailed transaction fee calculations for each channel based on a specified nominal

```php
$code = 'BRIVA'; //more info code, https://tripay.co.id/developer
$amount = 1000;//your amount
$init = $main->initKalkulatorBiaya($code, $amount);
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

## Daftar Transaksi
This API is used to obtain detailed transaction fee calculations for each channel based on a specified nominal

```php
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
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

## Transaction
Before proceeding to the next step in transactions, please configure your reference merchant
```php 
$merchantRef = 'your-merchant-ref';//your merchant reference
$init = $main->initTransaction($merchantRef);
```
Before making a signature, please set the amount for close transactions and for open transactions, please set the payment method
```php
$init->setAmount(1000); // for close payment
$init->setMethod('BRIVAOP'); // for open payment
```

Note: if you use an open payment do not define the amount and vice versa if you use a close payment do not define the amount

## Create Signature
```php 
$signature = $init->createSignature();
```

## Close Transaction

To define close transaction, use the `closeTransaction ()` method

```php 
$transaction = $init->closeTransaction(); // define your transaction type, for close transaction use `closeTransaction()`
```

After you define a close transaction, please set the payload with the `setPayload (array $ data)` method

****examples:****
```php
$transaction->setPayload([
    'method'            => 'BRIVA', // IMPORTANT, dont fill by `getMethod()`!, for more code method you can check here https://tripay.co.id/developer
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
]); // set your payload, with more examples https://tripay.co.id/developer
```

for get the payload u can use ```getPayload()``` method,

after set transaction u can sent the request and get data directly with the `` getData ()  `` method or for more method u can seen in the [request method](#request-available) or can be see in examples

### Get Close Detail Transaction

To see further transaction data, you can see it in transaction details, for close transactions, see below
where to get reference code? please go to the simulator menu and get it in the transaction menu, there is a reference code that can be matched here
```php 
$referenceCode = 'your-reference-code'; // fill by reference code
$detail = $transaction->getDetail($referenceCode); // return get detail your transaction with your reference code
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

## Open Transaction

To define close transaction, use the `openTransaction ()` method

```php
$transaction = $init->openTransaction(); // define your transaction type, for close transaction use `openTransaction()`
```
After you define a open transaction, please set the payload with the `setPayload (array $ data)` method

****examples:****
```php
$transaction->setPayload([
    'method'            => $init->getMethod(),
    'merchant_ref'      => $merchantRef,
    'customer_name'     => 'Nama Pelanggan',
    'signature'         => $init->createSignature()
]); // set your payload, with more examples https://tripay.co.id/developer
```

for get the payload u can use ```getPayload()``` method,

after set transaction u can sent the request and get data directly with the `` getData ()  `` method or for more method u can seen in the [request method](#request-available) or can be see in examples

#### Get Open Detail Transaction

To see further transaction data, you can see it in transaction details, for close transactions, see below
where can i get uuid? please open the transaction menu then select open payment then there is a uuid code there

```php 
$uuidCode = 'your-uuid-code'; // fill by reference code

$detail = $transaction->getDetail($uuid); // return get detail your open transaction with your uuid code
```

the next method can be seen in the [request method](#request-available) or can be seen in examples

### Get Daftar Pembayaran Transaction
To see a list of payments made in open transactions you can use this method
you can get the uuid in your account.
```php 
$referenceCode = 'your-reference-code'; // fill by reference code

$detail = $transaction->getDetail($referenceCode); // return get detail your transaction with your reference code
```
the next method can be seen in the [request method](#request-available) or can be seen in examples

## Callback

Callback is a method of sending transaction notifications from the TriPay server to the user's server. When the payment from the customer is completed, the TriPay system will provide a notification containing transaction data which can then be further managed by the user's system.

please define the method below before starting

```php
$init = $main->initCallback(); // return callback
```

### Receive JSON

to get the json that was sent by tripay you can use the method below

```php 
$init->get(); // get all callback
```

### Decode JSON

rather than wasting time on json_decode, this package provides that

```php 
$init->getJson(); // get json callback
```

### Get The Signature

take signature from tripay using the method below

```php 
$init->signature(); // callback signature
```

### Callback Signature

tripay also sends a callback signature to validate customer data

```php 
$init->callbackSignature(); // callback signature
```

### Call Event

for re-validation, tripay sends an event in the form of `payment_status` this package also captures that

```php
$init->callEvent(); // callback event, return `payment_status`
```

### Validate Signature
To shorten the code, we prepared signature validation as well.

```php 
$init->validateSignature(); // return `true` is valid signature, `false` invalid signature
```

### Validate Event
To shorten the code too, we also set up validate events to go a step further

```php 
$init->validateEvent(); // return `true` is PAID, `false` meaning UNPAID,REFUND,etc OR call event undefined
```

## Testing

This package is tested using PHPunit, but mostly direct testing

## Contribute
If you want to contribute this SDK, you can fork, edit and create pull request. And we will review your request and if we finish to review your request. We will merge your request to developemnt branch. Thanks
