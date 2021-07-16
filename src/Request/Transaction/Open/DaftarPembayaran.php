<?php namespace Tripay\Request\Transaction\Open;


use GuzzleHttp\Client;

class DaftarPembayaran
{
    /**
     * @var
     */
    public $uuid;
    public $mode;
    public $apiKey;

    /**
     * URL
     */
    public const URL_SANDBOX = null;
    public const URL_PRODUCTION = 'https://tripay.co.id/api/open-payment/';

    /**
     * Detail Close Transaction constructor.
     */
    public function __construct($uuid, $mode, $apiKey) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->uuid = $uuid;
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDaftarPembayaran() {
        if ($this->mode === 'live') {

            return $this->getRequest(self::URL_PRODUCTION.$this->uuid.'/transactions');

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
        return $this->getDaftarPembayaran()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getDaftarPembayaran()->getStatusCode();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJson()
    {
        return json_decode($this->getDaftarPembayaran()->getBody()->getContents());
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