<?php

namespace Nue\Env\Providers;

use Illuminate\Support\ServiceProvider;
use Nue\Env\Env;

class EnvServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Env $extension)
    {
        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'nue-env');
        }

        $this->app->booted(function () {
            Env::routes(__DIR__.'/../../routes/web.php');
        });

        Env::boot();
    }
}