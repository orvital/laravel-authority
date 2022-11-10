<?php

use Illuminate\Support\Facades\Route;
use Orvital\Auth\Http\Controllers\AuthenticateController;
use Orvital\Auth\Http\Controllers\EmailVerificationController;
use Orvital\Auth\Http\Controllers\PasswordConfirmationController;
use Orvital\Auth\Http\Controllers\PasswordRecoveryController;
use Orvital\Auth\Http\Controllers\PasswordResetController;
use Orvital\Auth\Http\Controllers\RegisterController;
use Orvital\Auth\Http\Controllers\VerifyEmailController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('login', [AuthenticateController::class, 'store']);

    Route::get('recovery', [PasswordRecoveryController::class, 'create'])->name('password.request');
    Route::post('recovery', [PasswordRecoveryController::class, 'store'])->name('password.email');

    Route::get('reset/{token}', [PasswordResetController::class, 'create'])->name('password.reset');
    Route::post('reset', [PasswordResetController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verification', [EmailVerificationController::class, 'create'])->name('verification.notice');
    Route::post('verification', [EmailVerificationController::class, 'store'])->middleware('throttle:6,1');

    Route::get('verification/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::get('confirmation', [PasswordConfirmationController::class, 'show'])->name('password.confirm');
    Route::post('confirmation', [PasswordConfirmationController::class, 'store'])->middleware('throttle:6,1');

    Route::post('logout', [AuthenticateController::class, 'destroy'])->name('logout');
});
