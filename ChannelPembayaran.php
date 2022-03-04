<?php namespace Tripay\Request;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;
use Tripay\Request\URL;

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
    public $code;

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
    public function __construct($apiKey, $mode, $code = null) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->code = $code;
    }

    /**
     * @return object
     */
    public function getChannelPembayaran()
    {
        if ($this->mode === 'live') {

            return $this->getRequest(URL::URL_PRODUCTION_CHANNEL_PEMBAYARAN);

        } else if ($this->mode === 'sandbox') {

            return $this->getRequest(URL::URL_SANDBOX_CHANNEL_PEMBAYARAN);

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