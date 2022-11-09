<?php

namespace Orvital\Auth\Models;

use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class AccessToken extends PersonalAccessToken
{
    use HasUlids;

    protected $guarded = [];
}
