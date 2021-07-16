<?php


namespace Tripay\Request;

use Tripay\Methods\RequestInterface;
use GuzzleHttp\Client;

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
    private $code;
    private const URL_SANDBOX = 'https://tripay.co.id/api-sandbox/payment/instruction?';
    private const URL_PRODUCTION = 'https://tripay.co.id/api/payment/instruction?';

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
    public function __construct($code = null, $apiKey, $mode) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->code = $code;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInstruksiPembayaran() {

        if ($this->mode === 'live') {

            return $this->getRequest(self::URL_PRODUCTION);

        } else if ($this->mode === 'sandbox') {

            return $this->getRequest(self::URL_SANDBOX);

        }
    }

    /**
     * @param $url
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequest(string $url) : object {
        $client = new Client();
        $res = $client->request('GET', $url.http_build_query(['code' => $this->code]), [
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