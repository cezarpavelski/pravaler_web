<?php
return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'db'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'pravaler'),
            'username' => env('DB_USERNAME', 'pravaler'),
            'password' => env('DB_PASSWORD', 'secret'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => env('DB_PREFIX', ''),
            'strict' => false,
            'engine' => null,
        ],
    ],

    'migrations' => 'migrations',
];
