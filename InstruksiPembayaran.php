<?php


namespace Tripay\Request;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;
use Tripay\Request\URL;

/**
 * Class InstruksiPembayaran
 * @package Tripay\Request
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class InstruksiPembayaran implements RequestInterface {

    /**
     * @var
     */
    private $mode;
    private $apiKey;
    public $code;
    public $payCode;
    public $amount;
    public $allowHtml;

    /**
     * @var array
     */
    public $response;
    public $statusCode;
    public $json;

    /**
     * InstruksiPembayaran constructor.
     * @param $code
     * @param $apiKey
     * @param $mode
     */
    public function __construct(
        $apiKey,
        $mode,
        string $code, 
        string $payCode = null, 
        int $amount = null, 
        int $allowHtml = null
    ) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->code = $code;
        $this->payCode = $payCode;
        $this->amount = $amount;
        $this->allowHtml = $allowHtml;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInstruksiPembayaran() {

        if ($this->mode === 'live') {

            return $this->getRequest(URL::URL_PRODUCTION_INSTRUKSI_PEMBAYARAN);

        } else if ($this->mode === 'sandbox') {

            return $this->getRequest(URL::URL_SANDBOX_INSTRUKSI_PEMBAYARAN);

        }
    }

    /**
     * @param $url
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequest(string $url) : object {
        $client = new Client();

        $payload = [
            'code' => $this->code, 
            'pay_code' => $this->payCode, 
            'amount' => $this->amount, 
            'allow_html' => $this->allowHtml
        ];

        $res = $client->request('GET', $url.http_build_query($payload), [
            'headers' => [
                "Authorization" => 'Bearer '.$this->apiKey
            ]
        ]);

        return $res;
    }

    /**
     * @return object
     */
    public function getResponse()
    {
        return $this->getInstruksiPembayaran()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getInstruksiPembayaran()->getStatusCode();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJson()
    {
        return json_decode($this->getInstruksiPembayaran()->getBody()->getContents());
    }

    /**
     * @return bool
     */
    public function getSuccess() : bool
    {
        return $this->getJson()->success;
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getData()
    {
        if ( isset($this->getJson()->data) ) {
            return $this->getJson()->data;
        }

        return $this->getResponse();
    }
}