<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Auth\Http\Controllers\AccessTokenController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.api.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.api.guard')])),
];

Route::post('token', [AccessTokenController::class, 'store']);

Route::middleware($middleware['auth'])->group(function () {
    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('token', 'show');
        Route::delete('token', 'destroy');
    });
});
