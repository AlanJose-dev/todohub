<?php

namespace Core\Http;

use Core\Http\Controllers\HeaderBag;

/**
 * Handle the incoming request.
 */
class Request
{
    /**
     * Current request method.
     * @var string|mixed
     */
    private string $method;

    /**
     * Object to handle the current request uri.
     * @var Uri|array|false|int|string|null
     */
    private Uri $uri;

    /**
     * Stores and handle the request inputs.
     * @var InputBag
     */
    private InputBag $inputBag;

    /**
     * Stores and handle the request headers.
     * @var HeaderBag
     */
    private HeaderBag $headerBag;

    public function __construct()
    {
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
        $this->uri = new Uri(parse_url($_SERVER['REQUEST_URI']));
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->inputBag = new InputBag($this->method === 'GET' ? $_GET : $_POST);
        $this->headerBag = new HeaderBag(getallheaders());
    }
}
