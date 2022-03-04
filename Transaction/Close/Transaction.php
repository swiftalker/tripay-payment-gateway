<?php namespace Tripay\Request\Transaction\Close;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;
use Tripay\Request\URL;

/**
 * Class Transaction
 * @package Tripay\Request\Transaction\Close
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class Transaction implements RequestInterface {

    /**
     * @var
     */
    public $data;
    public $mode;
    public $apiKey;

    /**
     * CloseTransaction constructor.
     */
    public function __construct($mode, $apiKey) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
    }

    /**
     * @param array $data
     */
    public function setPayload(array $data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getPayload() {
        return $this->data;
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCloseTransaction() {
        if ($this->mode === 'live') {

            return $this->getRequest(URL::URL_PRODUCTION_CLOSE_TRANSACTION);

        } else if ($this->mode === 'sandbox') {

            return $this->getRequest(URL::URL_SANDBOX_CLOSE_TRANSACTION);

        }
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequest(string $url): object
    {
        $client = new Client();
        $res = $client->request('POST', $url, [
            'form_params' => $this->getPayload(),
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
        return $this->getCloseTransaction()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getCloseTransaction()->getStatusCode();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJson()
    {
        return json_decode($this->getCloseTransaction()->getBody()->getContents());
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

    /**
     * @param string $reference
     * @return Detail Close Transaction
     */
    public function getDetail(string $reference) {
        return new Detail(
            $reference,
            $this->mode,
            $this->apiKey
        );
    }
}