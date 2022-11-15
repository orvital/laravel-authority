<?php

namespace Orvital\Authority\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Laravel\Sanctum\PersonalAccessToken;

class AccessToken extends PersonalAccessToken
{
    use HasUlids;

    protected $guarded = [];
}
