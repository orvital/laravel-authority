<?php

namespace Orvital\Authority\Invites\Contracts;

interface CanBeInvited
{
    /**
     * Get the email address that should be used to sent the invitation.
     */
    public function getEmailForInvite(): string;

    /**
     * Send the invite notification.
     */
    public function sendInviteNotification(string $token): void;
}
