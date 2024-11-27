<?php

use App\Http\Router;

Router::get('/', function() {
    \App\Facades\Support\View::make('welcome')->render();
});

Router::get('/register', [\App\Http\Controllers\UserController::class, 'create']);

Router::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'], [
    'middlewares' => [
        \App\Http\Middlewares\CsrfToken::class
    ]
]);

Router::get('/login', [\App\Http\Controllers\LoginController::class, 'create']);

Router::post('/login', [\App\Http\Controllers\LoginController::class, 'login'], [
    'middlewares' => [
        \App\Http\Middlewares\CsrfToken::class
    ]
]);

Router::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'], [
    'middlewares' => [
        \App\Http\Middlewares\CsrfToken::class
    ]
]);

Router::get('/dashboard', function() {
    App\Facades\Support\View::make('dashboard')->render();
}, [
    'middlewares' => [
        \App\Http\Middlewares\Authenticated::class,
    ],
]);

Router::get('/teste', function() {
    $format = function ($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    };
    $users = \App\Models\User::select(limit: 0);

    dd($users, "Memory usage: " . $format(memory_get_usage()), "Memory peak usage: " . $format(memory_get_peak_usage()));
});