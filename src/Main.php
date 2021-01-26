<?php

namespace Tripay;

use Tripay\Methods\MainInterface;
use Tripay\Request\ChannelPembayaran;
use Tripay\Request\InstruksiPembayaran;
use Tripay\Request\KalkulatorBiaya;
use Tripay\Request\MerchantChannelPembayaran;
use Tripay\Request\Transaction;
use Tripay\Request\Callback;

/**
 * Class Main
 * @package Tripay
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class Main implements MainInterface {

    /**
     * @var
     */
    private $apiKey;
    private $privateKey;
    private $merchantCode;
    private $mode;

    /**
     * Main constructor.
     * @param string $apiKey
     * @param string $privateKey
     * @param string $merchantCode
     * @param string|string $mode
     */
    public function __construct(string $apiKey, string $privateKey, string $merchantCode, string $mode = 'live') {
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->merchantCode = $merchantCode;
        $this->mode = $mode;
    }

    /**
     * @return ChannelPembayaran
     */
    public function initChannelPembayaran() {
        return new ChannelPembayaran(
            $this->apiKey,
            $this->mode
        );
    }

    /**
     * @param $code
     * @return InstruksiPembayaran
     */
    public function initInstruksiPembayaran(string $code) {
        return new InstruksiPembayaran($code, $this->apiKey, $this->mode);
    }

    /**
     * @param null $code
     * @return InstruksiPembayaran
     * @throws \Exception
     */
    public function initMerchantChannelPembayaran(string $code) {
        return new MerchantChannelPembayaran(
            $code,
            $this->apiKey,
            $this->mode
        );
    }

    /**
     * @param null $code
     * @param null $amount
     * @return KalkulatorBiaya
     * @throws \Exception
     */
    public function initKalkulatorBiaya(string $code, int $amount)
    {
        return new KalkulatorBiaya(
            $code,
            $amount,
            $this->apiKey,
            $this->mode
        );
    }

    /**
     * @param string $merchantRef
     * @return Transaction
     */
    public function initTransaction(string $merchantRef)
    {
        return new Transaction(
            $merchantRef,
            $this->apiKey,
            $this->privateKey,
            $this->merchantCode,
            $this->mode
        );
    }

    /**
     * @return Callback
     */
    public function initCallback() {
        return new Callback(
            $this->privateKey
        );
    }
}
