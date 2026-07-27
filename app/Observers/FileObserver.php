<?php

namespace App\Observers;

use Modules\Formulir\Entities\DataDukung;
use Modules\Core\Entities\Histori;

class FileObserver
{
    /**
     * Handle the File "created" event.
     *
     * @param  \App\Models\File  $data
     * @return void
     */

    public function __construct(Histori $histori)
    {
        $this->histori = $histori;
    }

    public function created(DataDukung $data)
    {
        $input['id_file'] = $data->id;
        $input['id_permohonan'] = $data->id_permohonan;
        $input['file'] = $data->file;
        $input['id_operator'] = optional(auth()->user())->id;

        // Deskripsi sesuai jenis data dukung
        if ($data->jenis == 'url') {
            $input['deskripsi'] = 'Link ' . $data->label . ' telah ditambahkan';
        } else {
            $input['deskripsi'] = 'file ' . $data->label . ' telah ditambahkan';
        }

        Histori::create($input);
    }

    /**
     * Handle the File "updated" event.
     *
     * @param  \App\Models\File  $data
     * @return void
     */
    public function updated(DataDukung $data)
    {
        $input['id_file'] = $data->id;
        $input['id_permohonan'] = $data->id_permohonan;
        $input['file'] = $data->file;
        $input['id_operator'] = optional(auth()->user())->id;

        // Deskripsi sesuai jenis data dukung
        if ($data->jenis == 'url') {
            $input['deskripsi'] = 'Link ' . $data->label . ' telah dirubah';
        } else {
            $input['deskripsi'] = 'file ' . $data->label . ' telah dirubah';
        }

        Histori::create($input);
    }

    /**
     * Handle the File "deleted" event.
     *
     * @param  \App\Models\File  $data
     * @return void
     */
    public function deleted(DataDukung $data)
    {
        $input['id_file'] = $data->id;
        $input['id_permohonan'] = $data->id_permohonan;
        $input['file'] = $data->file;
        $input['id_operator'] = optional(auth()->user())->id;
        $input['deskripsi'] = 'File ' . $data->label . ' telah dihapus';

        Histori::create($input);
    }

    /**
     * Handle the File "restored" event.
     *
     * @param  \App\Models\File  $data
     * @return void
     */
    public function restored(File $data)
    {
        //
    }

    /**
     * Handle the File "force deleted" event.
     *
     * @param  \App\Models\File  $data
     * @return void
     */
    public function forceDeleted(File $data)
    {
        //
    }
}
