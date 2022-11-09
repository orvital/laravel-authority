<?php

namespace Orvital\Auth\Traits;

use Orvital\Auth\Notifications\VerifyEmail as VerifyEmailNotification;

trait MustVerifyEmail
{
    /**
     * Initializer called on each new model instance.
     */
    public function initializeMustVerifyEmail(): void
    {
        if (! $this->hasCast('verified_at')) {
            $this->mergeCasts(['verified_at' => 'datetime']);
        }
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }
}
