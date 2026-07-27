<?php

namespace Nue\Lock\Providers;

use Illuminate\Support\ServiceProvider;
use Novay\Nue\Nue;
use Nue\Lock\Lock;
use Nue\Lock\Http\Middleware\LockMiddleware;

class LockServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Lock $extension)
    {
        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'nue-lockscreen');
        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../../routes/web.php');
        });

        app('router')->aliasMiddleware('nue.lock', LockMiddleware::class);

        $extension->boot();
    }
}