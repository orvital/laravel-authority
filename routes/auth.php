<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Auth\Http\Controllers\AuthenticateController;
use Orvital\Authority\Auth\Http\Controllers\RegisterController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';
$guestMiddleware = config('authority.guard') ? 'guest:'.config('authority.guard') : 'guest';

Route::middleware($guestMiddleware)->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });

    Route::controller(AuthenticateController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });
});

Route::middleware($authMiddleware)->group(function () {
    Route::post('logout', [AuthenticateController::class, 'destroy'])->name('logout');
});
