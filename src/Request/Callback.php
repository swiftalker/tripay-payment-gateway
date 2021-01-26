<?php namespace Tripay\Request;

use Symfony\Component\HttpFoundation\Request;

class Callback
{
    /**
     * @var
     */
    public $request;
    public $privateKey;

    public function __construct($privateKey) {
        $this->privateKey = $privateKey;
        $this->request = Request::createFromGlobals();
    }

    public function init() {
        return $this->request->getContent();
    }
}