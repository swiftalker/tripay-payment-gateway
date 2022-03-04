<?php 

namespace Tripay\Request;

/**
 * Class URL
 * @package Tripay\Request
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class URL {

    /**
     * For URL Merchant Channel Pembayaran
     * 
     * @var string
     */
    public const URL_SANDBOX_MERCHANT_CHANNEL_PEMBAYARAN = 'https://tripay.co.id/api-sandbox/merchant/payment-channel?';
    public const URL_PRODUCTION_MERCHANT_CHANNEL_PEMBAYARAN = 'https://tripay.co.id/api/merchant/payment-channel?';

    /**
     * For URL Kalkulator Biaya
     * 
     * @var string
     */
    public const URL_SANDBOX_KALKULATOR_BIAYA = 'https://tripay.co.id/api-sandbox/merchant/payment-channel?';
    public const URL_PRODUCTION_KALKULATOR_BIAYA = 'https://tripay.co.id/api/merchant/payment-channel?';

    /**
     * For URL Instruksi Pembayaran
     * 
     * @var string
     */
    public const URL_SANDBOX_INSTRUKSI_PEMBAYARAN = 'https://tripay.co.id/api-sandbox/payment/instruction?';
    public const URL_PRODUCTION_INSTRUKSI_PEMBAYARAN = 'https://tripay.co.id/api/payment/instruction?';

    /**
     * For URL Daftar Transaksi
     * 
     * @var string
     */
    public const URL_SANDBOX_DAFTAR_TRANSAKSI = 'https://tripay.co.id/api-sandbox/merchant/transactions?';
    public const URL_PRODUCTION_DAFTAR_TRANSAKSI = 'https://tripay.co.id/api/merchant/transactions?';

    /**
     * For URL Channel Pembayaran
     * 
     * @var string
     */
    public const URL_SANDBOX_CHANNEL_PEMBAYARAN = 'https://tripay.co.id/api-sandbox/payment/channel?';
    public const URL_PRODUCTION_CHANNEL_PEMBAYARAN = 'https://tripay.co.id/api/payment/channel?';

    /**
     * For URL Detail Close Transaction 
     * 
     * @var string
     */
    public const URL_SANDBOX_DETAIL_CLOSE_TRANSACTION = 'https://tripay.co.id/api-sandbox/transaction/detail';
    public const URL_PRODUCTION_DETAIL_CLOSE_TRANSACTION = 'https://tripay.co.id/api/transaction/detail';

    /**
     * For URL Close Transaction 
     * 
     * @var string
     */
    public const URL_SANDBOX_CLOSE_TRANSACTION = 'https://tripay.co.id/api-sandbox/transaction/create';
    public const URL_PRODUCTION_CLOSE_TRANSACTION = 'https://tripay.co.id/api/transaction/create';

    /**
     * For URL Open Transaction
     * 
     * @var string
     */
    public const URL_SANDBOX_OPEN_TRANSACTION = null;
    public const URL_PRODUCTION_OPEN_TRANSACTION = 'https://tripay.co.id/api/open-payment/';
}