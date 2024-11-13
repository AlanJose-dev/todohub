<?php
/**
 * The app file contains essential application function
 * calls.
 */

use App\ServiceContainer;

$serviceContainer = new ServiceContainer;

$serviceContainer->bind('_env', fn() =>
    (Dotenv\Dotenv::createImmutable(BASE_PATH)->load())
);
$serviceContainer->bind('_request', fn() =>
    (new \GuzzleHttp\Client([
        'base_url' => env('APP_URL'),
    ]))
);

\App\Application::setServiceContainer($serviceContainer);

\App\Application::getServiceContainer()->resolve('_env');