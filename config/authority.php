<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Home Path
    |--------------------------------------------------------------------------
    |
    | The path where users will get redirected after authentication.
    |
    */

    'home' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Route Groups Attributes
    |--------------------------------------------------------------------------
    |
    | The middleware assigned to the routes.
    | The authentication guard that should be used while authenticating users.
    |
    */

    'api' => [
        'middleware' => ['api'],
        'prefix' => 'api',
        'guard' => 'sanctum',
    ],

    'auth' => [
        'middleware' => ['web'],
        'prefix' => 'auth',
        'guard' => 'session',
    ],

    'user' => [
        'middleware' => ['web'],
        'prefix' => 'user',
        'guard' => 'session',
    ],

];
