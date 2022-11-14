<?php

use Illuminate\Support\Facades\Route;
use Orvital\Auth\Passwords\Http\Controllers\PasswordConfirmationController;
use Orvital\Auth\Passwords\Http\Controllers\PasswordRecoveryController;
use Orvital\Auth\Passwords\Http\Controllers\PasswordResetController;

Route::middleware('guest')->group(function () {
    Route::controller(PasswordRecoveryController::class)->group(function () {
        Route::get('recovery', 'create')->name('password.request');
        Route::post('recovery', 'store')->name('password.email');
    });

    Route::controller(PasswordResetController::class)->group(function () {
        Route::get('reset/{token}', 'create')->name('password.reset');
        Route::post('reset', 'store')->name('password.update');
    });
});

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->group(function () {
    Route::controller(PasswordConfirmationController::class)->group(function () {
        Route::get('confirmation', 'show')->name('password.confirm');
        Route::post('confirmation', 'store')->middleware('throttle:6,1');
    });
});
