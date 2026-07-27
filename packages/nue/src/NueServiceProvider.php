<?php

namespace Novay\Nue;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class NueServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        Commands\NueCommand::class,
        Commands\InstallCommand::class,
        Commands\UninstallCommand::class,
        Commands\AuthCommand::class,
        Commands\ExtendCommand::class,
        Commands\ImportCommand::class,
        Commands\CreateUserCommand::class,
        Commands\ResetPasswordCommand::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'nue.activity'      => Http\Middleware\Activity::class,
        'nue.permission'    => Http\Middleware\Permission::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'nue' => [
            'nue.activity',
            'nue.permission',
        ],
    ];
    
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->ensureHttps();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nue');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        
        $this->registerConfig();
        $this->configurePublishing();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $this->app->singleton('notify', function ($app) {
            return $this->app->make('Novay\Nue\Services\Notifier');
        });
        
        $this->registerRouteMiddleware();
    }

    /**
     * Force to set https scheme if https enabled.
     *
     * @return void
     */
    protected function ensureHttps()
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $is_admin = Str::startsWith(request()->getRequestUri(), '/'.ltrim(config('nue.route.prefix'), '/'));
        if ((config('nue.https') || config('nue.secure')) && $is_admin) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nue.php', 'nue');

        $this->publishes([__DIR__.'/../config' => config_path()], 'nue-config');
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../database/migrations/2014_10_12_000000_create_users_table.php' => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            __DIR__.'/../database/migrations/2021_01_01_000000_create_nue_tables.php' => database_path('migrations/2021_01_01_000000_create_nue_tables.php'),
        ], 'nue-migrations');
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
