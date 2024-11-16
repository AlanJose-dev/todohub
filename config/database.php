<?php

return [

    'default' => env('DB_CONNECTION', 'sqlite'),

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]) : [],
        ],

    ],

];