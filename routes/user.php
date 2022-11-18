<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Email\Http\Controllers\VerificationController;
use Orvital\Authority\Password\Http\Controllers\ConfirmationController;
use Orvital\Authority\User\Http\Controllers\AccessTokenController;
use Orvital\Authority\User\Http\Controllers\UserProfileController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->prefix('user')->group(function () {
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

Route::middleware($authMiddleware)->prefix('account')->group(function () {
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('', 'show')->name('profile.show');
        Route::put('', 'update')->name('profile.update');
        Route::post('', 'store')->name('profile.store');
    });

    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('tokens', 'index')->name('token.index');
        Route::post('tokens', 'store')->name('token.store');
        Route::delete('tokens/{token}', 'destroy')->name('token.destroy');
    });
});
