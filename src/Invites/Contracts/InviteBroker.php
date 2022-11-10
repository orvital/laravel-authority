<?php

namespace Orvital\Auth\Invites\Contracts;

use Closure;

interface InviteBroker
{
    /**
     * Constant representing a successfully invite sent.
     */
    public const INVITE_SENT = 'invite.sent';

    /**
     * Constant representing a successfully invite accepted.
     */
    public const INVITE_ACCEPTED = 'invite.accepted';

    /**
     * Constant representing the user not found response.
     */
    public const INVALID_USER = 'invite.user';

    /**
     * Constant representing an invalid token.
     */
    public const INVALID_TOKEN = 'invite.token';

    /**
     * Constant representing a throttled attempt.
     */
    public const RESET_THROTTLED = 'invite.throttled';

    /**
     * Send the invite.
     */
    public function send(array $credentials, Closure $callback = null): string;

    /**
     * Accept the invite.
     */
    public function accept(array $credentials, Closure $callback): mixed;
}
