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
use Orvital\Auth\Traits\CanResetPassword;
use Orvital\Auth\Traits\MustVerifyEmail;

abstract class User extends Model implements AuthenticatableContract, AuthorizableContract, MustVerifyEmailContract, CanResetPasswordContract
{
    use Notifiable;
    use Authorizable;
    use HasApiTokens;
    use Authenticatable;
    use MustVerifyEmail;
    use CanResetPassword;
}
