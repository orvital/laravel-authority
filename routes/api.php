<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\ApiTokenController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.api.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.api.guard')])),
];

Route::post('token', [ApiTokenController::class, 'store']);

Route::middleware($middleware['auth'])->group(function () {
    Route::controller(ApiTokenController::class)->group(function () {
        Route::get('token', 'show');
        Route::delete('token', 'destroy');
    });
});
