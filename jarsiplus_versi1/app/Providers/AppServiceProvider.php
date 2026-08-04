<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\Histori;
use Modules\Core\Entities\Penjadwalan;
use Modules\Formulir\Entities\DataDukung as DFile;
use Modules\Formulir\Entities\Parameter;
use Modules\Formulir\Entities\Indikator;
use Modules\Formulir\Entities\Penilaian;
use App\Observers\HistoriObserver;
use App\Observers\FileObserver;
use App\Observers\PenjadwalanObserver;
use App\Observers\PenilaianObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Permohonan::observe(HistoriObserver::class);
       DFile::observe(FileObserver::class);
       Penjadwalan::observe(PenjadwalanObserver::class);
       Permohonan::observe(PenilaianObserver::class);

   }

}
