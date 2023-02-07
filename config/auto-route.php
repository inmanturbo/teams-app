<?php

return [

    'route_prefix' => env('AUTO_ROUTE_PREFIX', 'view'),
    'active' => env('AUTO_ROUTE_VIEWS', true),
    'root_dir' => 'auto-route',
    'middleware' => [
        'web',
        'auth',
        'team.auth',
    ],
    'headers' => [

        'pdf' => [
            'Content-Type' => 'application/pdf',
        ],
    ],
];
