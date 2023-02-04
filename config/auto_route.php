<?php

return [

    'route_prefix' => 'qwoffice',
    'active' => env('AUTO_ROUTE_VIEWS', true),
    'root_dir' => 'office',
    'middleware' => [
        'web',
        'auth',
        'team.auth',
    ],
    'headers' => [
        'ap_detail_paystub' => [
            'Content-Type' => 'application/pdf',
        ],

        'pdf' => [
            'Content-Type' => 'application/pdf',
        ],
    ],
];
