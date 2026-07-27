<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;

use App\Models\User;
use Modules\Formulir\Entities\Permohonan;
use Modules\Formulir\Entities\Indikator;
use Modules\Core\Entities\Histori;
use Modules\Core\Entities\Penilaian;
use Modules\Core\Entities\Penjadwalan;
use Modules\Pemohon\Entities\Pemohon;
use App\Observers\HistoriObserver;
use App\Observers\PenilaianObserver;


use Inertia\Inertia;

class PermohonanController extends Controller
{
    protected $title = 'Permohonan';

    public function __construct(Permohonan $data, Pemohon $pemohon, Histori $histori, Penjadwalan $penjadwalan, Indikator $indikator)
    {
        $this->data = $data;
        $this->pemohon = $pemohon;
        $this->histori = $histori;
        $this->penjadwalan = $penjadwalan;
        $this->indikator = $indikator;

        $this->module = strtolower('Template');
        $this->entiti = strtolower('Permohonan');
        $this->view = $this->module . '::' . $this->entiti;
        $this->prefix = $this->entiti;

        $this->toIndex = route("$this->prefix.index");
        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title update successfully!";

        view()->share([
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        $userId = me()?->id;
        $data = $this->data::where('id_pemohon_0', $userId)->orWhere('id_pemohon_1', $userId)->latest()->get();
        return Inertia::render('Permohonan/Index', ['permohonan' => $data]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Permohonan/Create');
    }

    public function show(Request $request, $kode)
    {
        $data = $this->data::where('kode', $kode)->firstOrFail();
        $juriComments = $this->getJuriKomentar($data);
        return view("$this->view.show", compact('data', 'juriComments'));
    }


    public function detail(Request $request, $uuid)
    {
        $data = $this->data::where('uuid', $uuid)->firstOrFail();
        $juriComments = $this->getJuriKomentar($data);
        return view("$this->view.detail", compact('data', 'juriComments'));
    }

    public function finish(Request $request, $uuid)
    {
        $data = $this->data::where('uuid', $uuid)->firstOrFail();
        return view("$this->view.finish", compact('data'));
    }

    public function riwayat(Request $request, $uuid)
    {
        $data = $this->data::where('uuid', $uuid)->firstOrFail();
        $histori = $data->riwayat()->latest()->get();
        // return $histori;

        return view("$this->view.riwayat", compact('data', 'histori'));
    }


    public function store(Request $request)
    {
        if (!$this->hasCompleteIdentity()) {
            return $this->redirectToBiodata();
        }

        if (!$this->canBypassDeadline() && pendaftaran_permohonan_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect($this->toIndex);
        }

        // Prevent duplicate submission via session lock
        $lockKey = 'permohonan_submit_lock_' . me()->id;
        if (session($lockKey)) {
            return redirect($this->toIndex);
        }
        session([$lockKey => true]);

        // Check if same user already submitted same title in last 60 seconds
        $duplicate = $this->data::where('id_pemohon_0', me()->id)
            ->where('label', $request->label)
            ->where('created_at', '>=', now()->subSeconds(60))
            ->first();

        if ($duplicate) {
            session()->forget($lockKey);
            notify()->flash($this->tCreate, 'success');
            return redirect($this->toIndex);
        }

        $input = $request->all();
        $input['status'] = 0;
        $input['kode'] = kode(8);
        $input['slug'] = str_slug($request->label);
        $input['id_pemohon_0'] = me()->id;

        if ($request->hasFile('profil_bisnis')) {
            $input['profil_bisnis'] = $this->upload($request->file('profil_bisnis'));
        }

        if ($request->hasFile('anggaran')) {
            $input['anggaran'] = $this->upload($request->file('anggaran'));
        }

        // return $input;
        $permohonan = $this->data::create($input);
        $date = tgl_indo($permohonan->created_at);

        $pesan = <<<EOT
            *## JARSIPLUS Kota Samarinda ##*

            {$permohonan->pemohon1->name} baru saja menambahkan Inovasi baru.

            Judul : {$permohonan->label}
            Bidang Inovasi : {$permohonan->kategori->label}

            Nama :  {$permohonan->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$permohonan->pemohon1->unit_kerja}
               
            Mohon untuk segera melakukan tindakan yang diperlukan, Terima kasih.
            Pemerintah Kota Samarinda
            EOT;

        // Aktifkan notifikasi untuk semua
        send_group_whatsapp($pesan);

        session()->forget($lockKey);
        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    protected function hasCompleteIdentity()
    {
        $pemohon = me()->pemohon;

        if (!$pemohon) {
            return false;
        }

        foreach (['name', 'nik', 'nip', 'phone', 'email', 'unit_kerja', 'jabatan'] as $field) {
            if (trim((string) $pemohon->{$field}) === '') {
                return false;
            }
        }

        return true;
    }

    protected function redirectToBiodata()
    {
        notify()->flash('Silakan lengkapi dan simpan biodata terlebih dahulu sebelum mengajukan inovasi.', 'warning');
        return redirect()->route('settings.profile.index');
    }

    protected function canBypassDeadline()
    {
        return me() && in_array(me()->email, ['arifdwi@samarindakota.go.id', 'alfi.haryadi11@gmail.com']);
    }


    public function persetujuan(Request $request, $uuid)
    {
        $data = $this->data::where('uuid', $uuid)->firstOrFail();
        // return $data;
        return view("$this->view.penjadwalan.index", compact('data'));
    }

    public function kirim(Request $request, $id)
    {
        $data = $this->data->uuid($id)->firstOrFail();
        $input = $request->all();

        // return $input;
        $data->update($input);

        $date = tgl_indo($data->created_at);

        $number = $data->pemohon1->phone;

        $pesan = <<<EOT
            *## JARSIPLUS Kota Samarinda ##*

            Inovasi anda siap di review.

            Judul : {$data->label}
            Bidang Inovasi : {$data->kategori->label}

            Nama :  {$data->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$data->pemohon1->unit_kerja}
               
            Kami akan segera melihat dan mengevaluasi inovasi yang telah dikirimkan. Terima kasih telah mengirimkan kontribusi Anda, dan kami akan segera memberikan umpan balik setelah proses review selesai.

            Pemerintah Kota Samarinda
            EOT;

        send_whatshapp($number, $pesan);

        $pesan = <<<EOT
            *## JARSIPLUS Kota Samarinda ##*

            {$data->pemohon1->name} baru saja mengubah status menjadi siap review.

            Judul : {$data->label}
            Bidang Inovasi : {$data->kategori->label}

            Nama :  {$data->pemohon1->name}
            Tanggal : {$date}
            Instansi : {$data->pemohon1->unit_kerja}
               
            Mohon untuk segera melakukan tindakan yang diperlukan, Terima kasih.
            
            Pemerintah Kota Samarinda
            EOT;

        send_group_whatsapp($pesan);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);

    }


    public function upload($file)
    {
        $path = 'jarsiplus/permohonan/file/';
        $tmpFilePath = 'app/public/' . $path;
        $tmpFileDate = date('Y-m') . '/' . date('d') . '/';
        $tmpFileName = uniqid();
        $tmpFileExt = $file->getClientOriginalExtension();
        $file->move(storage_path() . '/' . $tmpFilePath . '/' . $tmpFileDate, $tmpFileName . '.' . $tmpFileExt);
        return "storage/{$path}{$tmpFileDate}/{$tmpFileName}.{$tmpFileExt}";
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
