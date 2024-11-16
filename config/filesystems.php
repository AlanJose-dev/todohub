<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'root' => storage_path('app/private'),
        ],

        'public' => [
            'root' => storage_path('app/public'),
        ],

    ],

];