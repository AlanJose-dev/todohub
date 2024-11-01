<?php

$router->get('/', [\Core\Http\Controllers\HomeController::class, 'home']);
$router->get('/request', [\Core\Http\Controllers\HomeController::class, 'dumpRequest']);