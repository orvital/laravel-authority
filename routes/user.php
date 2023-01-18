<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\AccessTokenController;
use Orvital\Authority\Http\Controllers\EmailController;
use Orvital\Authority\Http\Controllers\PasswordController;
use Orvital\Authority\Http\Controllers\ProfileController;
use Orvital\Authority\Http\Controllers\UserController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.user.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.user.guard')])),
];

/**
 * Authenticated: /account
 */
Route::middleware($middleware['auth'])->group(function () {
    Route::get('', [UserController::class, 'show'])->name('user');
    Route::put('profile', [ProfileController::class, 'update'])->name('user.profile');
    Route::put('email', [EmailController::class, 'update'])->name('user.email');
    Route::put('password', [PasswordController::class, 'update'])->name('user.password');

    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('tokens', 'index')->name('user.tokens');
        Route::post('tokens', 'store')->name('user.tokens.store');
        Route::delete('tokens/{id}', 'destroy')->name('user.tokens.destroy');
    });
});
