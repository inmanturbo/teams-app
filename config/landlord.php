<?php

return [
    'event_projectors' => [
        \App\Projectors\UserProjector::class,
        \App\Projectors\LinkProjector::class,
        \App\Projectors\TeamProjector::class,
        \App\Projectors\TeamDatabaseProjector::class,
    ],

    'db_connection' => env('LANDLORD_DB_CONNECTION', 'landlord'),

    'migration_path' => 'database/migrations/landlord',

    'url' => env('LANDLORD_URL', 'http://localhost'),

    'socialstream' => [
        'enabled' => env('SOCIALSTREAM_ENABLED', false),
    ]
];
