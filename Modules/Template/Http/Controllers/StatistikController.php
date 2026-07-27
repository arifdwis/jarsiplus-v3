<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Formulir\Entities\Permohonan;
use Modules\Pemohon\Entities\Pemohon;
use Carbon\Carbon;

class StatistikController extends Controller
{
    protected $title = 'Statistik';

    public function __construct(Permohonan $data, Pemohon $pemohon) 
    {
        $this->data = $data;
        $this->pemohon = $pemohon;
    }

    public function index()
    {
        $permohonan = $this->data->count();
        $proses = $this->data->where('status', 0)->count();
        $setuju = $this->data->where('status', 1)->count();
        $tolak = $this->data->where('status', 9)->count();
        $selesai = $this->data->where('status', 2)->count();

        $cpemohon = $this->pemohon->count();

        return Inertia::render('Statistik/Index', [
            'proses' => $proses,
            'setuju' => $setuju,
            'tolak' => $tolak,
            'selesai' => $selesai,
            'permohonan' => $permohonan,
            'cpemohon' => $cpemohon,
        ]);
    }
}