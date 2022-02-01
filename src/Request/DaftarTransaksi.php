<?php namespace Tripay\Request;

use GuzzleHttp\Client;
use Tripay\Methods\RequestInterface;

/**
 * Class DaftarTransaksi
 * @package Tripay\Request
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class DaftarTransaksi implements RequestInterface
{
    /**
     * @var 
     */
    private $mode;
    private $apiKey;
    public $page;
    public $per_page;
    public $sort;
    public $reference;
    public $merchant_ref;
    public $method;
    public $status;

    public const URL_SANDBOX = 'https://tripay.co.id/api-sandbox/merchant/transactions?';
    public const URL_PRODUCTION = 'https://tripay.co.id/api/merchant/transactions?';

    /**
     * @var array
     */
    public $response;
    public $statusCode;
    public $json;

    /**
     * DaftarTransaksi constructor.
     */
    public function __construct(
        $apiKey,
        $mode,
        int $page = 1, 
        int $per_page = 50, 
        string $sort = 'desc',
        string $reference = null,
        string $merchant_ref = null,
        string $method = null,
        string $status = null
    ) {
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->page = $page;
        $this->per_page = $per_page;
        $this->sort = $sort;
        $this->reference = $reference;
        $this->merchant_ref = $merchant_ref;
        $this->method = $method;
        $this->status = $status;
    }

    /**
     * @return object
     */
    public function getDaftarTransaksi()
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

        $payload = [
            'per_page' => $this->per_page,
            'page' => $this->page,
            'sort' => $this->sort,
            'reference' => $this->reference,
            'merchant_ref' => $this->merchant_ref,
            'method' => $this->method,
            'status' => $this->status
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
        return $this->getDaftarTransaksi()->getBody()->getContents();
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->getDaftarTransaksi()->getStatusCode();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJson()
    {
        return json_decode($this->getDaftarTransaksi()->getBody()->getContents());
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