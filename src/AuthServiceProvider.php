<?php

namespace Orvital\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\Sanctum;
use Orvital\Auth\Models\AccessToken;

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

        $this->mergeConfigFrom(
            __DIR__.'/../config/authority.php', 'authority'
        );

        config(['sanctum.routes' => false]);

        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/auth'),
            __DIR__.'/../config/authority.php' => config_path('authority.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'auth');

        Route::group([
            'middleware' => config('authority.middleware'),
            'prefix' => 'auth',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');
            $this->loadRoutesFrom(__DIR__.'/../routes/emails.php');
            $this->loadRoutesFrom(__DIR__.'/../routes/invites.php');
            $this->loadRoutesFrom(__DIR__.'/../routes/passwords.php');
        });

        Sanctum::usePersonalAccessTokenModel(AccessToken::class);

        Auth::provider('instance', function ($app, array $config) {
            return new InstanceUserProvider($config['model']);
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
}
