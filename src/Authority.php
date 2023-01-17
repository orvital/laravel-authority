<?php

namespace Orvital\Authority;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
     * Finds a user by the given credentials.
     */
    public function findByCredentials(array $credentials): ?Authenticatable
    {
        $provider = $this->getProvider();

        $user = $provider->retrieveByCredentials(Arr::only($credentials, 'email'));

        if ($user && $provider->validateCredentials($user, Arr::only($credentials, 'password'))) {
            return $user;
        }

        return null;
    }

    /**
     * Register a user with the given credentials.
     */
    public function register(array $credentials, bool $login = true): Authenticatable
    {
        $provider = $this->getProvider();

        $credentials['password'] = $provider->getHasher()->make($credentials['password']);

        $user = $provider->createModel()->create($credentials);

        event(new Registered($user));

        if ($login) {
            Auth::login($user);
        }

        return $user;
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
