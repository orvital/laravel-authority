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
    | Routes Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware assigned to the routes.
    |
    */

    'middleware' => ['web', 'splade'],
];
