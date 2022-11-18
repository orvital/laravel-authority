<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Invite\Http\Controllers\InviteAcceptController;
use Orvital\Authority\Invite\Http\Controllers\InviteRequestController;

$guestMiddleware = config('authority.guard') ? 'guest:'.config('authority.guard') : 'guest';

Route::middleware($guestMiddleware)->group(function () {
    Route::controller(InviteRequestController::class)->group(function () {
        Route::get('invite-request', 'create')->name('invite.request');
        Route::post('invite-request', 'store');
    });

    Route::controller(InviteAcceptController::class)->group(function () {
        Route::get('invite-accept/{token}', 'create')->name('invite.accept');
        Route::post('invite-accept', 'store')->name('invite.update');
    });
});
