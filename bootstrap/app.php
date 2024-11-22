<?php
/**
 * The app file contains essential application function
 * calls.
 */

use App\ServiceContainer;

$serviceContainer = new ServiceContainer;

$serviceContainer->bind('_env', function() {
    return Dotenv\Dotenv::createImmutable(BASE_PATH)->load();
});

$serviceContainer->bind('_log', function() {
    $logFileName = 'app_' . date('Y_m_d') . '.log';
    $logger = new \Monolog\Logger('app_log');
    $logger->pushHandler(
        new \Monolog\Handler\StreamHandler(BASE_PATH . "storage/logs/{$logFileName}")
    );
    return $logger;
});

$serviceContainer->bind('_request_client', function() {
    return new \GuzzleHttp\Client([
        'base_url' => env('APP_URL'),
    ]);
});

$serviceContainer->bind('_session', function() {
    return new Symfony\Component\HttpFoundation\Session\Session();
});

\App\Application::setServiceContainer($serviceContainer);

\App\Application::getServiceContainer()->resolve('_env');

\App\Facades\DB::init(env('DB_DRIVER', 'sqlite'));
\App\Facades\Storage::init(env('FILESYSTEM_DISK', 'local'));