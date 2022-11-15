<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Invites\Http\Controllers\InviteAcceptController;
use Orvital\Authority\Invites\Http\Controllers\InviteRequestController;

Route::middleware('guest')->group(function () {
    Route::controller(InviteRequestController::class)->group(function () {
        Route::get('invite-request', 'create')->name('invite.request');
        Route::post('invite-request', 'store');
    });

    Route::controller(InviteAcceptController::class)->group(function () {
        Route::get('invite-accept/{token}', 'create')->name('invite.accept');
        Route::post('invite-accept', 'store')->name('invite.update');
    });
});
