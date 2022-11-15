<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\User\Http\Controllers\AccessTokenController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->group(function () {
    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('token', 'index')->name('token.index');
        Route::post('token', 'store')->name('token.store');
        Route::delete('token/{token}', 'destroy')->name('token.destroy');
    });
});
