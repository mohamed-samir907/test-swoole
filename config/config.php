<?php

return [
    'db' => [
        'host' => env('DB_HOST'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
    ],

    'server' => [
        'reactor_num' => env('REACTOR_NUM'),
        'worker_num' => env('WORKER_NUM'),
        'max_request' => env('MAX_REQUEST')
    ]
];
