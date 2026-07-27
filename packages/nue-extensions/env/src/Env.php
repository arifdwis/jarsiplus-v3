<?php

namespace Nue\Env;

use Novay\Nue\Extension;
use Novay\Nue\Nue;

class Env extends Extension
{
    public $name = 'env';

    public $views = __DIR__.'/../resources/views';

    public static function boot()
    {
        Nue::extend('env', __CLASS__);
    }

    public static function import()
    {
        parent::createMenu('Env Manager', 'nue/env', 'code');

        parent::createPermission('Env Manager', 'ext.env', 'env*');
    }
}
