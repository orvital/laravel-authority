<?php

use Illuminate\Support\Facades\Route;
use Orvital\Auth\Emails\Http\Controllers\EmailVerificationController;
use Orvital\Auth\Emails\Http\Controllers\VerifyEmailController;

Route::middleware('auth')->group(function () {
    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('verification', 'create')->name('verification.notice');
        Route::post('verification', 'store')->middleware('throttle:6,1');
    });

    Route::get('verification/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});
