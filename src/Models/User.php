<?php

namespace Orvital\Authority\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Orvital\Authority\Emails\Traits\MustVerifyEmail;
use Orvital\Authority\Invites\Contracts\CanBeInvited as CanBeInvitedContract;
use Orvital\Authority\Invites\Traits\CanBeInvited;
use Orvital\Authority\Passwords\Traits\CanResetPassword;

abstract class User extends Model implements AuthenticatableContract, AuthorizableContract, MustVerifyEmailContract, CanResetPasswordContract, CanBeInvitedContract
{
    use Notifiable;
    use Authorizable;
    use HasApiTokens;
    use CanBeInvited;
    use Authenticatable;
    use MustVerifyEmail;
    use CanResetPassword;
}
