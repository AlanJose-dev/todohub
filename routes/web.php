<?php

use App\Http\Router;

Router::get('/', [\App\Http\Controllers\HomeController::class, 'welcome'], [
    'name' => 'home',
]);