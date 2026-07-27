<?php

namespace Nue\Lock;

use Novay\Nue\Extension;
use Novay\Nue\Nue;

class Lock extends Extension
{
    const LOCK_KEY = 'nue-lock';

    public $views = __DIR__.'/../resources/views';

    public static function boot()
    {
        Nue::extend('lock', __CLASS__);
    }

    public static function import()
    {
        parent::createMenu('Lock-Screen', 'lock', 'shield-lock');

        parent::createPermission('Lock-Screen', 'ext.lock', 'lock*');
    }
}
