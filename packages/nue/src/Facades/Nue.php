<?php

namespace Novay\Nue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Nue.
 *
 * @method static \Illuminate\Contracts\Auth\Authenticatable|null user()
 * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard guard()
 *
 * @see \Novay\Nue\Nue
 */
class Nue extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Novay\Nue\Nue::class;
    }
}