<?php

namespace Orvital\Authority\Invites;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InviteServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInviteBroker();
    }

    /**
     * Register the invite broker instance.
     *
     * @return void
     */
    protected function registerInviteBroker()
    {
        $this->app->singleton('auth.invite', function ($app) {
            return new InviteBrokerManager($app);
        });

        $this->app->bind('auth.invite.broker', function ($app) {
            return $app->make('auth.invite')->broker();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.invite', 'auth.invite.broker'];
    }
}
