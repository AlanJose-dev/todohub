<?php

use App\Http\Router;

Router::get('/', [\App\Http\Controllers\HomeController::class, 'welcome'], [
    'name' => 'home',
]);

Router::get('/user/create', [\App\Http\Controllers\UserController::class, 'create'], [
    'name' => 'user.create',
]);

Router::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'], [
    'name' => 'user.store',
]);