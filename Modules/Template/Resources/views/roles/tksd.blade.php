{{-- Dashboard Tim Verifikator (TKSD) --}}
@php
    $meId = me() ? me()->id : auth()->id();

    // Dapatkan ID permohonan yang BENAR-BENAR pernah dibahas oleh verifikator saat ini
    $pembahasansMe = \Modules\Core\Entities\Pembahasan::where('id_operator', $meId)->get();
    $myDiscussedIds = [];

    foreach ($pembahasansMe as $pItem) {
        if (!empty($pItem->id_file)) {
            $file = \Modules\Formulir\Entities\DataDukung::find($pItem->id_file);
            if ($file) {
                $penilaian = \Modules\Formulir\Entities\Penilaian::find($file->inovasi_penilaian_id);
                if ($penilaian && $penilaian->inovasi_id) {
                    $myDiscussedIds[] = $penilaian->inovasi_id;
                }
            }
        }
        if (!empty($pItem->id_histori)) {
            $histori = \Modules\Core\Entities\Histori::find($pItem->id_histori);
            if ($histori) {
                if (!empty($histori->id_permohonan)) {
                    $penilaian = \Modules\Formulir\Entities\Penilaian::find($histori->id_permohonan);
                    if ($penilaian && $penilaian->inovasi_id) {
                        $myDiscussedIds[] = $penilaian->inovasi_id;
                    } else {
                        $myDiscussedIds[] = $histori->id_permohonan;
                    }
                }
                if (!empty($histori->id_file)) {
                    $file = \Modules\Formulir\Entities\DataDukung::find($histori->id_file);
                    if ($file) {
                        $penilaian = \Modules\Formulir\Entities\Penilaian::find($file->inovasi_penilaian_id);
                        if ($penilaian && $penilaian->inovasi_id) {
                            $myDiscussedIds[] = $penilaian->inovasi_id;
                        }
                    }
                }
            }
        }
        if (!empty($pItem->id_permohonan)) {
            $myDiscussedIds[] = $pItem->id_permohonan;
        }
    }

    $myDiscussedIds = array_values(array_unique(array_filter($myDiscussedIds)));

    $filterBahas = request('filter_bahas', 'semua');
    $keyword = request('search');

    // "Selesai" = seluruh berkas data dukung pada usulan sudah disetujui
    // (dan usulan tersebut memang punya berkas). Dihitung sekali lewat satu
    // query agregat, bukan per-kartu, agar tidak menambah beban query.
    $agregatBerkas = \Illuminate\Support\Facades\DB::table('permohonan_file')
        ->join('permohonan_penilaian', 'permohonan_file.inovasi_penilaian_id', '=', 'permohonan_penilaian.id')
        ->whereNotNull('permohonan_penilaian.inovasi_id')
        ->groupBy('permohonan_penilaian.inovasi_id')
        ->selectRaw('permohonan_penilaian.inovasi_id AS inovasi_id')
        ->selectRaw('COUNT(*) AS total')
        ->selectRaw('SUM(CASE WHEN permohonan_file.status = 1 THEN 1 ELSE 0 END) AS disetujui')
        ->get();

    $selesaiIds = $agregatBerkas
        ->filter(fn ($row) => $row->total > 0 && $row->disetujui == $row->total)
        ->pluck('inovasi_id')
        ->map(fn ($id) => (int) $id)
        ->values()
        ->all();

    // Query usulan yang berada dalam status pembahasan (1 = Menunggu Pembahasan, 2 = Proses Pembahasan, 4 = Pembahasan Ulang)
    $query = \Modules\Formulir\Entities\Permohonan::whereIn('status', [1, 2, 4]);

    if (!empty($keyword)) {
        $query->where(function($q) use ($keyword) {
            $q->where('kode', 'LIKE', "%{$keyword}%")
              ->orWhere('label', 'LIKE', "%{$keyword}%")
              ->orWhere('nama_inovasi', 'LIKE', "%{$keyword}%")
              ->orWhereHas('pemohon1', function($sub) use ($keyword) {
                  $sub->where('unit_kerja', 'LIKE', "%{$keyword}%");
              });
        });
    }

    if ($filterBahas === 'sudah') {
        $query->whereIn('id', !empty($myDiscussedIds) ? $myDiscussedIds : [-1]);
    } elseif ($filterBahas === 'belum') {
        $query->whereNotIn('id', $myDiscussedIds);
    } elseif ($filterBahas === 'selesai') {
        $query->whereIn('id', !empty($selesaiIds) ? $selesaiIds : [-1]);
    }

    // Dipaginasi: satu halaman bisa berisi puluhan usulan sehingga
    // menampilkan semuanya sekaligus membuat halaman sangat panjang & berat.
    $perPage = (int) request('per_page', 12);
    $perPage = in_array($perPage, [12, 24, 48]) ? $perPage : 12;

    $permohonanList = $query->latest()->paginate($perPage)->appends(request()->query());

    $countSemua = \Modules\Formulir\Entities\Permohonan::whereIn('status', [1, 2, 4])->count();
    $countSudah = \Modules\Formulir\Entities\Permohonan::whereIn('status', [1, 2, 4])
                    ->whereIn('id', !empty($myDiscussedIds) ? $myDiscussedIds : [-1])->count();
    $countBelum = \Modules\Formulir\Entities\Permohonan::whereIn('status', [1, 2, 4])
                    ->whereNotIn('id', $myDiscussedIds)->count();
    $countSelesai = \Modules\Formulir\Entities\Permohonan::whereIn('status', [1, 2, 4])
                    ->whereIn('id', !empty($selesaiIds) ? $selesaiIds : [-1])->count();

    $filterLabel = [
        'sudah'   => 'Sudah Pernah Dibahas',
        'belum'   => 'Belum Dibahas',
        'selesai' => 'Selesai — Semua Berkas Disetujui',
    ][$filterBahas] ?? 'Semua Dalam Pembahasan';
@endphp

{{-- Ringkasan beban kerja verifikator --}}
<div class="l-grid l-grid--4 u-mb-lg">
    <x-stat-tile label="Total Dalam Pembahasan" :value="number_format($countSemua)"  icon="folder"       accent="var(--c-accent)" />
    <x-stat-tile label="Belum Anda Bahas"       :value="number_format($countBelum)"  icon="clock"        accent="var(--c-amber)" />
    <x-stat-tile label="Sudah Anda Bahas"       :value="number_format($countSudah)"  icon="chat"         accent="var(--c-sky)" />
    <x-stat-tile label="Berkas Selesai"         :value="number_format($countSelesai)" icon="check-circle" accent="var(--c-success)" />
</div>

{{-- Penyaring & pencarian.
     Dipisah dua baris: dengan empat pill, satu baris membuat kolom pencarian
     terhimpit dan tombol Cari terdorong turun. --}}
<form method="GET" action="{{ url()->current() }}" class="jp-filter-bar u-mb-lg">
    <div class="jp-pill-group jp-filter-bar__filters">
        <a href="{{ url()->current() }}?filter_bahas=semua{{ $keyword ? '&search='.$keyword : '' }}"
           class="jp-pill {{ $filterBahas === 'semua' ? 'is-active' : '' }}">
            Semua Dalam Pembahasan
            <span class="jp-pill__count">{{ $countSemua }}</span>
        </a>
        <a href="{{ url()->current() }}?filter_bahas=belum{{ $keyword ? '&search='.$keyword : '' }}"
           class="jp-pill {{ $filterBahas === 'belum' ? 'is-active is-active--amber' : '' }}">
            Belum Dibahas
            <span class="jp-pill__count">{{ $countBelum }}</span>
        </a>
        <a href="{{ url()->current() }}?filter_bahas=sudah{{ $keyword ? '&search='.$keyword : '' }}"
           class="jp-pill {{ $filterBahas === 'sudah' ? 'is-active' : '' }}">
            Sudah Dibahas
            <span class="jp-pill__count">{{ $countSudah }}</span>
        </a>

        <a href="{{ url()->current() }}?filter_bahas=selesai{{ $keyword ? '&search='.$keyword : '' }}"
           class="jp-pill {{ $filterBahas === 'selesai' ? 'is-active is-active--success' : '' }}"
           title="Seluruh berkas data dukung pada usulan sudah disetujui">
            Selesai
            <span class="jp-pill__count">{{ $countSelesai }}</span>
        </a>
    </div>

    <div class="jp-filter-bar__controls">
        <input type="hidden" name="filter_bahas" value="{{ $filterBahas }}">

        <label for="tksdSearch" class="u-sr-only">Cari usulan inovasi</label>
        <input type="text" id="tksdSearch" name="search" value="{{ $keyword }}" class="jp-input jp-input--sm"
               style="flex: 1 1 220px; min-width: 0;"
               placeholder="Cari kode, nama usulan, atau OPD…">

        <label for="tksdPerPage" class="u-sr-only">Jumlah per halaman</label>
        <select name="per_page" id="tksdPerPage" class="jp-input jp-input--sm no-select2"
                style="flex: 0 0 auto; width: auto;" onchange="this.form.submit()">
            @foreach([12, 24, 48] as $opt)
                <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>{{ $opt }}/hal</option>
            @endforeach
        </select>

        <button type="submit" class="jp-btn jp-btn--accent jp-btn--sm">
            <x-icon name="search" size="14" />
            Cari
        </button>

        @if(!empty($keyword))
            <a href="{{ url()->current() }}?filter_bahas={{ $filterBahas }}" class="jp-btn jp-btn--quiet jp-btn--sm">Reset</a>
        @endif
    </div>
</form>

{{-- Judul daftar --}}
<div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-sm u-mb-lg">
    <div>
        <h2 class="jp-section__title u-mb-0">Daftar Usulan Inovasi Dalam Pembahasan</h2>
        <p class="jp-section__desc">
            Tinjau &amp; berikan pembahasan pada usulan inovasi aktif.
            Filter aktif: <strong class="text-accent">{{ $filterLabel }}</strong>
            @if(!empty($keyword)) &middot; kata kunci “<strong>{{ $keyword }}</strong>” @endif
        </p>
    </div>

    @if($permohonanList->total() > 0)
        <span class="jp-badge jp-badge--neutral font-mono">
            {{ $permohonanList->firstItem() }}–{{ $permohonanList->lastItem() }} dari {{ $permohonanList->total() }}
        </span>
    @endif
</div>

{{-- total(), bukan count(): count() hanya menghitung isi halaman ini, sehingga
     nomor halaman di luar jangkauan akan salah dianggap "tidak ada data". --}}
@if($permohonanList->total() > 0)
    <div class="l-grid l-grid--auto">
        @foreach($permohonanList as $value)
            @php
                $isDiscussed = in_array($value->id, $myDiscussedIds);
                $penilaiansList = \Modules\Formulir\Entities\Penilaian::where('inovasi_id', $value->id)->get();

                $approvedInd = 0;
                $totalFiles = 0;
                $approvedFiles = 0;

                foreach ($penilaiansList as $pItem) {
                    $fCount = $pItem->files ? $pItem->files->count() : 0;
                    $fApp = $pItem->files ? $pItem->files->where('status', 1)->count() : 0;
                    $totalFiles += $fCount;
                    $approvedFiles += $fApp;
                    if (($pItem->parameter_id && $pItem->bobot) || ($fCount > 0 && $fApp == $fCount)) {
                        $approvedInd++;
                    }
                }

                if ($approvedInd == 20 || ($totalFiles > 0 && $approvedFiles == $totalFiles)) {
                    $statusBadgeClass = 'jp-badge--success';
                    $statusBadgeLabel = 'SUDAH DIBAHAS';
                    $cardTone = 'jp-record-card--success';
                    $meterTone = 'jp-meter__fill--success';
                } elseif ($approvedInd > 0 || $approvedFiles > 0) {
                    $statusBadgeClass = 'jp-badge--accent';
                    $statusBadgeLabel = 'PROSES DIBAHAS';
                    $cardTone = 'jp-record-card--accent';
                    $meterTone = '';
                } elseif ($isDiscussed) {
                    $statusBadgeClass = 'jp-badge--accent';
                    $statusBadgeLabel = 'SUDAH DIBAHAS';
                    $cardTone = 'jp-record-card--accent';
                    $meterTone = '';
                } else {
                    $statusBadgeClass = 'jp-badge--amber';
                    $statusBadgeLabel = 'BELUM DIBAHAS';
                    $cardTone = 'jp-record-card--amber';
                    $meterTone = 'jp-meter__fill--amber';
                }

                $indPercent = min(100, round(($approvedInd / 20) * 100));
                $judulUsulan = $value->label ?? $value->nama_inovasi ?? $value->kode;
                $opdUsulan = jp_isi(optional($value->pemohon1)->unit_kerja ?? $value->pemohon->unit_kerja ?? null);
            @endphp

            <article class="jp-record-card {{ $cardTone }}">
                <header class="jp-record-card__head">
                    <span class="jp-record-card__code">{{ $value->kode }}</span>
                    <span class="jp-badge {{ $statusBadgeClass }}">{{ $statusBadgeLabel }}</span>
                </header>

                <div class="jp-record-card__body">
                    <h3 class="jp-record-card__title jp-clamp-2">
                        <a href="{{ route('permohonan.indikator.index', $value->uuid) }}" title="{{ $judulUsulan }}">
                            {{ $judulUsulan }}
                        </a>
                    </h3>

                    <div class="jp-record-card__meta">
                        <x-icon name="building" size="14" style="color: var(--c-ink-subtle);" />
                        <span class="u-truncate">{{ $opdUsulan ?? 'Instansi belum dicantumkan' }}</span>
                    </div>

                    <div class="jp-record-card__meta">
                        <x-icon name="calendar" size="14" style="color: var(--c-ink-subtle);" />
                        <span class="font-mono">{{ $value->created_at ? $value->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}</span>
                    </div>

                    {{-- Progres indikator & berkas --}}
                    <div class="u-mt-xs">
                        <div class="u-flex u-justify-between u-align-center u-gap-sm u-mb-2xs">
                            <span style="font-size: var(--t-xs); color: var(--c-ink-muted);">
                                Indikator disetujui
                            </span>
                            <strong class="font-mono" style="font-size: var(--t-xs); color: var(--c-ink);">
                                {{ $approvedInd }}/20
                            </strong>
                        </div>
                        <div class="jp-meter">
                            <div class="jp-meter__fill {{ $meterTone }}" style="width: {{ $indPercent }}%;"></div>
                        </div>

                        <div class="u-flex u-justify-between u-align-center u-gap-sm u-mt-xs">
                            <span style="font-size: var(--t-xs); color: var(--c-ink-muted);">Berkas disetujui</span>
                            <strong class="font-mono" style="font-size: var(--t-xs); color: var(--c-ink);">
                                {{ $approvedFiles }}/{{ $totalFiles }}
                            </strong>
                        </div>
                    </div>
                </div>

                <footer class="jp-record-card__foot">
                    <button type="button" class="jp-btn jp-btn--ghost jp-btn--sm"
                            onclick="document.getElementById('modalDetailPermohonan-{{ $value->uuid }}').showModal()">
                        <x-icon name="document" size="14" />
                        Detail
                    </button>
                    <a href="{{ route('permohonan.indikator.index', $value->uuid) }}" class="jp-btn jp-btn--accent jp-btn--sm">
                        Tinjau Indikator <span aria-hidden="true">&rarr;</span>
                    </a>
                </footer>
            </article>

            {{-- MODAL DETAIL PERMOHONAN --}}
            @php
                $mapTahapan = [1 => 'Inisiatif', 2 => 'Uji Coba', 3 => 'Penerapan'];
                $mapInisiator = [1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'OPD', 4 => 'ASN', 5 => 'Masyarakat'];
                $mapJenis = [1 => 'Digital', 2 => 'Non Digital'];

                $modalTahapanLabel = $mapTahapan[$value->tahapan] ?? ($value->tahapan ?? null);
                $modalInisiatorLabel = $mapInisiator[$value->inisiator] ?? ($value->inisiator ?? null);
                $modalJenisLabel = $mapJenis[$value->jenis] ?? ($value->jenis ?? null);
                $modalKategoriLabel = optional($value->kategori)->label ?? optional($value->kategori)->nama ?? ($value->kategori_label ?? null);

                $detailRows = [
                    'Instansi / OPD'    => $value->nama_instansi ?? $opdUsulan,
                    'Urusan Utama'      => $value->urusan_utama ?? $value->urusan ?? null,
                    'Kategori'          => $modalKategoriLabel,
                    'Jenis Inovasi'     => $modalJenisLabel,
                    'Inisiator Inovasi' => $modalInisiatorLabel,
                    'Tahapan Inovasi'   => $modalTahapanLabel,
                    'Waktu Uji Coba'    => $value->waktu_uji ? \Carbon\Carbon::parse($value->waktu_uji)->format('d/m/Y') : null,
                    'Waktu Penerapan'   => $value->waktu_penerapan ? \Carbon\Carbon::parse($value->waktu_penerapan)->format('d/m/Y') : null,
                ];

                $petugasRows = [
                    'Nama Petugas' => optional($value->pemohon1)->name,
                    'Jabatan'      => optional($value->pemohon1)->jabatan,
                    'No. HP / WA'  => optional($value->pemohon1)->phone,
                    'Email'        => optional($value->pemohon1)->email,
                ];

                $narasiRows = [
                    'Rancang Bangun & Pokok Perubahan' => $value->rancang_bangun ?? $value->rancang_bangun_inovasi ?? $value->deskripsi ?? null,
                    'Tujuan Inovasi'                   => $value->tujuan_inovasi ?? $value->tujuan ?? null,
                    'Manfaat Inovasi'                  => $value->manfaat_inovasi ?? $value->manfaat ?? null,
                    'Hasil Inovasi'                    => $value->hasil_inovasi ?? $value->hasil ?? null,
                ];
            @endphp

            <dialog id="modalDetailPermohonan-{{ $value->uuid }}" class="jp-modal jp-modal--lg">
                <div class="jp-modal__head">
                    <div class="u-flex u-align-center u-gap-sm" style="min-width: 0;">
                        <span class="jp-modal__icon"><x-icon name="document" size="22" /></span>
                        <div style="min-width: 0;">
                            <span class="font-mono jp-modal__eyebrow">KODE: {{ $value->kode }}</span>
                            <h3 class="jp-modal__title">Detail Usulan Inovasi</h3>
                        </div>
                    </div>
                    <button type="button" class="jp-modal__close" aria-label="Tutup"
                            onclick="document.getElementById('modalDetailPermohonan-{{ $value->uuid }}').close()">
                        <x-icon name="close" size="22" />
                    </button>
                </div>

                <div class="jp-modal__body">
                    <section class="u-mb-lg">
                        <span class="jp-badge jp-badge--accent u-mb-xs">DATA UMUM INOVASI</span>
                        <h2 style="font-size: var(--t-2xl); margin: 6px 0 12px;">{{ $judulUsulan }}</h2>

                        <div class="jp-deflist jp-deflist--2">
                            @foreach($detailRows as $label => $val)
                                <div class="jp-deflist__row">
                                    <span class="jp-deflist__label">{{ $label }}</span>
                                    <span class="jp-deflist__value">
                                        @if(filled($val)){{ $val }}@else<span class="jp-value-empty"></span>@endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="u-mb-lg">
                        <span class="jp-badge jp-badge--amber u-mb-sm">PETUGAS INOVASI / PEMOHON</span>
                        <div class="jp-deflist jp-deflist--2 u-mt-xs">
                            @foreach($petugasRows as $label => $val)
                                <div class="jp-deflist__row">
                                    <span class="jp-deflist__label">{{ $label }}</span>
                                    <span class="jp-deflist__value">
                                        @if(filled($val)){{ $val }}@else<span class="jp-value-empty"></span>@endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section>
                        <span class="jp-badge jp-badge--success u-mb-sm">DESKRIPSI &amp; RANCANG BANGUN</span>
                        <div class="u-flex u-flex-col u-gap-md u-mt-xs">
                            @foreach($narasiRows as $label => $val)
                                <div>
                                    <strong class="jp-deflist__label u-block u-mb-2xs">{{ $label }}</strong>
                                    <p class="jp-prose {{ filled($val) ? '' : 'jp-prose--empty' }}">
                                        @if(filled($val)){!! nl2br(e($val)) !!}@else Belum diisi oleh pemohon. @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="jp-modal__foot">
                    <button type="button" class="jp-btn jp-btn--ghost"
                            onclick="document.getElementById('modalDetailPermohonan-{{ $value->uuid }}').close()">
                        Tutup
                    </button>
                    <a href="{{ route('permohonan.indikator.index', $value->uuid) }}" class="jp-btn jp-btn--accent">
                        Lanjut Tinjau Indikator <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </dialog>
        @endforeach
    </div>

    {{ $permohonanList->links('vendor.pagination.bootstrap-4') }}
@else
    <x-empty
        icon="folder"
        title="Tidak ada usulan pada filter ini"
        :desc="!empty($keyword)
            ? 'Tidak ditemukan usulan yang cocok dengan kata kunci “' . $keyword . '”. Coba kata kunci lain atau ubah filter.'
            : ($filterBahas === 'selesai'
                ? 'Belum ada usulan yang seluruh berkas data dukungnya disetujui.'
                : 'Belum ada usulan inovasi yang masuk tahap pembahasan untuk filter yang dipilih.')"
    >
        @if(!empty($keyword) || $filterBahas !== 'semua')
            <a href="{{ url()->current() }}" class="jp-btn jp-btn--ghost u-mt-sm">Tampilkan Semua Usulan</a>
        @endif
    </x-empty>
@endif
