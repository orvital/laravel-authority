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
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | The authentication guard that should be used while authenticating users.
    |
    */

    'guard' => 'session',

    /*
    |--------------------------------------------------------------------------
    | Routes Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware assigned to the routes.
    |
    */

    'middleware' => ['web', 'splade'],

];
