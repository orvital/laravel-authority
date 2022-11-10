<?php

namespace Orvital\Auth\Invites\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invite extends Model
{
    use HasUlids;
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'token',
    ];

    protected $casts = [
        // 'expires_at' => 'datetime',
    ];
}
