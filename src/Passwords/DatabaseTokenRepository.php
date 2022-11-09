<?php

namespace Orvital\Auth\Passwords;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DatabaseTokenRepository extends \Illuminate\Auth\Passwords\DatabaseTokenRepository
{
    protected function getPayload($email, $token)
    {
        return [
            'id' => strtolower((string) Str::ulid()),
            'email' => $email,
            'token' => $this->hasher->make($token),
            'created_at' => new Carbon(),
        ];
    }
}
