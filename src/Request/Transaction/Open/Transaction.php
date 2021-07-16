<?php namespace Tripay\Request\Transaction\Open;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;
use Tripay\Request\Transaction\Open\Detail;
use Tripay\Request\Transaction\Open\DaftarPembayaran;

/**
 * Class Open Transaction
 * @package Tripay\Request\Transaction\Open
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
     * URL
     */
    public const URL_SANDBOX = null;
    public const URL_PRODUCTION = 'https://tripay.co.id/api/open-payment/create';

    /**
     * OpenTransaction constructor.
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
    public function getOpenTransaction() {
        if ($this->mode === 'live') {

            return $this->getRequest(self::URL_PRODUCTION);

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
        return $this->getOpenTransaction()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getOpenTransaction()->getStatusCode();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJson()
    {
        return json_decode($this->getOpenTransaction()->getBody()->getContents());
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
     * @param string $uuid
     * @return \Tripay\Request\Transaction\Open\Detail
     */
    public function getDetail(string $uuid) {
        return new Detail(
            $uuid,
            $this->mode,
            $this->apiKey
        );
    }

    public function getDaftarPembayaran(string $uuid) {
        return new DaftarPembayaran(
            $uuid,
            $this->mode,
            $this->apiKey
        );
    }
}