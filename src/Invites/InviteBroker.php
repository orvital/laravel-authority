<?php

namespace Orvital\Auth\Invites;

use Closure;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use Illuminate\Support\Arr;
use Orvital\Auth\Invites\Contracts\CanBeInvited as CanBeInvitedContract;
use Orvital\Auth\Invites\Contracts\InviteBroker as InviteBrokerContract;
use Orvital\Auth\Invites\Contracts\TokenRepository as TokenRepositoryContract;
use UnexpectedValueException;

/**
 * A broker component is responsible for coordinating communication such as forwarding requests,
 * as well as for transmitting results and exceptions.
 */
class InviteBroker implements InviteBrokerContract
{
    /**
     * The invite token repository.
     */
    protected TokenRepositoryContract $tokens;

    /**
     * The user provider implementation.
     */
    protected UserProviderContract $users;

    /**
     * Create a new invite broker instance.
     *
     * @return void
     */
    public function __construct(TokenRepositoryContract $tokens, UserProviderContract $users)
    {
        $this->tokens = $tokens;
        $this->users = $users;
    }

    /**
     * Send the invite.
     */
    public function send(array $credentials, Closure $callback = null): string
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        // return $this->users->createModel()->make($credentials);

        if (! $user) {
            return static::INVALID_USER;
        }

        if ($this->tokens->recentlyCreatedToken($user)) {
            return static::RESET_THROTTLED;
        }

        $token = $this->tokens->create($user);

        if ($callback) {
            $callback($user, $token);
        } else {
            $user->sendInviteNotification($token);
        }

        return static::INVITE_SENT;
    }

    /**
     * Accept the invite.
     */
    public function accept(array $credentials, Closure $callback): mixed
    {
        $user = $this->getUser($credentials);

        if (! $user) {
            return static::INVALID_USER;
        }

        if (! $this->tokens->exists($user, $credentials['token'])) {
            return static::INVALID_TOKEN;
        }

        $password = $credentials['password'];

        // Once the invite has been validated, we'll call the given callback with the
        // new password. This gives the user an opportunity to store the password
        // in their persistent storage. Then we'll delete the token and return.
        $callback($user, $password);

        $this->tokens->delete($user);

        return static::INVITE_ACCEPTED;
    }

    /**
     * Get the user for the given credentials.
     *
     * @throws \UnexpectedValueException
     */
    public function getUser(array $credentials): ?CanBeInvitedContract
    {
        $user = $this->users->retrieveByCredentials(Arr::except($credentials, ['token']));

        if ($user && ! $user instanceof CanBeInvitedContract) {
            throw new UnexpectedValueException('User must implement CanBeInvited interface.');
        }

        return $user;
    }

    /**
     * Create a new invite token for the given user.
     */
    public function createToken(CanBeInvitedContract $user): string
    {
        return $this->tokens->create($user);
    }

    /**
     * Delete invite tokens of the given user.
     */
    public function deleteToken(CanBeInvitedContract $user): void
    {
        $this->tokens->delete($user);
    }

    /**
     * Validate the given invite token.
     */
    public function tokenExists(CanBeInvitedContract $user, string $token): bool
    {
        return $this->tokens->exists($user, $token);
    }

    /**
     * Get the invite token repository implementation.
     */
    public function getRepository(): TokenRepositoryContract
    {
        return $this->tokens;
    }
}
