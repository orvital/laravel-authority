<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\AccessTokenController;
use Orvital\Authority\Http\Controllers\AuthenticateController;
use Orvital\Authority\Http\Controllers\RegisterController;

Route::middleware('guest')->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });

    Route::controller(AuthenticateController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });
});

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->group(function () {
    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('token', 'index')->name('token.index');
        Route::post('token', 'store')->name('token.store');
        Route::delete('token/{token}', 'destroy')->name('token.destroy');
    });

    Route::post('logout', [AuthenticateController::class, 'destroy'])->name('logout');
});
