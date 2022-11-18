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

    'web' => [
        'middleware' => ['web', 'splade'],
        'guard' => 'session',
    ],

    'api' => [
        'middleware' => ['api'],
        'prefix' => 'api',
        'guard' => 'sanctum',
    ],

];
