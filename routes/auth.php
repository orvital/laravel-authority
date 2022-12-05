<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\AuthenticationController;
use Orvital\Authority\Http\Controllers\ConfirmationController;
use Orvital\Authority\Http\Controllers\CsrfCookieController;
use Orvital\Authority\Http\Controllers\RecoveryController;
use Orvital\Authority\Http\Controllers\RegisterController;
use Orvital\Authority\Http\Controllers\VerificationController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.auth.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.auth.guard')])),
];

Route::get('cookie', [CsrfCookieController::class, 'show'])->name('csrf');

/**
 * Authentication
 */
Route::controller(AuthenticationController::class)->group(function () use ($middleware) {
    Route::get('access', 'create')->middleware($middleware['guest'])->name('login');
    Route::post('access', 'store')->middleware($middleware['guest']);
    Route::delete('access', 'destroy')->middleware($middleware['auth']);
});

/**
 * Guests
 */
Route::middleware($middleware['guest'])->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('signup', 'create')->name('register');
        Route::post('signup', 'store');
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
