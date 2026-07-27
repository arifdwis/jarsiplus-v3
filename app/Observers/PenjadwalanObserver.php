<?php

namespace App\Observers;

use Modules\Core\Entities\Penjadwalan;
use Modules\Core\Entities\Histori;

class PenjadwalanObserver
{
    /**
     * Handle the Penjadwalan "created" event.
     *
     * @param  \App\Models\Penjadwalan  $penjadwalan
     * @return void
     */
    public function created(Penjadwalan $data)
    {
        $input['id_permohonan'] = $data->id;
        $input['id_operator']   = optional(auth()->user())->id;
        $input['deskripsi']     = 'Approvement telah ditambahkan';

        Histori::create($input);
    }

    /**
     * Handle the Penjadwalan "updated" event.
     *
     * @param  \App\Models\Penjadwalan  $penjadwalan
     * @return void
     */
    public function updated(Penjadwalan $data)
    {
        $input['id_permohonan'] = $data->id;
        $input['id_operator']   = optional(auth()->user())->id;
        $input['deskripsi']     = 'Penjadwalan '.'('.$data->status.')';

        Histori::create($input);
    }

    /**
     * Handle the Penjadwalan "deleted" event.
     *
     * @param  \App\Models\Penjadwalan  $penjadwalan
     * @return void
     */
    public function deleted(Penjadwalan $data)
    {
        //
    }

    /**
     * Handle the Penjadwalan "restored" event.
     *
     * @param  \App\Models\Penjadwalan  $penjadwalan
     * @return void
     */
    public function restored(Penjadwalan $penjadwalan)
    {
        //
    }

    /**
     * Handle the Penjadwalan "force deleted" event.
     *
     * @param  \App\Models\Penjadwalan  $penjadwalan
     * @return void
     */
    public function forceDeleted(Penjadwalan $penjadwalan)
    {
        //
    }
}
