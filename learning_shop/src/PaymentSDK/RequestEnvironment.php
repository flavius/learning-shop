<?php


namespace App\PaymentSDK;


class RequestEnvironment
{
    private $server;
    private $parameters;

    public function __construct($get, $post, $server)
    {
        $this->parameters = $get + $post;
        $this->server = $server;
    }

    public function hasQueryParameter(string $name)
    {
        return isset($this->parameters[$name]);
    }

    public function getQueryParameter(string $name)
    {
        return $this->parameters[$name];
    }

    public function getAll()
    {
        return $this->parameters;
    }
}