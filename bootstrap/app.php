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

$serviceContainer->bind('_exception_handler', function () {
    $whoops = new \Whoops\Run();
    $whoops->allowQuit(true);
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    return $whoops;
});

$serviceContainer->bind('_database', function() {
    return \App\Facades\Support\DB::connection();
});

\App\Application::setServiceContainer($serviceContainer);

\App\Application::getServiceContainer()->resolve('_env');

\App\Facades\Support\DB::init(env('DB_DRIVER', 'sqlite'));
\App\Facades\Support\Storage::init(env('FILESYSTEM_DISK', 'local'));

set_exception_handler(new \App\Exceptions\ExceptionHandler());