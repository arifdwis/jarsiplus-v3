<?php

namespace Novay\Nue\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class InstallCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'nue:install {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Nue components and resources.';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'layouts/app.stub' => 'layouts/app.blade.php',
        'layouts/blank.stub' => 'layouts/blank.blade.php',
        'layouts/partials/aside.stub' => 'layouts/partials/aside.blade.php',
        'layouts/partials/header.stub' => 'layouts/partials/header.blade.php',
        'welcome.stub' => 'welcome.blade.php',
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/passwords/confirm.stub' => 'auth/passwords/confirm.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/verify.stub' => 'auth/verify.blade.php',
        'dashboard.stub' => 'dashboard.blade.php',
        'profile/show.stub' => 'profile/show.blade.php',
        'profile/page/basic.stub' => 'profile/page/basic.blade.php',
        'profile/page/email.stub' => 'profile/page/email.blade.php',
        'profile/page/password.stub' => 'profile/page/password.blade.php',
        'profile/page/terminate.stub' => 'profile/page/terminate.blade.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        $mtime = microtime(TRUE);

        $this->ensureDirectoriesExist();
        $this->comment('<options=bold,reverse;fg=green> OK </> Ensure views directories exists.');
        
        $this->exportViews();
        $this->comment('<options=bold,reverse;fg=green> OK </> Export views.');

        $this->exportBackend();
        $this->comment('<options=bold,reverse;fg=green> OK </> Export authentication controllers.');

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'nue-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'nue-migrations', '--force' => true]);
        $this->comment('<options=bold,reverse;fg=green> OK </> Publish config & migrations files.');

        // Models...
        copy(__DIR__.'/../../stubs/Models/User.stub', app_path('Models/User.php'));
        $this->comment('<options=bold,reverse;fg=green> OK </> Replace models.');
        
        // Init Database...
        $this->initDatabase();

        $this->comment('');
        $this->info('🤙 Nue package generated successfully in '.time_execute($mtime).' seconds.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
        if (! is_dir($directory = $this->getViewPath('layouts/partials'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getViewPath('profile/page'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getViewPath('auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(__DIR__.'/../Auth/view-stubs/'.$key, $view);
        }
    }

    /**
     * Export the authentication backend.
     *
     * @return void
     */
    protected function exportBackend()
    {
        $this->callSilent('nue:auth');

        // Home Controller
        $controller = app_path('Http/Controllers/HomeController.php');
        if (file_exists($controller) && ! $this->option('force')) {
            if ($this->confirm("The [HomeController.php] file already exists. Do you want to replace it?")) {
                file_put_contents($controller, $this->compileControllerStub());
            }
        } else {
            file_put_contents($controller, $this->compileControllerStub());
        }

        // Route modifications
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/../Auth/stubs/routes.stub'),
            FILE_APPEND
        );

        // Nue Controllers
        if (! is_dir($directory = app_path('Http/Controllers/Nue'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;
        collect($filesystem->allFiles(__DIR__.'/../../stubs/Nue'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/Nue/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
    }

    /**
     * Compiles the "HomeController" stub.
     *
     * @return string
     */
    protected function compileControllerStub()
    {
        return str_replace('{{namespace}}', $this->laravel->getNamespace(),
            file_get_contents(__DIR__.'/../Auth/stubs/controllers/HomeController.stub')
        );
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {
        $this->call('migrate');

        $this->call('db:seed', ['--class' => \Novay\Nue\NueTableSeeder::class]);
    }
}
