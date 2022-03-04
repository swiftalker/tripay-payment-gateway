<?php

namespace Tripay\Request;

use Tripay\Request\Traits\TransactionTraits;
use Tripay\Request\Transaction\Close\Transaction as CloseTransaction;
use Tripay\Request\Transaction\Open\Transaction as OpenTransaction;

/**
 * Class Transaction
 * @package Tripay\Request
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
class Transaction {

    use TransactionTraits;

    /**
     * @var
     */
    public $privateKey;
    public $apiKey;
    public $merchantCode;
    public $mode;
    public $merchantRef;
    public $method;

    /**
     * Transaction constructor.
     * @param $merchantRef
     * @param $apiKey
     * @param $privateKey
     * @param $merchantCode
     * @param $mode
     */
    public function __construct($merchantRef, $apiKey, $privateKey, $merchantCode, $mode) {
        $this->merchantRef = $merchantRef;
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->merchantCode = $merchantCode;
        $this->mode = $mode;
    }

    /**
     * @return string
     */
    public function createSignature()
    {
        if ( ( $this->getMethod() OR $this->getAmount() ) == null) {
            throw new \Exception('Amount or Method cannot be null!');
        }

        if ($this->getAmount() != null) {
            $data = $this->merchantCode.$this->merchantRef.$this->getAmount();
        }

        if ($this->getMethod() != null) {
            $data = $this->merchantCode.$this->getMethod().$this->merchantRef;
        }

        return hash_hmac(
            'sha256',
                $data,
                $this->privateKey
        );
    }

    /**
     * @return CloseTransaction
     */
    public function closeTransaction() {
       return new CloseTransaction(
           $this->mode,
           $this->apiKey
       );
    }

    /**
     * @return OpenTransaction
     */
    public function openTransaction() {
        return new OpenTransaction(
            $this->mode,
            $this->apiKey
        );
    }
}