<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\AccessTokenController;
use Orvital\Authority\Http\Controllers\AccountController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.web.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.web.guard')])),
];

/**
 * Authenticated: /account
 */
Route::middleware($middleware['auth'])->group(function () {
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
