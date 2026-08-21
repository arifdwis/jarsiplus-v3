<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;

use App\Models\User;
use Modules\Formulir\Entities\Permohonan;
use Modules\Formulir\Entities\Indikator;
use Modules\Core\Entities\Histori;
use Modules\Core\Entities\Penilaian;
use Modules\Core\Entities\Penjadwalan;
use Modules\Pemohon\Entities\Pemohon;
use Modules\Pemohon\Entities\Corporate;
use App\Observers\HistoriObserver;
use App\Observers\PenilaianObserver;


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
        $this->tCreate = "Permohonan usulan inovasi berhasil dibuat!";
        $this->tUpdate = "Permohonan usulan inovasi berhasil diperbarui!";

        view()->share([
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }

    public function index(Request $request)
    {
        $query = $this->data::query();

        if (role_me() == 4) {
            $pemohonId = optional(me()->pemohon)->id;
            $query->where(function($q) use ($pemohonId) {
                $q->where('id_pemohon_0', me()->id);
                if ($pemohonId) {
                    $q->orWhere('id_pemohon_1', $pemohonId);
                }
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'pembahasan') {
                $query->whereIn('status', [1, 2]);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('keyword')) {
            $kw = trim($request->keyword);
            $query->where(function($q) use ($kw) {
                $q->where('kode', 'like', "%{$kw}%")
                  ->orWhere('label', 'like', "%{$kw}%")
                  ->orWhereHas('pemohon1', function($sub) use ($kw) {
                      $sub->where('name', 'like', "%{$kw}%")
                          ->orWhere('unit_kerja', 'like', "%{$kw}%");
                  });
            });
        }

        $data = $query->latest()->get();
        $identityComplete = $this->hasCompleteIdentity();

        return view("$this->view.index", compact('data', 'identityComplete'));
    }

    public function create(Request $request)
    {
        if (!$this->hasCompleteIdentity()) {
            return $this->redirectToBiodata();
        }

        if (!$this->canBypassDeadline() && pendaftaran_permohonan_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect($this->toIndex);
        }

        $provinsis = class_exists('\Modules\Wilayah\Entities\Provinsi') ? \Modules\Wilayah\Entities\Provinsi::with('citys')->orderBy('name','asc')->get() : collect([]);
        $kategoris = class_exists('\Modules\Formulir\Entities\Kategori') ? \Modules\Formulir\Entities\Kategori::all() : (class_exists('\Modules\Formulir\Entities\UrusanKategori') ? \Modules\Formulir\Entities\UrusanKategori::all() : collect([]));
        $urusans = class_exists('\Modules\Formulir\Entities\Urusan') ? \Modules\Formulir\Entities\Urusan::all() : collect([]);

        return view("$this->view.create", compact('provinsis', 'kategoris', 'urusans'));
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

        $turnstileToken = $request->input('cf-turnstile-response');
        $turnstileSecret = config('services.cloudflare.turnstile.secret_key');
        if (!$turnstileToken || !$turnstileSecret) {
            return back()->withInput()->withErrors(['turnstile' => 'Verifikasi keamanan wajib diselesaikan sebelum pengajuan dikirim.']);
        }
        try {
            $turnstile = Http::asForm()->timeout(8)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $turnstileSecret, 'response' => $turnstileToken, 'remoteip' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->withErrors(['turnstile' => 'Verifikasi keamanan sedang tidak tersedia. Silakan coba lagi.']);
        }
        if (!$turnstile->successful() || !$turnstile->json('success')) {
            return back()->withInput()->withErrors(['turnstile' => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
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

        send_group_whatsapp($pesan);

        session()->forget($lockKey);
        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    protected function hasCompleteIdentity()
    {
        $pemohon = me()->pemohon;
        $corporate = Corporate::where('id_operator', me()->id)->first();

        if (!$pemohon || !$corporate) {
            return false;
        }

        // Mandatory Pemohon fields
        foreach (['name', 'nik', 'phone', 'email', 'unit_kerja', 'jabatan', 'address'] as $field) {
            if (trim((string) $pemohon->{$field}) === '') {
                return false;
            }
        }

        // Mandatory Corporate fields
        foreach (['name', 'email', 'phone', 'address'] as $field) {
            if (trim((string) $corporate->{$field}) === '') {
                return false;
            }
        }

        return true;
    }

    protected function redirectToBiodata()
    {
        notify()->flash('Harap lengkapi 100% Profil Diri dan Data Instansi Anda di bawah ini terlebih dahulu sebelum membuat usulan inovasi baru.', 'warning');
        return redirect()->route('settings.profile.index');
    }

    protected function canBypassDeadline()
    {
        return me() && in_array(me()->email, ['arifdwi@samarindakota.go.id', 'alfi.haryadi11@gmail.com']);
    }

    public function persetujuan(Request $request, $uuid)
    {
        $data = $this->data::where('uuid', $uuid)->firstOrFail();
        $parent = $data;
        return view("$this->view.penjadwalan.index", compact('data', 'parent'));
    }

    public function kirim(Request $request, $id)
    {
        $data = $this->data::where('uuid', $id)->first() ?? $this->data::findOrFail($id);
        $input = $request->all();

        // Update status to 2 (Submitted / Menunggu Penilaian TKSD)
        $input['status'] = 2;
        $data->update($input);

        // Record in Histori Log
        HistoriObserver::create([
            'id_permohonan' => $data->id,
            'deskripsi' => 'Berkas usulan inovasi telah resmi dikirimkan oleh pemohon untuk dinilai oleh Tim Verifikator.',
            'status' => 2
        ]);

        $date = tgl_indo($data->created_at);
        $number = optional($data->pemohon1)->phone;

        if ($number) {
            $pesan = <<<EOT
                *## JARSIPLUS Kota Samarinda ##*

                Inovasi anda siap di review.

                Judul : {$data->label}
                Bidang Inovasi : {$data->kategori->label}

                Nama :  {$data->pemohon1->name}
                Tanggal : {$date}
                Instansi : {$data->pemohon1->unit_kerja}
                   
                Kami akan segera melihat dan mengevaluasi inovasi yang telah dikirimkan. Terima kasih telah mengirimkan kontribusi Anda.

                Pemerintah Kota Samarinda
                EOT;

            try {
                send_whatshapp($number, $pesan);
            } catch (\Throwable $e) {}
        }

        notify()->flash('Berkas usulan inovasi telah berhasil dikirimkan ke Tim Verifikator untuk dinilai.', 'success');
        return redirect()->route('permohonan.show', $data->kode);
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

            return $matched;
        } catch (\Throwable $e) {
            return [];
        }
    }
}
