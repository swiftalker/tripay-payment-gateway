Un-official Tripay Payment Gateway
===============
[![Latest Stable Version](https://poser.pugx.org/muhammadnan/tripay-payment-gateway/v)](//packagist.org/packages/muhammadnan/tripay-payment-gateway)
[![Total Downloads](https://poser.pugx.org/muhammadnan/tripay-payment-gateway/downloads)](//packagist.org/packages/muhammadnan/tripay-payment-gateway)
[![License](https://poser.pugx.org/muhammadnan/tripay-payment-gateway/license)](//packagist.org/packages/muhammadnan/tripay-payment-gateway)

This package is un-official, already compatible with Composer, for more details please visit [Documentation](https://payment.tripay.co.id/developer).

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
For mode by default it will be in production mode, to change it to sandbox mode, you can add a 'sandbox' after the merchant code

## Contents available
content method available so far

| Method  | Contents  | Status |
|---|---|---|
| `initChannelPembayaran()` | `Channel Pembayaran` | OK |
| `initInstruksiPembayaran(string $code)` | `Instruksi Pembayaran` | OK |
| `initMerchantChannelPembayaran(string $code)` | `Merchant Channel Pembayaran` | OK |
| `initKalkulatorBiaya(string $code, int $amount)` | `Kalkulator Biaya` | OK |
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
| `getStatusCode()`  | return boolean  |
| `getData()`  | return data response  |

## Channel Pembayaran

This API is used to get a list of all available payment channels along with complete information including transaction fees for each channel

```php
$main->initChannelPembayaran()
```

the next method can be seen in the [request method]()
