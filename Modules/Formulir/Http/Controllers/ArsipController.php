<?php

namespace Modules\Formulir\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Formulir\Entities\Arsip;
use Modules\Core\Entities\Histori;
use Modules\Formulir\Entities\Penilaian;
use App\Observers\HistoriObserver;
use App\Observers\PenilaianObserver;

class ArsipController extends Controller
{
    protected $title = 'Arsip Inovasi Daerah';

    public function __construct(Arsip $data, Histori $histori)
    {
        $this->data = $data;
        $this->histori = $histori;
        $this->toIndex = route('epanel.permohonan.index');
        $this->prefix = 'epanel.permohonan';
        $this->view = 'formulir::permohonan';

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title changed successfully!";
        $this->tDelete = "Some $this->title deleted successfully!";

        view()->share([
            'title' => $this->title,
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }

    public function index(Request $request)
    {
        if ($request->has('datatable')):
            $query = $this->data->newQuery()->with('pemohon1')->select($this->data->getTable() . '.*');
            return $this->datatable($query);
        endif;

        $data = $this->data::query();
        return view("$this->view.index", compact('data'));
    }

    public function create()
    {
        $data = $this->data
            ->with(['pemohon1', 'kategori'])
            ->orderBy('created_at', 'asc')
            ->get();

        $filename = 'Daftar_Permohonan_Inovasi.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Judul Inovasi',
                'Bidang Inovasi',
                'Nama Inovator',
                'NIP Inovator',
                'NIK Inovator',
                'Unit Kerja',
                'Jabatan',
                'Email',
                'No HP',
                'Instansi',
                'Status Inovasi',
                'Tanggal Pengajuan',
                'Tahun Pengajuan',
                'Nilai Akhir',
                'Keterangan'
            ]);

            foreach ($data as $permohonan) {
                $pemohon = $permohonan->pemohon1;
                $kategori = $permohonan->kategori;

                $tanggal_pengajuan = $permohonan->created_at ? $permohonan->created_at->format('d-m-Y') : '';
                $tahun_pengajuan = $permohonan->created_at ? $permohonan->created_at->format('Y') : '';
                $status_inovasi = $this->statusLabel($permohonan->status);
                $nilai_akhir = $permohonan->nilai_akhir ?? '';
                $keterangan = $permohonan->alasan_tolak ?? '';

                fputcsv($file, [
                    $permohonan->label,
                    optional($kategori)->label,
                    optional($pemohon)->name,
                    optional($pemohon)->nip,
                    optional($pemohon)->nik,
                    optional($pemohon)->jabatan,
                    optional($pemohon)->email,
                    optional($pemohon)->phone,
                    optional($pemohon)->instansi,
                    $status_inovasi,
                    $tanggal_pengajuan,
                    $tahun_pengajuan,
                    $nilai_akhir,
                    $keterangan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function statusLabel($status)
    {
        switch ($status) {
            case 1:
                return 'Disetujui';
            case 2:
                return 'Menunggu Review';
            case 4:
                return 'Selesai Review';
            case 9:
                return 'Ditolak';
            default:
                return 'Diajukan';
        }
    }

    public function datatable($data)
    {
        return datatables()->of($data)
            ->filterColumn('pemohon', function ($query, $keyword) {
                $query->whereHas('pemohon1', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('unit_kerja', 'like', "%{$keyword}%")
                        ->orWhere('nip', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('keperluan', function ($query, $keyword) {
                $query->where($query->getModel()->getTable() . '.label', 'like', "%{$keyword}%");
            })
            ->filterColumn('tahun', function ($query, $keyword) {
                $query->whereYear('created_at', 'like', "%{$keyword}%");
            })
            ->orderColumn('pemohon', function ($query, $order) {
                $query->orderBy(
                    \Modules\Pemohon\Entities\Pemohon::select('name')
                        ->whereColumn('pemohon.id_operator', $query->getModel()->getTable() . '.id_pemohon_0')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('keperluan', function ($query, $order) {
                $query->orderBy($query->getModel()->getTable() . '.label', $order);
            })
            ->orderColumn('tahun', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->editColumn('pilihan', function ($data) {
                $return = '<span>';
                $return .= '<div class="checkbox checkbox-only">';
                $return .= '<input type="checkbox" id="pilihan[' . $data->id . ']" name="pilihan[]" value="' . $data->uuid . '">';
                $return .= '<label for="pilihan[' . $data->id . ']"></label>';
                $return .= '</div>';
                $return .= '</span>';
                return $return;
            })
            ->editColumn('pemohon', function ($data) {
                $return = '<strong>' . optional($data->pemohon1)->name . '</strong>';
                $return .= '<br><small class="text-muted">' . ($data->pemohon1->unit_kerja ?? '-') . '</small>';
                if (optional($data->pemohon1)->nip) {
                    $return .= '<br><label class="badge bg-primary" style="font-size:10px;">NIP: ' . optional($data->pemohon1)->nip . '</label>';
                }
                return $return;
            })
            ->editColumn('keperluan', function ($data) {
                return $data->label;
            })
            ->editColumn('aksi', function ($data) {
                $return = '';
                $return .= '<a href="' . route("epanel.arsip.show", $data->uuid) . '" class="btn btn-white btn-xs mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Inovasi">';
                $return .= '<span class="iconify" data-icon="mdi:eye"></span>';
                $return .= '</a> ';

                $return .= '<a href="' . route("epanel.arsip.penilaian", $data->uuid) . '" class="btn btn-white btn-xs mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Indikator & Data Dukung">';
                $return .= '<span class="iconify" data-icon="mdi:home-clock"></span>';
                $return .= '</a> ';

                if ($data->status == 4) {
                    $return .= '<div class="mt-1"><span class="badge bg-success">Selesai</span></div>';
                }
                return $return;
            })
            ->escapeColumns(['*'])->toJson();
    }

    public function show($id)
    {
        $show = $this->data->uuid($id)->firstOrFail();
        return view("formulir::permohonan.show", compact('show'));
    }

    public function penilaian(Request $request, $id)
    {
        $kategori = $this->data->uuid($id)->firstOrFail();
        $data = $kategori->inovasis()->with('files')->latest()->get();

        if ($request->has('datatable')):
            return datatables()->of($data)
                ->editColumn('pilihan', function ($data) {
                    return '';
                })
                ->editColumn('label', function ($data) {
                    return $data->label_indikator;
                })
                ->editColumn('slug', function ($data) {
                    return $data->label_parameter;
                })
                ->editColumn('action', function ($data) {
                    $fileCount = $data->files->count();
                    $badgeColor = $fileCount > 0 ? 'bg-success text-white' : 'bg-dark text-white';
                    $badge = '<span class="badge ' . $badgeColor . ' badge-pill" style="font-size: 0.75rem; padding: 4px 8px;">' . $fileCount . ' Bukti</span>';

                    $action = '<div class="d-flex align-items-center justify-content-center" style="gap: 8px;">';
                    $action .= '<a href="' . route('epanel.penilaian.file.index', [$data->uuid]) . '" class="link link-secondary font-weight-bold">
                        <span class="iconify" data-icon="uil:edit"></span> <span class="">Lihat File</span>
                        </a>';
                    $action .= $badge;
                    $action .= '</div>';

                    return $action;
                })
                ->escapeColumns(['*'])->toJson();
        endif;

        $view = 'formulir::permohonan.penilaian';
        $prefix = 'epanel.arsip';
        return view("formulir::permohonan.penilaian.index", compact('data', 'kategori', 'prefix', 'view'));
    }

    // public function store(Request $request) {}
    // public function show($id) {}
    // public function edit($id) {}
    // public function update(Request $request, $id) {}
    // public function destroy(Request $request, $id) {}
}
