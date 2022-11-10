<?php

namespace Orvital\Auth\Invites\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Orvital\Auth\Invites\InviteBroker
 */
class Invite extends Facade
{
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
