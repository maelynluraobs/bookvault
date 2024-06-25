<?php

return [
    // Configuration for USERS1 service
    'users1' => [
        'base_uri' => env('USERS1_SERVICE_BASE_URL'), // Base URI for USERS1 service
        'key' => env('USERS1_SERVICE_KEY'),           // API key for USERS1 service
        'host' => env('USERS1_SERVICE_HOST'),         // Host for USERS1 service
    ],

    // Configuration for USER service
    'user' => [
        'base_uri' => env('USER_SERVICE_BASE_URL'),   // Base URI for USER service
        'host' => env('USER_SERVICE_HOST'),           // Host for USER service
        'key' => env('USER_SERVICE_KEY'),             // API key for USER service
    ],

    // Configuration for RENTAL service (if applicable)
    'rental' => [
        'base_uri' => env('RENTAL_SERVICE_BASE_URL'), // Base URI for RENTAL service (not defined in this snippet)
    ],

    // Configuration for Postman API
    'postman' => [
        'base_url' => env('POSTMAN_API_BASE_URL'),    // Base URL for Postman API
        'api_key' => env('POSTMAN_API_KEY'),          // API key for Postman API
    ],
];
