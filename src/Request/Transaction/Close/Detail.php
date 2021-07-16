<?php namespace Tripay\Request\Transaction\Close;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;

/**
 * Class Detail Close Transaction
 * @package Tripay\Request\Transaction\Close
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class Detail implements RequestInterface {

    /**
     * @var
     */
    public $reference;
    public $mode;
    public $apiKey;

    /**
     * URL
     */
    public const URL_SANDBOX = 'https://tripay.co.id/api-sandbox/transaction/detail';
    public const URL_PRODUCTION = 'https://tripay.co.id/api/transaction/detail';

    /**
     * Detail Close Transaction constructor.
     */
    public function __construct($reference, $mode, $apiKey) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->reference = $reference;
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDetailTransaction() {
        if ($this->mode === 'live') {

            return $this->getRequest(self::URL_PRODUCTION);

        } else if ($this->mode === 'sandbox') {

            return $this->getRequest(self::URL_SANDBOX);

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
            'query' => ['reference' => $this->reference],
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