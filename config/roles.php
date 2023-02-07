<?php

return [

    'admin' => [
        'name' => 'Administerator',
        'permissions' => [
            '*:create' => 'Can create any resource',
            '*:update' => 'Can update any resource',
            'records:read' => 'Can read records',
            'records:delete' => 'Can delete records',
            'own:read'  => 'Can read own records',
            'own:delete' => 'Can update own records',
        ],
        'description' => 'Administrators can perform any action.',
    ],

    'supervisor' => [
        'name' => 'Supervisor',
        'permissions' => [
            '*:create' => 'Can create any resource',
            '*:update' => 'Can update any resource',
            'records:read' => 'Can read records',
            'records:delete' => 'Can delete records',
            'own:read'  => 'Can read own records',
            'own:delete' => 'Can update own records',
        ],
        'description' => 'Supervisors can manage records.',
    ],

    'workforce' => [
        'name' => 'Workforce',
        'permissions' => [
            'own:create' => 'Can create own records',
            'own:read'  => 'Can read own records',
            'own:update' => 'Can update own records',
        ],
        'description' => 'Workforce can enter their own records.',
    ],

    'client' => [
        'name' => 'Client',
        'permissions' => [
            'own:read' => 'Can read own records',
        ],
        'description' => 'Clients can read their own records.',
    ],


];
