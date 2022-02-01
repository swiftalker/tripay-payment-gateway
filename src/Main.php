<?php

namespace Tripay;

use Tripay\Methods\MainInterface;
use Tripay\Request\ChannelPembayaran;
use Tripay\Request\InstruksiPembayaran;
use Tripay\Request\KalkulatorBiaya;
use Tripay\Request\DaftarTransaksi;
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
     * Set Parameter
     * 
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
        string $mode = null
    ) {
        try {
            $this->apiKey = $apiKey ?? $this->readEnv('TRIPAY_API_KEY');
            if (is_null($this->apiKey) || $this->apiKey == '') {
                throw new \Exception('Api Key harus di isi!');
            }

            $this->privateKey = $privateKey ?? $this->readEnv('TRIPAY_PRIVATE_KEY');
            if (is_null($this->privateKey) || $this->privateKey == '') {
                throw new \Exception('Private Key harus di isi!');
            }

            $this->merchantCode = $merchantCode ?? $this->readEnv('TRIPAY_MERCHANT_CODE');
            if (is_null($this->merchantCode) || $this->merchantCode == '') {
                throw new \Exception('Merchant Code harus di isi!');
            }

            // variable $mode akan lebih diprioritaskan
            if (!empty($mode)) {
                $modeVar = $mode;
            } else if (!empty($this->readEnv('TRIPAY_MODE'))) {
                $modeVar = $this->readEnv('TRIPAY_MODE');
            } else {
                $modeVar = 'live';
            }

            $this->mode = $modeVar == 'live' || $modeVar == 'sandbox' ? $modeVar : 'live';
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * @return ChannelPembayaran
     */
    public function initChannelPembayaran($code = null) {
        return new ChannelPembayaran(
            $this->apiKey,
            $this->mode, 
            $code
        );
    }
    
    /**
     * @return DaftarTransaksi
     */
    public function initDaftarTransaksi(
        int $page = 1, 
        int $per_page = 50, 
        string $sort = 'desc',
        string $reference = null,
        string $merchant_ref = null,
        string $method = null,
        string $status = null
    ) {
        return new DaftarTransaksi(
            $this->apiKey,
            $this->mode,
            $page,
            $per_page,
            $sort,
            $reference,
            $merchant_ref,
            $method,
            $status
        );
    }
    /**
     * @param $code
     * @return InstruksiPembayaran
     */
    public function initInstruksiPembayaran(
        string $code, 
        string $payCode = null, 
        int $amount = null, 
        int $allowHtml = null
    ) {
        return new InstruksiPembayaran(
        
            $this->apiKey,
            $this->mode,
            $code,
            $payCode,
            $amount,
            $allowHtml
        );
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
    public function readEnv(String $env_key = null)
    {
        $immutable = null;

        switch ($this->detectWhatIsFramework()) {
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
        $load = $dotenv->safeLoad();

        if ( ! empty($load)) {
            $dotenv->required(['TRIPAY_API_KEY', 'TRIPAY_PRIVATE_KEY', 'TRIPAY_MERCHANT_CODE', 'TRIPAY_MODE']);

            if (empty($env_key)) {
                return $_ENV;
            }

            return $_ENV[$env_key];
        }
        
        return null;
    }

    /**
     * Mendeteksi apakah projek ini diinstal pada framework laravel?
     * atau framework lainnya
     */
    public function detectWhatIsFramework()
    {
        if (defined("LARAVEL_START") and class_exists(\Illuminate\Foundation\Application::class)) {
            return "laravel";
        } else if (class_exists(\CodeIgniter\CodeIgniter::class)) {
            return "codeigniter";
        }

        return null;
    }
}
