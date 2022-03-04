<?php namespace Tripay\Request\Transaction\Open;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;
use Tripay\Request\URL;

/**
 * Class Detail Open Transaction
 * @package Tripay\Request\Transaction\Close
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class Detail implements RequestInterface 
{
    /**
     * @var
     */
    public $uuid;
    public $mode;
    public $apiKey;

    public function __construct($uuid, $mode, $apiKey) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->uuid = $uuid;
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDetailTransaction() {
        if ($this->mode === 'live') {

            return $this->getRequest(URL::URL_PRODUCTION_OPEN_TRANSACTION.$this->uuid.'/detail');

        } else if ($this->mode === 'sandbox') {

            throw new \Exception('The sandbox is not open in open transaction mode!');

        }
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequest(string $url): object
    {
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
        return $this->getDetailTransaction()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getDetailTransaction()->getStatusCode();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJson()
    {
        return json_decode($this->getDetailTransaction()->getBody()->getContents());
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