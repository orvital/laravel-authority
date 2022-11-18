<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Auth\Http\Controllers\AuthenticateController;
use Orvital\Authority\Auth\Http\Controllers\RegisterController;
use Orvital\Authority\Password\Http\Controllers\RecoveryController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';
$guestMiddleware = config('authority.guard') ? 'guest:'.config('authority.guard') : 'guest';

Route::middleware($guestMiddleware)->prefix('auth')->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });

    Route::controller(AuthenticateController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });

    Route::controller(RecoveryController::class)->group(function () {
        Route::get('recovery', 'index')->name('password.request');
        Route::post('recovery', 'store')->name('password.email');
        Route::get('recovery/{token}', 'show')->name('password.reset');
        Route::put('recovery/{token}', 'update')->name('password.update');
    });
});

Route::middleware($authMiddleware)->prefix('auth')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'destroy'])->name('logout');
});
