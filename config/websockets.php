<?php

return [
    'apps' => [
        [
            'id' => env('PUSHER_APP_ID', 'local'),
            'name' => env('APP_NAME', 'EventManager'),
            'key' => env('PUSHER_APP_KEY', 'localkey'),
            'secret' => env('PUSHER_APP_SECRET', 'localsecret'),
            'path' => env('PUSHER_APP_PATH', ''),
            'capacity' => null,
            'enable_client_messages' => false,
            'enable_statistics' => true,
        ],
    ],

    'dashboard' => [
        'port' => env('WEBSOCKETS_PORT', 6001),
    ],

    'allowed_origins' => [
        '127.0.0.1',
        'localhost',
    ],

    'max_request_size_in_kb' => 250,

    'metrics' => [
        'enable_redis_replication' => false,
        'redis_replication_connection' => 'default',
    ],

    'ssl' => [
        'local_cert' => null,
        'local_pk' => null,
        'passphrase' => null,
        'verify_peer' => false,
    ],
];
