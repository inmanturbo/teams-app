<?php

return [
    'event_projectors' => [
        //
    ],

    'db_connection' => env('TEAM_DB_CONNECTION', 'team'),

    'migration_path' => 'database/migrations',

    'empty_logo_path' => 'profile-photos/no_image.jpg',
    'empty_phone' => '(_ _ _) _ _ _- _ _ _ _',
    'empty_fax' => '(_ _ _) _ _ _- _ _ _ _',
    'logo_path' => env('TEAM_LOGO_PATH'),
    'name' => env('TEAM_NAME'),
    'phone' => env('TEAM_PHONE_NUMBER'),
    'fax' => env('TEAM_FAX_NUMBER'),
    'street_address' => env('TEAM_STREET_ADDRESS'),
    'city_state_zip' => env('TEAM_CITY_STATE_ZIP'),
    'email' => env('TEAM_EMAIL'),
];
