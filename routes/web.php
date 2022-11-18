<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Auth\Http\Controllers\AuthenticateController;
use Orvital\Authority\Auth\Http\Controllers\RegisterController;
use Orvital\Authority\Email\Http\Controllers\VerificationController;
use Orvital\Authority\Password\Http\Controllers\ConfirmationController;
use Orvital\Authority\Password\Http\Controllers\RecoveryController;
use Orvital\Authority\User\Http\Controllers\AccessTokenController;
use Orvital\Authority\User\Http\Controllers\AccountController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.web.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.web.guard')])),
];

/**
 * Guest: /auth
 */
Route::middleware($middleware['guest'])->prefix('auth')->group(function () {
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

Route::middleware($middleware['auth'])->prefix('auth')->group(function () {
    Route::delete('access', [AuthenticateController::class, 'destroy'])->name('logout');
});

/**
 * Authenticated: /user
 */
Route::middleware($middleware['auth'])->prefix('user')->group(function () {
    Route::controller(VerificationController::class)->group(function () {
        Route::get('verify', 'index')->name('verification.notice');
        Route::post('verify', 'store')->name('verification.send')->middleware('throttle:6,1');
        Route::get('verify/{id}/{hash}', 'show')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    });

    Route::controller(ConfirmationController::class)->group(function () {
        Route::get('unlock', 'show')->name('password.confirm');
        Route::post('unlock', 'store')->middleware('throttle:6,1');
    });
});

/**
 * Authenticated: /account
 */
Route::middleware($middleware['auth'])->prefix('account')->group(function () {
    Route::controller(AccountController::class)->group(function () {
        Route::get('', 'show')->name('account.show');
        Route::put('', 'update')->name('account.update');
        Route::post('', 'store')->name('account.store');
    });

    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('tokens', 'index')->name('token.index');
        Route::post('tokens', 'store')->name('token.store');
        Route::delete('tokens/{token}', 'destroy')->name('token.destroy');
    });
});
