<?php

namespace Core\Http;

class Request
{
    private string $method;

    // TODO: Create URI Object.
    private string $uri;

    private InputBag $inputBag;

    public function __construct()
    {
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->inputBag = new InputBag($this->method === 'GET' ? $_GET : $_POST);
    }
}
