<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\User;
use Modules\Formulir\Entities\Permohonan;
use Modules\Pemohon\Entities\Pemohon;

use Carbon\Carbon;


class StatistikController extends Controller
{
    protected $title = 'Statistik';

    public function __construct(Permohonan $data , Pemohon $pemohon) 
    {
        $this->data = $data;
        $this->pemohon = $pemohon;

        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Statistik');
        $this->view     = $this->module.'::'.$this->entiti;
        $this->prefix   = $this->entiti;

        $this->toIndex = url('/statistik');
        $this->tCreate = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        // Status mengikuti konvensi yang dipakai di seluruh aplikasi:
        // 0 = menunggu validasi, 1 & 2 = dalam pembahasan, 4 = selesai, 9 = ditolak.
        //
        // Sebelumnya "setuju" dihitung dari status 1 (padahal itu masih tahap
        // pembahasan) dan "selesai" dari status 2 — sehingga usulan berstatus 4
        // yang benar-benar selesai tidak pernah ikut terhitung.
        $permohonan = $this->data->count();
        $proses = $this->data->where('status', 0)->count();
        $setuju = $this->data->whereIn('status', [1, 2])->count();
        $selesai = $this->data->where('status', 4)->count();
        $tolak = $this->data->where('status', 9)->count();

        $cpemohon = $this->pemohon->count();
        $pemohon = $this->pemohon->latest()->take(10)->get();

        $permohonanPerHari = $this->getPermohonanPerHari();
        $permohonanPerBulan = $this->getPermohonanPerBulan();
        
        $permohonanPerUrusan = $this->getPermohonanPerUrusan();
        $permohonanPerInisiator = $this->getPermohonanPerInisiator();
        $permohonanPerTahapan = $this->getPermohonanPerTahapan();

        return view("$this->view.index", compact('proses', 'setuju', 'tolak', 'pemohon', 'cpemohon', 'permohonan', 'selesai', 'permohonanPerHari', 'permohonanPerBulan', 'permohonanPerUrusan', 'permohonanPerInisiator', 'permohonanPerTahapan'));
    }


    private function getPermohonanPerHari()
    {

        $startDate = Carbon::today()->subDays(7);
        $endDate = Carbon::today();

        $permohonanPerHari = $this->data->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })
        ->map(function ($item) {
            return $item->count();
        });

        $dates = [];
        $counts = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
            $counts[] = $permohonanPerHari[$date->format('Y-m-d')] ?? 0;
        }

        return [
            'dates' => $dates,
            'counts' => $counts,
        ];
    }
    private function getPermohonanPerBulan()
    {
        $startDate = Carbon::today()->subMonths(12);
        $endDate = Carbon::today();

        $permohonanPerBulan = $this->data->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->startOfMonth()->format('Y-m');
        })
        ->map(function ($item) {
            return $item->count();
        });

        $months = [];
        $counts = [];

        for ($date = $startDate; $date <= $endDate; $date->addMonth()) {
            $months[] = $date->format('Y-m');
            $counts[] = $permohonanPerBulan[$date->format('Y-m')] ?? 0;
        }

        return [
            'months' => $months,
            'counts' => $counts,
        ];
    }

    private function getPermohonanPerUrusan()
    {
        return $this->data->selectRaw('urusan_utama, count(*) as total')
            ->whereNotNull('urusan_utama')
            ->groupBy('urusan_utama')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }

    private function getPermohonanPerInisiator()
    {
        return $this->data->selectRaw('inisiator, count(*) as total')
            ->whereNotNull('inisiator')
            ->groupBy('inisiator')
            ->orderByDesc('total')
            ->get();
    }

    private function getPermohonanPerTahapan()
    {
        return $this->data->selectRaw('tahapan, count(*) as total')
            ->whereNotNull('tahapan')
            ->groupBy('tahapan')
            ->orderByDesc('total')
            ->get();
    }

}