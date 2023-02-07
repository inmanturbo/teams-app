<?php

return [
    'route_prefix' => '/blade-icons',

    'middleware' => [
        'web',
    ],

    'db_connection' => env('LANDLORD_DB_CONNECTION', 'landlord'),
];
