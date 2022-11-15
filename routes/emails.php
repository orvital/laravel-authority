<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Emails\Http\Controllers\EmailVerificationController;
use Orvital\Authority\Emails\Http\Controllers\VerifyEmailController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->group(function () {
    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('verification', 'create')->name('verification.notice');
        Route::post('verification', 'store')->middleware('throttle:6,1');
    });

    Route::get('verification/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});
