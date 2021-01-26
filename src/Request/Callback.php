<?php namespace Tripay\Request;

use Symfony\Component\HttpFoundation\Request;

class Callback
{
    /**
     * @var
     */
    public $request;
    public $privateKey;

    /**
     * Callback constructor.
     * @param $privateKey
     */
    public function __construct($privateKey) {
        $this->privateKey = $privateKey;
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return false|resource|string|null
     */
    public function get() {
        return $this->request->getContent();
    }

    /**
     * @return mixed
     */
    public function getJson() {
        return json_decode($this->get());
    }

    /**
     * @return string
     */
    public function signature() {
        return hash_hmac('sha256', $this->get(), $this->privateKey);
    }

    /**
     * @return string
     */
    public function callbackSignature()
    {
        return isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
    }

    /**
     * @return mixed
     */
    public function callEvent() {
        return isset($_SERVER['HTTP_X_CALLBACK_EVENT']) ? $_SERVER['HTTP_X_CALLBACK_EVENT'] : '';
    }

    /**
     * @return string
     */
    public function validateSignature() : bool
    {
        if( $this->callbackSignature() !== $this->signature() ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validateEvent() : bool {
        if ( $this->callEvent() == 'payment_status') {

            if ( $this->getJson() == 'PAID' ) {
                return true;
            }

            return false; // not paid
        }

        return false; // there are several reasons, maybe an undefined call event? or payment status undefined
    }
}
