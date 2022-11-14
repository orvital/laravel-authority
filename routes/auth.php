<?php

use Illuminate\Support\Facades\Route;
use Orvital\Auth\Http\Controllers\AuthenticateController;
use Orvital\Auth\Http\Controllers\RegisterController;

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

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'destroy'])->name('logout');
});
