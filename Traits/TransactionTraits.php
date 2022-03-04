<?php namespace Tripay\Request\Traits;

/**
 * Trait TransactionTraits
 * @package Tripay\Request\Traits
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
trait TransactionTraits
{
    public $method;
    public $amount;

    /**
     * @param string $method
     */
    public function setMethod($method = null) {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $amount
     */
    public function setAmount($amount = null) {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
    }
}