<?php

namespace Modules\Formulir\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;
use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\Histori;
use Modules\Formulir\Entities\Penilaian;
use App\Observers\HistoriObserver;
use App\Observers\PenilaianObserver;

class PermohonanController extends Controller
{

    protected $title = 'Pengajuan Inovasi Daerah';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Permohonan $data, Histori $histori)
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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
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

            // Header kolom CSV
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

                // Penyesuaian field sesuai struktur model Anda
                $tanggal_pengajuan = $permohonan->created_at ? $permohonan->created_at->format('d-m-Y') : '';
                $tahun_pengajuan = $permohonan->created_at ? $permohonan->created_at->format('Y') : '';
                $status_inovasi = $this->statusLabel($permohonan->status);
                $nilai_akhir = $permohonan->nilai_akhir ?? '';
                $keterangan = $permohonan->alasan_tolak ?? '';

                fputcsv($file, [
                    $permohonan->label,                               // Judul Inovasi
                    optional($kategori)->label,                       // Bidang Inovasi
                    optional($pemohon)->name,                         // Nama Inovator
                    optional($pemohon)->nip,                          // NIP
                    optional($pemohon)->nik,                          // NIK
                    optional($pemohon)->jabatan,                      // Jabatan (pastikan field ada)
                    optional($pemohon)->email,                        // Email (pastikan field ada)
                    optional($pemohon)->phone,                        // No HP (pastikan field ada)
                    optional($pemohon)->instansi,                     // Instansi (jika ada field)
                    $status_inovasi,                                  // Status Inovasi (fungsi helper di bawah)
                    $tanggal_pengajuan,
                    $tahun_pengajuan,
                    $keterangan
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Konversi status ke label teks (bisa disesuaikan)
     */
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


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $show = $this->data->uuid($id)->firstOrFail();
        return view("$this->view.show", compact('show'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();
        $juriComments = $this->getJuriKomentar($edit);
        return view("$this->view.edit", compact('edit', 'juriComments'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();
        $allowedStatuses = [
            0 => [1, 9],
            1 => [2],
            3 => [4],
        ];

        $input = $request->validate([
            'status' => ['required', Rule::in($allowedStatuses[(int) $edit->status] ?? [])],
            'alasan_tolak' => 'required_if:status,9|nullable|string',
        ]);

        if ((int) $input['status'] !== 9) {
            unset($input['alasan_tolak']);
        }

        $edit->update($input);

        if ($edit->status == 4) {
            $penilaian = Penilaian::where('inovasi_id', $edit->id)->get();
            $totalBobot = $penilaian->sum('bobot');

            $permohonan = Permohonan::findOrFail($edit->id);
            $permohonan->nilai_akhir = $totalBobot;

            $permohonan->save();
        }

        $number = $edit->pemohon1->phone;
        $date = tgl_indo($edit->created_at);

        if ($edit->status == 1) {
            $pesan = <<<EOT
            *## JARSIPLUS Kota Samarinda ##*

            Inovasi anda telah disetujui.

            Detail Inovasi : 
            Judul : {$edit->label}
            Bidang Inovasi : {$edit->kategori->label}

            Nama :  {$edit->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$edit->pemohon1->unit_kerja}

            Silahkan isi parameter dan data dukung yang dibutuhkan.

            Terima kasih,
            Pemerintah Kota Samarinda
            EOT;

            send_whatshapp($number, $pesan);
        } elseif ($edit->status == 2) {
            $pesan = <<<EOT
             *## JARSIPLUS Kota Samarinda ##*

            Parameter dan data dukung anda siap di review.

            Detail Inovasi : 
            Judul : {$edit->label}
            Bidang Inovasi : {$edit->kategori->label}

            Nama :  {$edit->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$edit->pemohon1->unit_kerja}

            Mohon tunggu hasil review dari tim kami. Kami akan segera mengevaluasi parameter dan data yang telah Anda berikan. Terima kasih atas kesabaran dan kerjasama Anda.

            Terima kasih,
            Pemerintah Kota Samarinda
            EOT;

            send_whatshapp($number, $pesan);
        } elseif ($edit->status == 4) {
            $pesan = <<<EOT
            *## JARSIPLUS Kota Samarinda ##*

            Inovasi anda telah selesai di review.

            Detail Inovasi : 
            Judul : {$edit->label}
            Bidang Inovasi : {$edit->kategori->label}

            Nama :  {$edit->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$edit->pemohon1->unit_kerja}

            Selamat! Anda dapat melihat skor dari inovasi yang telah Anda ajukan. Terima kasih atas kontribusi anda.

            Terima kasih,
            Pemerintah Kota Samarinda
            EOT;

            send_whatshapp($number, $pesan);
        } elseif ($edit->status == 9) {
            $pesan = <<<EOT
             *## JARSIPLUS Kota Samarinda ##*

            Inovasi tidak lolos verifikasi.

            Judul : {$edit->label}
            Bidang Inovasi : {$edit->kategori->label}

            Nama :  {$edit->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$edit->pemohon1->unit_kerja}
            Alasan Penolakan : {$edit->alasan_tolak}

            Mohon maaf, inovasi Anda telah ditolak karena tidak lolos verifikasi. Anda dapat mengajukan kembali inovasi Anda dengan perbaikan yang diperlukan.

            Kami mohon maaf atas ketidaknyamanan ini dan kami menghargai partisipasi Anda. Silahkan ajukan kembali inovasi Anda dengan memperhatikan kriteria dan persyaratan yang berlaku.

            Terima kasih,
            Pemerintah Kota Samarinda
            EOT;

            send_whatshapp($number, $pesan);
        }

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    public function notifyStatus($id)
    {
        $permohonan = $this->data->uuid($id)->firstOrFail();
        $number = optional($permohonan->pemohon1)->phone;

        if (trim((string) $number) === '') {
            notify()->flash('Notifikasi tidak dapat dikirim karena nomor WhatsApp pemohon belum tersedia.', 'warning');
            return redirect()->back();
        }

        $response = send_whatshapp($number, $this->statusNotificationMessage($permohonan));

        if (isset($response['success']) && $response['success'] === false) {
            $reason = trim(strip_tags((string) ($response['message'] ?? 'Gateway WhatsApp tidak memberikan keterangan.')));
            $reason = \Illuminate\Support\Str::limit($reason, 180);

            \Log::warning('Notifikasi manual status permohonan gagal dikirim', [
                'permohonan_id' => $permohonan->id,
                'status' => $permohonan->status,
                'phone' => $number,
                'response' => $response,
            ]);

            notify()->flash('Notifikasi status gagal dikirim: ' . $reason, 'warning');
            return redirect()->back();
        }

        notify()->flash('Notifikasi status terbaru berhasil dikirim ke pemohon.', 'success');
        return redirect()->back();
    }

    protected function statusNotificationMessage(Permohonan $permohonan)
    {
        $statusLabels = [
            0 => 'Diajukan / Menunggu Validasi',
            1 => 'Disetujui',
            2 => 'Dalam Proses Validasi',
            3 => 'Dikirim untuk Penilaian',
            4 => 'Selesai Review',
            9 => 'Ditolak',
        ];
        $statusDescriptions = [
            0 => 'Permohonan Anda telah kami terima dan sedang menunggu proses validasi.',
            1 => 'Permohonan Anda telah disetujui. Silakan melengkapi indikator dan data dukung yang dibutuhkan.',
            2 => 'Permohonan Anda sedang dalam proses validasi. Mohon menunggu hasil evaluasi tim kami.',
            3 => 'Data inovasi Anda telah dikirim untuk proses penilaian. Mohon menunggu hasil penilaian.',
            4 => 'Proses review inovasi Anda telah selesai. Silakan melihat hasil pada aplikasi JARSIPLUS.',
            9 => 'Permohonan inovasi Anda tidak lolos verifikasi.',
        ];

        $status = (int) $permohonan->status;
        $statusLabel = $statusLabels[$status] ?? 'Status Tidak Dikenali';
        $description = $statusDescriptions[$status] ?? 'Silakan menghubungi administrator untuk informasi lebih lanjut.';
        $date = tgl_indo($permohonan->created_at);
        $reason = '';

        if ($status === 9 && trim((string) $permohonan->alasan_tolak) !== '') {
            $reason = "\nAlasan Penolakan : {$permohonan->alasan_tolak}\n";
        }

        return <<<EOT
            *## JARSIPLUS Kota Samarinda ##*

            Informasi status terbaru inovasi Anda:

            Judul : {$permohonan->label}
            Bidang Inovasi : {$permohonan->kategori->label}
            Nama : {$permohonan->pemohon1->name}
            Tanggal Pengajuan : {$date}
            Status Terbaru : {$statusLabel}
            {$reason}
            {$description}

            Terima kasih,
            Pemerintah Kota Samarinda
            EOT;
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('pilihan')):
            foreach ($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                $each->delete();
            endforeach;
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
        $satu = $this->data->uuid($id)->first();
        $satu->delete();
        return 'success';
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
            ->editColumn('tahun', function ($data) {
                return $data->tahun ?? 2026;
            })
            ->editColumn('aksi', function ($data) {
                $return = '';
                if ($data->status == 4) {
                    $return = '<span class="badge bg-success">Selesai</span>';
                } else {
                    $return .= '<a href="' . route("$this->prefix.edit", $data->uuid) . '" class="btn btn-white btn-xs mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kelola Inovasi">';
                    $return .= '<span class="iconify" data-icon="eos-icons:virtual-host-manager"></span>';
                    $return .= '</a> ';

                    if ($data->status != 4) {
                        $return .= '<a href="' . route("$this->prefix.penilaian.index", $data->uuid) . '" class="btn btn-white btn-xs mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Indikator">';
                        $return .= '<span class="iconify" data-icon="mdi:home-clock"></span>';
                        $return .= '</a> ';
                    }

                    if ($data->status == 2) {
                        $return .= '<a href="' . route("$this->prefix.persetujuan.index", $data->uuid) . '" class="btn btn-soft-success btn-xs mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Setujui Inovasi">';
                        $return .= '<span class="iconify" data-icon="mdi:check-circle"></span>';
                        $return .= '</a>';
                    }
                }
                return $return;
            })
            ->escapeColumns(['*'])->toJson();
    }

    protected function getJuriKomentar($permohonan)
    {
        try {
            $endpoint = env('JURI_API_PENILAIAN_URL', 'https://juri-jarsiplus.samarindakota.go.id/api/penilaian-juri');

            $client = new Client([
                'verify' => false,
                'timeout' => 10,
                'http_errors' => false,
            ]);

            $response = $client->get($endpoint, [
                'query' => [
                    'id_permohonan' => $permohonan->id,
                ],
            ]);

            $payload = json_decode((string) $response->getBody(), true);

            $items = collect($payload['data'] ?? []);

            $matched = $items
                ->filter(function ($item) use ($permohonan) {
                    $remoteId = (string) ($item['id_permohonan'] ?? $item['permohonan_id'] ?? $item['id'] ?? '');
                    return $remoteId !== '' && $remoteId === (string) $permohonan->id;
                })
                ->values()
                ->all();

            if (empty($matched) && $items->isNotEmpty()) {
                \Log::warning('Komentar juri tidak match dengan permohonan', [
                    'permohonan_id' => $permohonan->id,
                    'permohonan_status' => $permohonan->status,
                    'endpoint' => $endpoint,
                    'sample_id_api' => $items->pluck('id_permohonan')->filter()->take(3)->values()->all(),
                ]);
            }

            return $matched;
        } catch (\Throwable $e) {
            \Log::error('Gagal mengambil komentar juri', [
                'permohonan_id' => $permohonan->id ?? null,
                'message' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
