<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\ConfirmationController;
use Orvital\Authority\Http\Controllers\CsrfCookieController;
use Orvital\Authority\Http\Controllers\LoginController;
use Orvital\Authority\Http\Controllers\LogoutController;
use Orvital\Authority\Http\Controllers\PasswordController;
use Orvital\Authority\Http\Controllers\ProfileController;
use Orvital\Authority\Http\Controllers\RecoveryController;
use Orvital\Authority\Http\Controllers\RegisterController;
use Orvital\Authority\Http\Controllers\UserController;
use Orvital\Authority\Http\Controllers\VerificationController;


$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.web.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.web.guard')])),
];

/**
 * Guests
 */
Route::middleware($middleware['guest'])->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('signup', 'create')->name('register');
        Route::post('signup', 'store');
    });

    Route::get('cookie', [CsrfCookieController::class, 'show'])->name('csrf');

    Route::controller(LoginController::class)->group(function () {
        Route::get('access', 'create')->name('login');
        Route::post('access', 'store');
    });

    Route::controller(RecoveryController::class)->group(function () {
        Route::get('recovery', 'index')->name('recovery');
        Route::post('recovery', 'store');
        Route::get('recovery/{token}', 'show')->name('recovery.reset');
        Route::put('recovery/{token}', 'update');
    });
});

/**
 * Authenticated
 */
Route::middleware($middleware['auth'])->group(function () {
    Route::post('logout', [LogoutController::class, 'store'])->name('logout');

    Route::controller(VerificationController::class)->group(function () {
        Route::get('verify', 'index')->name('verification');
        Route::post('verify', 'store')->middleware('throttle:6,1');
        Route::get('verify/{id}/{hash}', 'show')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    });

    Route::controller(ConfirmationController::class)->group(function () {
        Route::get('unlock', 'show')->name('confirmation');
        Route::post('unlock', 'store')->middleware('throttle:6,1');
    });
});

/**
 * Authenticated: /account
 */
Route::middleware($middleware['auth'])->prefix('user')->group(function () {
    Route::get('', [UserController::class, 'show'])->name('user');

    Route::put('profile', [ProfileController::class, 'update'])->name('user.profile');
    Route::put('password', [PasswordController::class, 'update'])->name('user.password');
});
