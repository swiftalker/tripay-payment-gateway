<?php namespace Tripay\Methods;

/**
 * Interface MainInterface
 * @package Tripay\Methods
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
interface MainInterface {

    public function initChannelPembayaran();

    public function initInstruksiPembayaran(
        string $code
    );

    public function initMerchantChannelPembayaran(
        string $code
    );

    public function initKalkulatorBiaya(
        string $code,
        int $amount
    );

    public function initTransaction(
        string $merchantRef
    );

    public function initCallback();
}
