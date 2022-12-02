<?php

namespace Orvital\Authority\Contracts;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

interface Authenticable extends AuthenticatableContract, CanResetPasswordContract, MustVerifyEmailContract
{
}
