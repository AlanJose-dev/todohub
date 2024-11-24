<?php

use App\Http\Router;

Router::get('/', [\App\Http\Controllers\HomeController::class, 'welcome']);

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

Router::get('/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'], [
    'middlewares' => [
        \App\Http\Middlewares\Authenticated::class,
    ],
]);

Router::get('/teste', function() {
    dd('REACHED');
});