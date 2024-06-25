<?php

return [
    // Default authentication settings
    'defaults' => [
        'guard' => 'api',       // Default guard (authentication driver)
        'passwords' => 'users', // Default password reset provider
    ],

    // Authentication guards configuration
    'guards' => [
        'api' => [                               // Guard named 'api'
            'driver' => 'jwt',                  // Authentication driver (JWT)
            'provider' => 'users',               // User provider for this guard
        ],
    ],

    // User providers configuration
    'providers' => [
        'users' => [                                  // User provider named 'users'
            'driver' => 'eloquent',                   // Eloquent model driver
            'model' => \App\Models\User::class        // User model class
        ]
    ]
];
