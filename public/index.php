<?php
/**
 * The application entry point.
 */
const BASE_PATH = __DIR__ . '/../';

/**
 * Calling autoloads.
 */
require BASE_PATH . 'vendor/autoload.php';

/**
 * Calling app initializer.
 */
require BASE_PATH . 'bootstrap/app.php';

\App\Facades\Session::start();

\App\Http\Router::init();
\App\Http\Router::loadRouteFiles([
    'web',
]);

if(isset($_SERVER['REQUEST_URI'])) {
    $requestUri = $_SERVER['REQUEST_URI'];
    $httpKernel = new \App\Http\HttpKernel(\App\Http\Router::getRouteCollection());
    $httpKernel->handle($requestUri);
}

\App\Facades\Session::unflash();