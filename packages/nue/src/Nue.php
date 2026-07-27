<?php

namespace Novay\Nue;

use Illuminate\Support\Facades\Auth;
use Novay\Nue\Traits\HasMenu;
use Novay\Nue\Traits\HasAssets;

class Nue
{
    use HasMenu, HasAssets;

    /**
     * The Nue version.
     *
     * @var string
     */
    const VERSION = '2.00';

    /**
     * @var array
     */
    public static $extensions = [];

    /**
     * Returns the long version of Nue.
     *
     * @return string The long application version
     */
    public static function getLongVersion()
    {
        return sprintf('Nue <comment>version</comment> <info>%s</info>', self::VERSION);
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->guard()->user();
    }

    /**
     * Attempt to get the guard from the local cache.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        $guard = config('nue.guard') ?: 'web';

        return Auth::guard($guard);
    }

    /**
     * Extend a extension.
     *
     * @param string $name
     * @param string $class
     *
     * @return void
     */
    public static function extend($name, $class)
    {
        static::$extensions[$name] = $class;
    }

    /**
     * Register the laravel-admin builtin routes.
     *
     * @return void
     *
     * @deprecated Use Admin::routes() instead();
     */
    public function registerAuthRoutes()
    {
        $this->routes();
    }

    /**
     * Register the laravel-admin builtin routes.
     *
     * @return void
     */
    public function routes()
    {
        // 
    }
}