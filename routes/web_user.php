<?php

use Illuminate\Support\Facades\Route;

use Orvital\Authority\Http\Controllers\UserController;
use Orvital\Authority\Http\Controllers\AccessTokenController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.api.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.api.guard')])),
];

/**
 * Authenticated: /account
 */
Route::middleware($middleware['auth'])->prefix('user')->group(function () {
    Route::get('', [UserController::class, 'show'])->name('user');

    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('tokens', 'index')->name('user.tokens');
        Route::post('tokens', 'store')->name('user.tokens.store');
        Route::delete('tokens/{id}', 'destroy')->name('user.tokens.destroy');
    });
});
