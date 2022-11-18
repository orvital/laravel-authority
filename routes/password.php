<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Password\Http\Controllers\PasswordConfirmationController;
use Orvital\Authority\Password\Http\Controllers\RecoveryController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';
$guestMiddleware = config('authority.guard') ? 'guest:'.config('authority.guard') : 'guest';

Route::middleware($guestMiddleware)->group(function () {
    Route::controller(RecoveryController::class)->group(function () {
        Route::get('recovery', 'index')->name('password.request');
        Route::post('recovery', 'store')->name('password.email');
        Route::get('recovery/{token}', 'show')->name('password.reset');
        Route::put('recovery/{token}', 'update')->name('password.update');
    });
});

Route::middleware($authMiddleware)->group(function () {
    Route::controller(PasswordConfirmationController::class)->group(function () {
        Route::get('confirmation', 'show')->name('password.confirm');
        Route::post('confirmation', 'store')->middleware('throttle:6,1');
    });
});
