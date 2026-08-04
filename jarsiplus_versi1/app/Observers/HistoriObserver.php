<?php

namespace App\Observers;

use Modules\Formulir\Entities\Permohonan;

use Modules\Core\Entities\Histori;

class HistoriObserver
{
    /**
     * Handle the Histori "created" event.
     *
     * @param  \App\Models\Histori  $histori
     * @return void
     */


    public function __construct(Histori $histori) 
    {
        $this->histori = $histori;
    }


    public function created(Permohonan $data)
    {
        $input['id_permohonan'] = $data->id;
        $input['id_operator']   = me()->id;
        $input['deskripsi']     = 'permohonan ditambahkan';

        Histori::create($input);

    }

    /**
     * Handle the Histori "updated" event.
     *
     * @param  \App\Models\Histori  $histori
     * @return void
     */
    public function updated(Permohonan $data)
    {

        if(me()):
            $input['id_operator']   = me()->id;
            $input['id_permohonan'] = $data->id;
            if ($data->status == 1) {
                $input['deskripsi'] = 'Permohonan disetujui, Silahkan Isi Indikator Indikator dan Parameter Anda';
            } elseif ($data->status == 2) {
                $input['deskripsi'] = 'Permohonan dalam proses validasi';
            } elseif ($data->status == 3) {
                $input['deskripsi'] = 'Permohonan Telah Dikirim, Silahkan Tunggu Hasil Scoring Anda';
            } elseif ($data->status == 4) {
                $input['deskripsi'] = 'Proses selesai silahkan cek score anda';
            }
            else {
                $input['deskripsi'] = 'permohonan ditolak dengan alasan ' . $data->alasan_tolak;
            }
            Histori::create($input);
        endif;
    }

    /**
     * Handle the Histori "deleted" event.
     *
     * @param  \App\Models\Histori  $histori
     * @return void
     */
    public function deleted(Permohonan $data)
    {
        $data->delete();
        $input['id_permohonan'] = $data->id;
        $input['id_operator']   = me()->id;
        $input['deskripsi']     = 'permohonan dihapus';
        
        Histori::create($input);
    }

    /**
     * Handle the Histori "restored" event.
     *
     * @param  \App\Models\Histori  $histori
     * @return void
     */
    public function restored(Permohonan $data)
    {
        //
    }

    /**
     * Handle the Histori "force deleted" event.
     *
     * @param  \App\Models\Histori  $histori
     * @return void
     */
    public function forceDeleted(Permohonan $data)
    {
        //
    }
}
