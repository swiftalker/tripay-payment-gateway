<?php

namespace Tripay;

require_once dirname(__DIR__) . '/vendor/autoload.php';
use Tripay\Methods\MainInterface;
use Tripay\Request\ChannelPembayaran;
use Tripay\Request\InstruksiPembayaran;
use Tripay\Request\KalkulatorBiaya;
use Tripay\Request\MerchantChannelPembayaran;
use Tripay\Request\Transaction;
use Tripay\Request\Callback;
use Dotenv\Dotenv;

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
    public function __construct(
        string $apiKey = null, 
        string $privateKey = null, 
        string $merchantCode = null, 
        string $mode = 'live'
    ) {
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

    /**
     * Untuk membaca konfigurasi env
     */
    public function readenv(String $env_key = null)
    {
        $immutable = null;

        switch ($this->detect_what_is_framework()) {
            case 'laravel':
                $immutable = base_path();
                break;

            case 'codeigniter':
                $immutable = FCPATH;
                break;

            default:
                $immutable = dirname(__DIR__);
                break;
        }

        $dotenv = Dotenv::createImmutable($immutable);
        $dotenv->load();
        $dotenv->required('TRIPAY_apiKey');
        $dotenv->required('TRIPAY_privateKey');
        $dotenv->required("TRIPAY_merchantCode");
        $dotenv->required("TRIPAY_mode");

        if (empty($env_key)) {
            return $_ENV;
        }

        return $_ENV[$env_key];
    }

    /**
     * Mendeteksi apakah projek ini diinstal pada framework laravel?
     * atau framework lainnya
     */
    public function detect_what_is_framework()
    {
        if (defined("LARAVEL_START") and class_exists(\Illuminate\Foundation\Application::class)) {
            return "laravel";
        } else if (class_exists(\CodeIgniter\CodeIgniter::class)) {
            return "codeigniter";
        }

        return null;
    }
}
