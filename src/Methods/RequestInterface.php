<?php namespace Tripay\Methods;

/**
 * Interface RequestInterface
 * @package Tripay\Methods
 *
 * @author Muhammad Adnan <naravaya04@gmail.com>
 */
interface RequestInterface {

    public function getRequest(string $url) : object;

    public function getResponse();

    public function getData();

    public function getStatusCode() : int ;

    public function getJson();

    public function getSuccess() : bool;

}