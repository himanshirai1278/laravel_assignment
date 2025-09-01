<?php

return [

    'apps' => [
        [
            'id' => env('PUSHER_APP_ID', 'app-id'),
            'name' => env('APP_NAME', 'Laravel'),
            'key' => env('PUSHER_APP_KEY', 'app-key'),
            'secret' => env('PUSHER_APP_SECRET', 'app-secret'),
            'capacity' => null,
            'enable_client_messages' => true,
            'enable_statistics' => true,
        ],
    ],

    'dashboard' => [
        'port' => env('LARAVEL_WEBSOCKETS_PORT', 6001),
    ],

    'port' => env('LARAVEL_WEBSOCKETS_PORT', 6001),
];
