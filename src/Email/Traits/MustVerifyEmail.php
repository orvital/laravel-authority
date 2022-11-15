<?php

namespace Orvital\Authority\Email\Traits;

use Orvital\Authority\Email\Notifications\VerifyEmail as VerifyEmailNotification;

trait MustVerifyEmail
{
    /**
     * The name of the "verified_at" column.
     */
    const string VERIFIED_AT = 'verified_at';

    public function getVerifiedAtColumn()
    {
        return static::VERIFIED_AT;
    }

    /**
     * Initializer called on each new model instance.
     */
    public function initializeMustVerifyEmail(): void
    {
        if (! $this->hasCast($this->getVerifiedAtColumn())) {
            $this->mergeCasts([$this->getVerifiedAtColumn() => 'datetime']);
        }
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->{$this->getVerifiedAtColumn()});
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            $this->getVerifiedAtColumn() => $this->freshTimestamp(),
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
