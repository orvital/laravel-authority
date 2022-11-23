<?php

namespace Orvital\Authority;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\Sanctum;
use Orvital\Authority\User\Models\AccessToken;

class AuthorityServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/authority.php', 'authority');

        config(['sanctum.routes' => false]);

        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/authority.php' => $this->app->configPath('authority.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Route::middleware(config('authority.api.middleware'))
            ->prefix(config('authority.api.prefix'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
            });

        Route::middleware(config('authority.web.middleware'))
            ->prefix(config('authority.web.prefix'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });

        Route::middleware(config('authority.web.middleware'))
            ->prefix('user')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/user.php');
            });

        Sanctum::usePersonalAccessTokenModel(AccessToken::class);

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
