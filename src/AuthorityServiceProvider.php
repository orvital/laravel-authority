<?php

namespace Orvital\Authority;

use Illuminate\Support\Facades\Auth;
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
        $this->mergeConfigFrom(
            __DIR__.'/../config/authority.php', 'authority'
        );

        $this->setConfigurationValues();

        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath(),
            __DIR__.'/../config/authority.php' => $this->app->configPath('authority.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'auth');

        Route::group([
            'middleware' => config('authority.middleware'),
            // 'prefix' => config('authority.prefix'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');
            $this->loadRoutesFrom(__DIR__.'/../routes/invite.php');
            $this->loadRoutesFrom(__DIR__.'/../routes/user.php');
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

    /**
     * Set configuration values at runtime.
     */
    protected function setConfigurationValues(): void
    {
        config(['auth.defaults.invites' => 'users']);

        config([
            'auth.providers.guests' => [
                'driver' => 'instance',
                'model' => config('auth.providers.users.model'),
            ],
        ]);

        config([
            'auth.invites.users' => array_merge([
                'provider' => 'guests',
                'table' => 'invite_tokens',
                'expire' => 60,
                'throttle' => 60,
            ], config('auth.invites.users', [])),
        ]);

        config(['sanctum.routes' => false]);
    }
}
