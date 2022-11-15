<?php

namespace Orvital\Authority\Invite\Traits;

use Orvital\Authority\Invite\Notifications\InviteUser as InviteUserNotification;

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
