<?php

return [
    'email' => [
        'user_created' => [
            'subject' => config('app.name').' - Sua conta foi criada com sucesso!'
        ]
    ],
    'middleware' => [
        'isVerified' => 'isVerified'
    ],
    'user_default' => [
        'name' => env('USER_NAME', 'Administrador'),
        'email' => env('USER_EMAIL', 'admin@user.com'),
        'password' => env('USER_PASSWORD', 'secret'),
        'verified' => 1
    ],
    'acl' => [
        'role_admin' => env('ROLE_ADMIN', 'Admin'),
        'controllers_annotations' => []
    ]
];
