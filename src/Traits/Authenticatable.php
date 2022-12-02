<?php

namespace Orvital\Authority\Traits;

use Illuminate\Support\Facades\Hash;

trait Authenticatable
{
    /**
     * Initializer called on each new model instance.
     */
    public function initializeAuthenticatable()
    {
        $this->makeHidden(['password', 'remember_token']);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the unique broadcast identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifierForBroadcasting()
    {
        return $this->getAuthIdentifier();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Set the password for the user.
     *
     * @return void
     */
    public function setAuthPassword($password)
    {
        $this->password = $this->getRehashedPassword($password);
    }

    /**
     * Rehash password if needed.
     *
     * @return string
     */
    public function getRehashedPassword($password)
    {
        return Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return (string) $this->{$this->getRememberTokenName()};
        }
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
