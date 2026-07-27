<?php

namespace Modules\Formulir\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Formulir\Entities\DataDukung;
use Modules\Formulir\Entities\Permohonan;
use Illuminate\Support\Str;
use DB;

class BuktiDukungController extends Controller
{
    protected $title = 'Data Bukti Dukung';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Otorisasi khusus untuk akun Alfi Haryadi dan Mohammad Yasin
     */
    protected function checkAuthorization()
    {
        $user = auth()->user() ?? me();
        if (!$user) {
            abort(403, 'Akses Ditolak');
        }

        $allowedEmails = [
            'alfi.haryadi11@gmail.com',
            '199607192025061005'
        ];
        $allowedIds = [6, 320];

        $isAllowed = in_array($user->id, $allowedIds)
            || in_array($user->email, $allowedEmails)
            || str_contains(strtolower($user->email ?? ''), 'alfi')
            || str_contains(strtolower($user->name ?? ''), 'yasin')
            || str_contains(strtolower($user->nickname ?? ''), 'yasin');

        if (!$isAllowed) {
            abort(403, 'Halaman ini khusus untuk akun Alfi Haryadi dan Mohammad Yasin.');
        }
    }

    /**
     * Query dasar untuk menyaring data yang valid saja (mengabaikan data testing tanpa permohonan)
     */
    protected function getValidQuery()
    {
        return DataDukung::where(function ($q) {
            $q->has('permohonan')
              ->orHas('arsip')
              ->orHas('beimbai');
        });
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $this->checkAuthorization();

        $baseQuery = $this->getValidQuery();

        if ($request->has('datatable')) {
            $query = $baseQuery->with([
                'permohonan.pemohon1', 
                'permohonan.kategori', 
                'arsip.pemohon1', 
                'arsip.kategori', 
                'beimbai.pemohon1', 
                'beimbai.kategori', 
                'files'
            ]);

            if ($request->filled('jenis_filter')) {
                if ($request->jenis_filter === 'file') {
                    $query->whereNotNull('file')->where('file', '!=', '');
                } elseif ($request->jenis_filter === 'url') {
                    $query->whereNotNull('url')->where('url', '!=', '');
                }
            }

            if ($request->filled('tahun_filter')) {
                $tahun = $request->tahun_filter;
                $query->where(function ($q) use ($tahun) {
                    $q->whereHas('permohonan', function ($sub) use ($tahun) {
                        $sub->whereYear('created_at', $tahun);
                    })->orWhereHas('arsip', function ($sub) use ($tahun) {
                        $sub->whereYear('created_at', $tahun)->orWhere('tahun', $tahun);
                    })->orWhereHas('beimbai', function ($sub) use ($tahun) {
                        $sub->whereYear('created_at', $tahun);
                    });
                });
            }

            if ($request->filled('permohonan_filter')) {
                $keyword = $request->permohonan_filter;
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('permohonan', function ($sub) use ($keyword) {
                        $sub->where('label', 'like', "%{$keyword}%");
                    })->orWhereHas('arsip', function ($sub) use ($keyword) {
                        $sub->where('label', 'like', "%{$keyword}%");
                    })->orWhereHas('beimbai', function ($sub) use ($keyword) {
                        $sub->where('label', 'like', "%{$keyword}%");
                    });
                });
            }

            return $this->datatable($query);
        }

        $totalBukti = (clone $baseQuery)->count();
        $totalFile = (clone $baseQuery)->whereNotNull('file')->where('file', '!=', '')->count();
        $totalUrl = (clone $baseQuery)->whereNotNull('url')->where('url', '!=', '')->count();
        $totalInovasi = (clone $baseQuery)->distinct('id_permohonan')->count('id_permohonan');

        $availableYears = [2026, 2025, 2024, 2023];

        return view('formulir::bukti-dukung.index', compact(
            'totalBukti',
            'totalFile',
            'totalUrl',
            'totalInovasi',
            'availableYears'
        ));
    }

    /**
     * Datatable response
     */
    public function datatable($query)
    {
        return datatables()->of($query)
            ->filterColumn('permohonan', function ($q, $keyword) {
                $q->whereHas('permohonan', function ($sub) use ($keyword) {
                    $sub->where('label', 'like', "%{$keyword}%");
                })->orWhereHas('arsip', function ($sub) use ($keyword) {
                    $sub->where('label', 'like', "%{$keyword}%");
                })->orWhereHas('beimbai', function ($sub) use ($keyword) {
                    $sub->where('label', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('pemohon', function ($q, $keyword) {
                $q->whereHas('permohonan.pemohon1', function ($sub) use ($keyword) {
                    $sub->where('name', 'like', "%{$keyword}%")
                        ->orWhere('nip', 'like', "%{$keyword}%")
                        ->orWhere('unit_kerja', 'like', "%{$keyword}%");
                })->orWhereHas('arsip.pemohon1', function ($sub) use ($keyword) {
                    $sub->where('name', 'like', "%{$keyword}%")
                        ->orWhere('nip', 'like', "%{$keyword}%")
                        ->orWhere('unit_kerja', 'like', "%{$keyword}%");
                })->orWhereHas('beimbai.pemohon1', function ($sub) use ($keyword) {
                    $sub->where('name', 'like', "%{$keyword}%")
                        ->orWhere('nip', 'like', "%{$keyword}%")
                        ->orWhere('unit_kerja', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('bukti', function ($q, $keyword) {
                $q->where('label', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%")
                    ->orWhere('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('url', 'like', "%{$keyword}%");
            })
            ->editColumn('pilihan', function ($data) {
                return '<span>
                    <div class="checkbox checkbox-only">
                        <input type="checkbox" id="pilihan[' . $data->id . ']" name="pilihan[]" value="' . $data->uuid . '">
                        <label for="pilihan[' . $data->id . ']"></label>
                    </div>
                </span>';
            })
            ->editColumn('permohonan', function ($data) {
                $permohonan = $data->permohonan ?? $data->arsip ?? $data->beimbai;
                $isArsip = !$data->permohonan && $data->arsip;
                $isBeimbai = !$data->permohonan && !$data->arsip && $data->beimbai;

                if (!$permohonan) {
                    return '<span class="text-muted">Permohonan #' . ($data->id_permohonan ?? '-') . ' (Telah Dihapus)</span>';
                }

                $kategoriLabel = optional($permohonan->kategori)->label ?? 'Umum';
                $tahun = $permohonan->created_at ? $permohonan->created_at->format('Y') : ($permohonan->tahun ?? '-');

                $editUrl = route('epanel.permohonan.edit', $permohonan->uuid ?? $permohonan->id);
                if ($isArsip && \Route::has('epanel.arsip.show')) {
                    $editUrl = route('epanel.arsip.show', $permohonan->uuid ?? $permohonan->id);
                }

                $html = '<div class="d-flex flex-column">';
                $html .= '<a href="' . $editUrl . '" class="fw-bold text-primary text-decoration-none" title="Lihat Detail Inovasi">' . e($permohonan->label) . '</a>';
                $html .= '<div class="mt-1 d-flex flex-wrap align-items-center gap-1">';
                $html .= '<span class="badge bg-soft-info text-info me-1" style="font-size:10px;">' . e($kategoriLabel) . '</span>';
                $html .= '<span class="badge bg-soft-secondary text-secondary" style="font-size:10px;">Tahun ' . e($tahun) . '</span>';
                if ($isArsip) {
                    $html .= '<span class="badge bg-soft-warning text-warning" style="font-size:10px;">Arsip 2024</span>';
                } elseif ($isBeimbai) {
                    $html .= '<span class="badge bg-soft-success text-success" style="font-size:10px;">Beimbai</span>';
                }
                $html .= '</div></div>';
                return $html;
            })
            ->editColumn('pemohon', function ($data) {
                $permohonan = $data->permohonan ?? $data->arsip ?? $data->beimbai;
                $pemohon = optional(optional($permohonan)->pemohon1);

                if (!$pemohon->name) {
                    return '<span class="text-muted">-</span>';
                }

                $html = '<strong class="text-dark">' . e($pemohon->name) . '</strong>';
                if ($pemohon->unit_kerja) {
                    $html .= '<br><small class="text-muted"><i class="iconify me-1" data-icon="clarity:building-line"></i>' . e($pemohon->unit_kerja) . '</small>';
                }
                if ($pemohon->nip) {
                    $html .= '<br><span class="badge bg-primary mt-1" style="font-size:10px;">NIP: ' . e($pemohon->nip) . '</span>';
                }
                return $html;
            })
            ->editColumn('bukti', function ($data) {
                $indikator = optional($data->files);

                $html = '<div class="d-flex flex-column">';
                $html .= '<span class="fw-bold text-dark mb-1">' . e($data->label ?? 'Bukti Dukung') . '</span>';

                if ($indikator->label_indikator) {
                    $html .= '<small class="text-muted"><i class="iconify text-primary me-1" data-icon="healthicons:i-exam-multiple-choice-outline"></i>Indikator: <strong>' . e($indikator->label_indikator) . '</strong></small>';
                }

                if ($data->nomor_surat) {
                    $html .= '<small class="text-muted">No. Surat: ' . e($data->nomor_surat) . '</small>';
                }

                if ($data->deskripsi) {
                    $html .= '<small class="text-muted text-wrap" style="max-width:280px;">' . e(Str::limit($data->deskripsi, 120)) . '</small>';
                }

                $html .= '</div>';
                return $html;
            })
            ->editColumn('akses', function ($data) {
                $html = '<div class="d-flex flex-column gap-1 align-items-start">';

                // File Upload
                if (!empty($data->file)) {
                    $filePath = asset($data->file);
                    $html .= '<a href="' . $filePath . '" target="_blank" class="btn btn-xs btn-soft-primary d-inline-flex align-items-center" data-lity title="Pratinjau / Unduh File">';
                    $html .= '<span class="iconify me-1" data-icon="bx:bxs-file-pdf"></span> File Upload';
                    $html .= '</a>';
                }

                // URL Link
                if (!empty($data->url)) {
                    $html .= '<a href="' . e($data->url) . '" target="_blank" class="btn btn-xs btn-soft-success d-inline-flex align-items-center" title="Buka Tautan URL">';
                    $html .= '<span class="iconify me-1" data-icon="bx:bx-link-external"></span> Tautan URL';
                    $html .= '</a>';
                }

                if (empty($data->file) && empty($data->url)) {
                    $html .= '<span class="badge bg-soft-warning text-warning">Tidak Ada File/URL</span>';
                }

                $html .= '</div>';
                return $html;
            })
            ->editColumn('jenis', function ($data) {
                if (!empty($data->file) && !empty($data->url)) {
                    return '<span class="badge bg-success">File & URL</span>';
                } elseif (!empty($data->file)) {
                    return '<span class="badge bg-info">File Upload</span>';
                } elseif (!empty($data->url)) {
                    return '<span class="badge bg-warning">Link URL</span>';
                }
                return '<span class="badge bg-secondary">-</span>';
            })
            ->editColumn('tanggal', function ($data) {
                return $data->created_at ? $data->created_at->format('d/m/Y H:i') : '-';
            })
            ->escapeColumns([])
            ->toJson();
    }

    /**
     * Export data to CSV
     */
    public function export()
    {
        $this->checkAuthorization();

        $data = $this->getValidQuery()->with([
            'permohonan.pemohon1', 
            'permohonan.kategori', 
            'arsip.pemohon1', 
            'arsip.kategori', 
            'beimbai.pemohon1', 
            'beimbai.kategori', 
            'files'
        ])
            ->latest()
            ->get();

        $filename = 'Daftar_Bukti_Dukung_Inovasi_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Judul Inovasi',
                'Bidang Inovasi',
                'Nama Inovator',
                'NIP Inovator',
                'Unit Kerja',
                'Indikator',
                'Label Bukti Dukung',
                'Nomor Surat',
                'Deskripsi',
                'Jenis',
                'URL Link',
                'File Path',
                'Tanggal Upload'
            ]);

            foreach ($data as $item) {
                $permohonan = $item->permohonan ?? $item->arsip ?? $item->beimbai;
                $pemohon = optional(optional($permohonan)->pemohon1);
                $kategori = optional(optional($permohonan)->kategori);
                $indikator = optional($item->files);

                $jenis = 'Lainnya';
                if (!empty($item->file) && !empty($item->url)) {
                    $jenis = 'File & URL';
                } elseif (!empty($item->file)) {
                    $jenis = 'File Upload';
                } elseif (!empty($item->url)) {
                    $jenis = 'Link URL';
                }

                fputcsv($file, [
                    optional($permohonan)->label ?? '',
                    optional($kategori)->label ?? '',
                    optional($pemohon)->name ?? '',
                    optional($pemohon)->nip ?? '',
                    optional($pemohon)->unit_kerja ?? '',
                    optional($indikator)->label_indikator ?? '',
                    $item->label ?? '',
                    $item->nomor_surat ?? '',
                    $item->deskripsi ?? '',
                    $jenis,
                    $item->url ?? '',
                    $item->file ? asset($item->file) : '',
                    $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : ''
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
