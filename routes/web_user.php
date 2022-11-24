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
use Orvital\Authority\Http\Controllers\AccessTokenController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.web.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.web.guard')])),
];

/**
 * Authenticated: /account
 */
Route::middleware($middleware['auth'])->group(function () {
    Route::get('', [UserController::class, 'show'])->name('user');

    Route::put('profile', [ProfileController::class, 'update'])->name('user.profile');
    Route::put('password', [PasswordController::class, 'update'])->name('user.password');

    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('tokens', 'index')->name('user.tokens.index');
        Route::post('tokens', 'store')->name('user.tokens.store');
        Route::delete('tokens/{id}', 'destroy')->name('user.tokens.destroy');
    });
});
