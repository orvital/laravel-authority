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

        config(['sanctum.routes' => false]);

        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'auth');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/auth'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Auth::provider('instance', function ($app, array $config) {
            return new InstanceUserProvider($config['model']);
        });

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

        Sanctum::usePersonalAccessTokenModel(AccessToken::class);
    }
}
