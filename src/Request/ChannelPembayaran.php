<?php

namespace Tripay\Request;

use phpDocumentor\Reflection\Types\Object_;
use Tripay\Methods\AbstractEngine;
use Tripay\Methods\RequestInterface;
use Tripay\Request\Traits\MainTraits;
use GuzzleHttp\Client;

/**
 * Class ChannelPembayaran
 * @package Tripay\Request
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class ChannelPembayaran implements RequestInterface {

    /**
     * @var
     */
    private $mode;
    private $apiKey;
    private const URL_SANDBOX = 'https://tripay.co.id/api-sandbox/payment/channel';
    private const URL_PRODUCTION = 'https://tripay.co.id/api/payment/channel';

    /**
     * @var array
     */
    public $response;
    public $statusCode;
    public $json;

    /**
     * ChannelPembayaran constructor.
     * @param $mode
     * @param $apiKey
     */
    public function __construct($apiKey, $mode) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
    }

    /**
     * @return array
     */
    public function getChannelPembayaran()
    {
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
        $res = $client->request('GET', $url, [
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
        return $this->getChannelPembayaran()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getChannelPembayaran()->getStatusCode();
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return json_decode($this->getChannelPembayaran()->getBody()->getContents());
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