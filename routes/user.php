<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Email\Http\Controllers\VerificationController;
use Orvital\Authority\Password\Http\Controllers\PasswordConfirmationController;
use Orvital\Authority\User\Http\Controllers\AccessTokenController;
use Orvital\Authority\User\Http\Controllers\UserProfileController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->prefix('user')->group(function () {
    Route::controller(VerificationController::class)->group(function () {
        Route::get('verification', 'index')->name('verification.notice');
        Route::post('verification', 'store')->name('verification.send')->middleware('throttle:6,1');
        Route::get('verification/{id}/{hash}', 'show')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    });

    Route::controller(PasswordConfirmationController::class)->group(function () {
        Route::get('confirmation', 'show')->name('password.confirm');
        Route::post('confirmation', 'store')->middleware('throttle:6,1');
    });

    Route::controller(UserProfileController::class)->group(function () {
        Route::get('profile', 'show')->name('profile.show');
        Route::put('profile', 'update')->name('profile.update');
        Route::post('profile', 'store')->name('profile.store');
    });

    Route::controller(AccessTokenController::class)->group(function () {
        Route::get('token', 'index')->name('token.index');
        Route::post('token', 'store')->name('token.store');
        Route::delete('token/{token}', 'destroy')->name('token.destroy');
    });
});
