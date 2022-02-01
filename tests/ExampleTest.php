<?php
use Tripay\Main;

$main = new Main(
    'your-api-key',
    'your-private-key',
    'your-merchant-code',
    'sandbox' // fill for sandbox mode, leave blank if in production mode
);

test('channel pembayaran', function () use ($main) {
    $code = 'BRIVA'; //more info code, https://tripay.co.id/developer

    $channelPembayaran = $main->initChannelPembayaran($code);
    $getSuccess = $channelPembayaran->getSuccess();
    $getStatusCode = $channelPembayaran->getStatusCode();
    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
});

test('instruksi pembayaran', function () use ($main) {
    $code = 'BRIVA'; //more info code, https://tripay.co.id/developer
    $payCode = '1234567890';
    $amount = 1000;
    $allow_html = 1;

    $instruksiPembayaran = $main->initInstruksiPembayaran($code);
    $getSuccess = $instruksiPembayaran->getSuccess();
    $getStatusCode = $instruksiPembayaran->getStatusCode();

    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
});

test('daftar transaksi', function () use ($main) {
    $page = 1;
    $per_page = 50; 
    $sort = 'desc';
    $reference = 'T0001000000455HFGRY';
    $merchant_ref = 'INV57564';
    $method = 'BRIVA';
    $status = 'PAID';

    $daftarTransaksi = $main->initDaftarTransaksi(
        $page,
        $per_page, 
        $sort, 
        $reference, 
        $merchant_ref, 
        $method, 
        $status
    );

    $getSuccess = $daftarTransaksi->getSuccess();
    $getStatusCode = $daftarTransaksi->getStatusCode();

    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
});

test('merchant channel pembayaran', function () use ($main) {
    $code = 'BRIVA'; //more info code, https://tripay.co.id/developer

    $merchantChannelPembayaran = $main->initMerchantChannelPembayaran($code);
    $getSuccess = $merchantChannelPembayaran->getSuccess();
    $getStatusCode = $merchantChannelPembayaran->getStatusCode();

    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
});

test('kalkulator biaya', function () use ($main) {
    $code = 'BRIVA'; //more info code, https://tripay.co.id/developer
    $amount = 1000;//your amount

    $kalkulatorBiaya = $main->initMerchantChannelPembayaran($code, $amount);
    $getSuccess = $kalkulatorBiaya->getSuccess();
    $getStatusCode = $kalkulatorBiaya->getStatusCode();

    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
});

/**
 * Test transaction
 */
$merchantRef = 'test-nara-code';
$init = $main->initTransaction($merchantRef);

test('close transaction', function () use ($main, $init, $merchantRef) {
    $init->setAmount(10000);
    $signature = $init->createSignature();

    $closeTransaction = $init->closeTransaction();

    $closeTransaction->setPayload([
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
        'signature'         => $signature
    ]); // set your payload, with more examples https://tripay.co.id/developer

    $getSuccess = $closeTransaction->getSuccess();
    $getStatusCode = $closeTransaction->getStatusCode();
    $response = $closeTransaction->getJson();

    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
    $this->assertEquals('UNPAID', $response->data->status);
});

test('detail close transaction', function () use ($main, $init, $merchantRef) {
    $closeTransaction = $init->closeTransaction();
    $reference = 'DEV-T215435003H5EEP';
    $getDetailCloseTransaction = $closeTransaction->getDetail($reference)->getData();
    
    $this->assertEquals($reference, $getDetailCloseTransaction->reference);
});

test('open transaction', function () use ($main, $init, $merchantRef) {
    $init->setMethod('BRIVAOP');
    $signature = $init->createSignature();

    $openTransaction = $init->openTransaction();

    $openTransaction->setPayload([
        'method'            => $init->getMethod(),
        'merchant_ref'      => $merchantRef,
        'customer_name'     => 'Nama Pelanggan',
        'signature'         => $init->createSignature()
    ]); // set your payload, with more examples https://tripay.co.id/developer

    $getSuccess = $openTransaction->getSuccess();
    $getStatusCode = $openTransaction->getStatusCode();
    $response = $openTransaction->getJson();

    $this->assertTrue($getSuccess);
    $this->assertEquals(200, $getStatusCode);
    $this->assertEquals('Successfully generate transaction', $response->message);
});