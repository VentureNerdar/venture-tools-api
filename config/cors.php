<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Options
    |--------------------------------------------------------------------------
    |
    | This file allows you to configure the CORS (Cross-Origin Resource Sharing)
    | settings for your application. Feel free to modify the settings as needed
    | for your particular application.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'auth/login', 'auth/logout'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000', 'http://localhost:3002', 'https://web.venture-tools.klonotech.com', 'https://mobile.venture-tools.klonotech.com', 'http://localhost', 'capacitor://localhost', 'ionic://localhost'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
