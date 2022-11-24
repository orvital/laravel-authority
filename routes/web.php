<?php

use Illuminate\Support\Facades\Route;
use Orvital\Authority\Http\Controllers\AuthenticateController;
use Orvital\Authority\Http\Controllers\ConfirmationController;
use Orvital\Authority\Http\Controllers\CsrfCookieController;
use Orvital\Authority\Http\Controllers\RecoveryController;
use Orvital\Authority\Http\Controllers\RegisterController;
use Orvital\Authority\Http\Controllers\VerificationController;

$middleware = [
    'auth' => implode(':', array_filter(['auth', config('authority.web.guard')])),
    'guest' => implode(':', array_filter(['guest', config('authority.web.guard')])),
];

/**
 * API Authentication
 *
 * To authenticate API requests to your application API, you need to generate an `Access Token`.
 * Make a request to the `Access Token` endpoint to generate a new token.
 * The token should be included in the `Authorization` header as a `Bearer` token when making API requests.
 *
 * SPA Authentication
 *
 * To authenticate SPA requests to your application API, you need to generate an `CSRF Cookie`.
 * The default session authentication is used to provide CSRF protection and XSS credentials leakage protection.
 * Make a request to the `Csrf Cookie` endpoint to initialize CSRF protection.
 * During this request, Laravel will set an XSRF-TOKEN cookie containing the current CSRF token.
 * This token should then be passed in an X-XSRF-TOKEN header on subsequent requests,
 * Some HTTP client libraries will do automatically for you, or you will need to manually set the X-XSRF-TOKEN header.
 *
 * Once CSRF protection has been initialized, you should make a POST request to your application's login route.
 * If the login request is successful, you will be authenticated and subsequent requests to your application's routes
 * will automatically be authenticated via the session cookie that the application issued to your client.
 *
 * You must use the session authentication guard, and send the `Accept`: `application/json` header with the requests.
 */

/**
 * Guests
 */
Route::middleware($middleware['guest'])->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('signup', 'create')->name('register');
        Route::post('signup', 'store');
    });

    Route::get('cookie', [CsrfCookieController::class, 'show'])->name('csrf');

    Route::controller(AuthenticateController::class)->group(function () {
        Route::get('access', 'create')->name('login');
        Route::post('access', 'store');
    });

    Route::controller(RecoveryController::class)->group(function () {
        Route::get('forgot', 'index')->name('password.request');
        Route::post('forgot', 'store')->name('password.email');
        Route::get('forgot/{token}', 'show')->name('password.reset');
        Route::put('forgot/{token}', 'update')->name('password.update');
    });
});

/**
 * Authenticated
 */
Route::middleware($middleware['auth'])->group(function () {
    Route::delete('access', [AuthenticateController::class, 'destroy'])->name('logout');

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
