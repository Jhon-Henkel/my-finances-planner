<?php

use App\Enums\Database\DatabaseConnectionEnum;
use App\Enums\TimeNumberEnum;

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        DatabaseConnectionEnum::Master->value => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', ''),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql')
                ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA')])
                : []
        ],
        DatabaseConnectionEnum::Tenant->value => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => '',
            'username' => '',
            'password' => '',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql')
                ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA')])
                : []
        ],
        DatabaseConnectionEnum::Test->value => [
            'driver' => 'mysql',
            'host' => env('DB_TEST_HOST', 'mysql'),
            'database' => env('DB_TEST_DATABASE', 'testing'),
            'username' => env('DB_TEST_USERNAME', 'root'),
            'password' => env('DB_TEST_PASSWORD', '123'),
            'port' => env('DB_TEST_PORT', '3306'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
        ]
    ],
    'migrations' => 'migrations',
    'redis' => [
        'client' => env('REDIS_CLIENT'),
        'options' => [
            'cluster' => 'redis'
        ],
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT'),
            'database' => env('REDIS_DB'),
            'ttl' => TimeNumberEnum::ThreeHourInSeconds->value,
        ],
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB'),
            'ttl' => TimeNumberEnum::ThreeHourInSeconds->value,
        ]
    ]
];
