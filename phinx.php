<?php

require __DIR__ . '/public/index.php';

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeders'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => env('DB_DRIVER'),
            'host' => env('DB_HOST'),
            'name' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME', 'root'),
            'pass' => env('DB_PASSWORD'),
            'port' => env('DB_PORT', 3306),
            'charset' => env('DB_CHARSET', 'utf8'),
        ],
        'development' => [
            'adapter' => env('DB_DRIVER'),
            'host' => env('DB_HOST'),
            'name' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME', 'root'),
            'pass' => env('DB_PASSWORD'),
            'port' => env('DB_PORT', 3306),
            'charset' => env('DB_CHARSET', 'utf8'),
        ],
        'testing' => [
            'adapter' => env('DB_DRIVER'),
            'host' => env('DB_HOST'),
            'name' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME', 'root'),
            'pass' => env('DB_PASSWORD'),
            'port' => env('DB_PORT', 3306),
            'charset' => env('DB_CHARSET', 'utf8'),
        ]
    ],
    'version_order' => 'creation'
];
