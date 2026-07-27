<?php

namespace Novay\Nue\Commands;

use Illuminate\Console\Command;

class UninstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'nue:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the Nue package.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->confirm('Are you sure to uninstall Nue?')) {
            return;
        }

        $this->removeFilesAndDirectories();

        $this->comment('Remove Nue directory "app/Nue/*" ...');
        $this->comment('Remove Nue views "resources/views/*" ...');
        $this->comment('Remove Nue config file "config/nue.php" ...');

        $this->line('<info>Uninstalling Nue done!</info>');
    }

    /**
     * Remove files and directories.
     *
     * @return void
     */
    protected function removeFilesAndDirectories()
    {
        $this->laravel['files']->deleteDirectory(app_path('Nue'));
        $this->laravel['files']->deleteDirectory(app_path('Http/Controllers/Auth'));
        $this->laravel['files']->deleteDirectory(app_path('Http/Controllers/Nue'));
        $this->laravel['files']->deleteDirectory(base_path('resources/views/auth'));
        $this->laravel['files']->deleteDirectory(base_path('resources/views/nue'));
        $this->laravel['files']->deleteDirectory(base_path('resources/views/layouts'));
        $this->laravel['files']->deleteDirectory(base_path('resources/views/profile'));
        
        $this->laravel['files']->delete(config_path('nue.php'));
        $this->laravel['files']->delete(app_path('Http/Controllers/HomeController.php'));
        $this->laravel['files']->delete(database_path('migrations/2021_01_01_000000_create_nue_tables.php'));
        $this->laravel['files']->delete(base_path('resources/views/dashboard.blade.php'));
        $this->laravel['files']->delete(base_path('resources/views/welcome.blade.php'));
    }
}