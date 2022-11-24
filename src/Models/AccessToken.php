<?php

namespace Orvital\Authority\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Laravel\Sanctum\PersonalAccessToken;

class AccessToken extends PersonalAccessToken
{
    use HasUlids;

    protected $guarded = [];
}
