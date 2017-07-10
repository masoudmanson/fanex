<?php

return [
    'oracle' => [
        'driver'        => 'oracle',
//        'tns'           => env('DB_TNS', 'oradb'),
        'host'          => env('DB_HOST', '172.16.1.133'),
        'port'          => env('DB_PORT', '1521'),
//        'port'          => env('DB_PORT', '3306'),
        'database'      => env('DB_DATABASE', 'forge'),
        'username'      => env('DB_USERNAME', 'forge'),
        'password'      => env('DB_PASSWORD', ''),
        'charset'       => env('DB_CHARSET', 'utf8mb4'),
//        'charset'       => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'        => env('DB_PREFIX', ''),
        'prefix_schema' => env('DB_SCHEMA_PREFIX', ''),
    ],
];
