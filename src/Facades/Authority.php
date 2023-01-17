<?php

namespace Orvital\Authority\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Orvital\Authority\Authority
 */
class Authority extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authority';
    }
}
