<?php

namespace Orvital\Authority\Invite\Facades;

use Illuminate\Support\Facades\Facade;
use Orvital\Authority\Invite\Contracts\InviteBroker;

/**
 * @mixin \Orvital\Authority\Invite\InviteBroker
 */
class Invite extends Facade
{
    /**
     * Constant representing a successfully invite sent.
     */
    public const INVITE_SENT = InviteBroker::INVITE_SENT;

    /**
     * Constant representing a successfully invite accepted.
     */
    public const INVITE_ACCEPTED = InviteBroker::INVITE_ACCEPTED;

    /**
     * Constant representing the user not found response.
     */
    public const INVALID_USER = InviteBroker::INVALID_USER;

    /**
     * Constant representing an invalid token.
     */
    public const INVALID_TOKEN = InviteBroker::INVALID_TOKEN;

    /**
     * Constant representing a throttled attempt.
     */
    public const RESET_THROTTLED = InviteBroker::RESET_THROTTLED;

    /**
     * Return the registered name of the service container binding.
     * Static method calls to this class will resolve the binding from the
     * service container and run the requested method against that object.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth.invite';
    }
}
