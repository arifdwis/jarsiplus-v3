<?php

namespace App\Observers;

use Modules\Formulir\Entities\Parameter;
use Modules\Formulir\Entities\Indikator;
use Modules\Formulir\Entities\Permohonan;
use Modules\Formulir\Entities\Penilaian;

class PenilaianObserver
{

    /**
     * Handle the data "created" event.
     *
     * @param  \App\Models\data  $data
     * @return void
     */
    public function created(Permohonan $data)
    {
        $indikators = Indikator::all();

        foreach($indikators as $value):
            $input['inovasi_id']      = $data->id;
            $input['indikator_id']    = $value->id;
            $input['label_indikator'] = $value->label;
            $input['status'] = '0';
            Penilaian::create($input);
        endforeach;

    }

    /**
     * Handle the data "updated" event.
     *
     * @param  \App\Models\data  $data
     * @return void
     */
    public function updated(Permohonan $data)
    {

    }

    /**
     * Handle the data "deleted" event.
     *
     * @param  \App\Models\data  $data
     * @return void
     */
    public function deleted(Permohonan $data)
    {
        //
    }

    /**
     * Handle the data "restored" event.
     *
     * @param  \App\Models\data  $data
     * @return void
     */
    public function restored(Permohonan $data)
    {
        //
    }

    /**
     * Handle the data "force deleted" event.
     *
     * @param  \App\Models\data  $data
     * @return void
     */
    public function forceDeleted(Permohonan $data)
    {
        //
    }
}
