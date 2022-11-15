<?php

namespace Orvital\Authority\Invites\Traits;

use Orvital\Authority\Invites\Notifications\InviteUser as InviteUserNotification;

trait CanBeInvited
{
    public function getEmailForInvite(): string
    {
        return $this->email;
    }

    public function sendInviteNotification(string $token): void
    {
        $this->notify(new InviteUserNotification($token));
    }
}
