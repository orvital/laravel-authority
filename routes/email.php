<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Email\Http\Controllers\VerificationController;

$authMiddleware = config('authority.guard') ? 'auth:'.config('authority.guard') : 'auth';

Route::middleware($authMiddleware)->group(function () {
    Route::controller(VerificationController::class)->group(function () {
        Route::get('verification', 'index')->name('verification.notice');
        Route::post('verification', 'store')->name('verification.send')->middleware('throttle:6,1');
        Route::get('verification/{id}/{hash}', 'show')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    });
});
