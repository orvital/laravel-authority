<?php

namespace Orvital\Authority\Invites\Contracts;

use Closure;

interface InviteBroker
{
    /**
     * Constant representing a successfully invite sent.
     */
    public const INVITE_SENT = 'invites.sent';

    /**
     * Constant representing a successfully invite accepted.
     */
    public const INVITE_ACCEPTED = 'invites.accepted';

    /**
     * Constant representing the user not found response.
     */
    public const INVALID_USER = 'invites.user';

    /**
     * Constant representing an invalid token.
     */
    public const INVALID_TOKEN = 'invites.token';

    /**
     * Constant representing a throttled attempt.
     */
    public const RESET_THROTTLED = 'invites.throttled';

    /**
     * Send the invite.
     */
    public function send(array $credentials, Closure $callback = null): string;

    /**
     * Accept the invite.
     */
    public function accept(array $credentials, Closure $callback): mixed;
}
