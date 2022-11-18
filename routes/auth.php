<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Auth\Http\Controllers\AuthenticateController;
use Orvital\Authority\Auth\Http\Controllers\RegisterController;
use Orvital\Authority\Password\Http\Controllers\RecoveryController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';
$guestMiddleware = config('authority.guard') ? 'guest:'.config('authority.guard') : 'guest';

Route::middleware($guestMiddleware)->prefix('auth')->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('signup', 'create')->name('register');
        Route::post('signup', 'store');
    });

    Route::controller(AuthenticateController::class)->group(function () {
        Route::get('access', 'create')->name('login');
        Route::post('access', 'store');
    });

    Route::controller(RecoveryController::class)->group(function () {
        Route::get('forgot', 'index')->name('password.request');
        Route::post('forgot', 'store')->name('password.email');
        Route::get('forgot/{token}', 'show')->name('password.reset');
        Route::put('forgot/{token}', 'update')->name('password.update');
    });
});

Route::middleware($authMiddleware)->prefix('auth')->group(function () {
    Route::delete('access', [AuthenticateController::class, 'destroy'])->name('logout');
});

// Route::controller(AuthenticateController::class)->prefix('auth')->group(function () {
//     Route::get('access', 'create')->middleware($guestMiddleware)->name('login');
//     Route::post('access', 'store')->middleware($guestMiddleware);
//     Route::delete('access', 'destroy')->middleware($authMiddleware)->name('logout');
// });
