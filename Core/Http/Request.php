<?php

namespace Core\Http;

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
        $this->inputBag = new InputBag($this->method === 'GET' ? $_GET : $_POST);
        $this->headerBag = new HeaderBag(getallheaders());
    }

    /**
     * Gets the request method.
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Get the request uri object.
     * @return Uri
     */
    public function uri(): Uri
    {
        return $this->uri;
    }

    /**
     * Get the request input bag.
     * @return InputBag
     */
    public function input(): InputBag
    {
        return $this->inputBag;
    }

    /**
     * Get the headers bag.
     * @return HeaderBag
     */
    public function headers(): HeaderBag
    {
        return $this->headerBag;
    }

    /**
     * Checks if the request is ajax.
     * @return bool
     */
    public function isAjax(): bool
    {
        // Ajax header.
        return $this->headerBag->get('X-Requested-With') === 'XMLHttpRequest';
    }

    /**
     * Checks if request is https.
     * @return bool
     */
    public function isHttps(): bool
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    }
}
