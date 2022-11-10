<?php

namespace Orvital\Auth\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Orvital\Auth\Emails\Traits\MustVerifyEmail;
use Orvital\Auth\Invites\Contracts\CanBeInvited as CanBeInvitedContract;
use Orvital\Auth\Invites\Traits\CanBeInvited;
use Orvital\Auth\Passwords\Traits\CanResetPassword;

abstract class User extends Model implements AuthenticatableContract, AuthorizableContract, MustVerifyEmailContract, CanResetPasswordContract, CanBeInvitedContract
{
    use Notifiable;
    use Authorizable;
    use CanBeInvited;
    use Authenticatable;
    use MustVerifyEmail;
    use CanResetPassword;
}
