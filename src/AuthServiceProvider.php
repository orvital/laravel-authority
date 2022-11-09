<?php

namespace Orvital\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Orvital\Auth\Passwords\PasswordBrokerManager;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        );

        $this->registerPasswordBroker();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Route::group(['middleware' => ['web', 'splade']], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');
        });

        /**
         * Define default password rules
         */
        Password::defaults(function () {
            $rule = Password::min(8)->rules(['max:192']);

            return $this->app->environment('production')
                ? $rule->mixedCase()->uncompromised()
                : $rule;
        });
    }

    /**
     * Extend Laravel's default PasswordBrokerManager
     *
     * @see \Illuminate\Auth\Passwords\PasswordResetServiceProvider
     */
    protected function registerPasswordBroker(): void
    {
        /**
         * The extend method registers a callback that is called each time the service is being resolved,
         * allowing to modify or decorate the service instance before returning it.
         * Extending instead of binding also prevents the service from beign overriden by a later binding,
         * regardless if the original service is deferred or not binded to the container yet.
         */
        $this->app->extend('auth.password', function ($service, $app) {
            return new PasswordBrokerManager($app);
        });
    }
}
