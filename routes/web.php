<?php

use App\Http\Router;

Router::get('/', [\App\Http\Controllers\HomeController::class, 'welcome'], [
    'name' => 'home',
]);

Router::get('/register', [\App\Http\Controllers\UserController::class, 'create'], [
    'name' => 'user.create',
]);

Router::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'], [
    'name' => 'user.store',
    'middlewares' => [
        \App\Http\Middlewares\CsrfToken::class
    ]
]);

Router::get('/login', [\App\Http\Controllers\LoginController::class, 'create'], [
    'name' => 'auth.login_form',
]);

Router::post('/login', [\App\Http\Controllers\LoginController::class, 'login'], [
    'name' => 'auth.login',
    'middlewares' => [
        \App\Http\Middlewares\CsrfToken::class
    ]
]);

Router::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'], [
    'name' => 'auth.logout',
    'middlewares' => [
        \App\Http\Middlewares\CsrfToken::class
    ]
]);

Router::get('/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'], [
    'name' => 'user.dashboard',
    'middlewares' => [
        \App\Http\Middlewares\Authenticated::class,
    ],
]);

Router::get('/teste', [\App\Http\Controllers\UserController::class, 'test'], [
    'name' => 'user.test',
]);