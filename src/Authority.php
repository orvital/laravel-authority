<?php

namespace Orvital\Authority;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;

class Authority
{
    /**
     * The Laravel Application.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Class constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the user for the given credentials.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser(array $credentials)
    {
        $provider = $this->getProvider();

        $user = $provider->retrieveByCredentials(Arr::only($credentials, 'email'));

        if ($user && $provider->validateCredentials($user, Arr::only($credentials, 'password'))) {
            return $user;
        }

        return null;
    }

    /**
     * Get the user provider used by the guard.
     *
     * @return \Illuminate\Contracts\Auth\UserProvider
     */
    public function getProvider()
    {
        return $this->app->make('auth')->guard()->getProvider();
    }
}
