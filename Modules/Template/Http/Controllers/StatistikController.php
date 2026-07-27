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

        $this->toIndex = route("$this->prefix.index");
        $this->tCreate = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        $permohonan = $this->data->count();
        $proses = $this->data->where('status', 0)->count();
        $setuju = $this->data->where('status', 1)->count();
        $tolak = $this->data->where('status', 9)->count();
        $selesai = $this->data->where('status', 2)->count();

        $cpemohon = $this->pemohon->count();
        $pemohon = $this->pemohon->latest()->take(10)->get();

        $permohonanPerHari = $this->getPermohonanPerHari();
        $permohonanPerBulan = $this->getPermohonanPerBulan();

        return view("$this->view.index", compact('proses', 'setuju', 'tolak', 'pemohon', 'cpemohon', 'permohonan', 'selesai', 'permohonanPerHari', 'permohonanPerBulan'));
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

}