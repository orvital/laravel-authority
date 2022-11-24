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
use Orvital\Authority\Traits\MustVerifyEmail;
use Orvital\Authority\Traits\CanResetPassword;

abstract class User extends Model implements AuthenticatableContract, AuthorizableContract, MustVerifyEmailContract, CanResetPasswordContract
{
    use Notifiable;
    use Authorizable;
    use HasApiTokens;
    use Authenticatable;
    use MustVerifyEmail;
    use CanResetPassword;
}
