@extends('template::layouts.master')

@section('title', 'Daftar Permohonan Inovasi — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $is_closed = pendaftaran_permohonan_ditutup();
    $is_arif = Nue::user() && in_array(Nue::user()->email, ['arifdwi@samarindakota.go.id', 'alfi.haryadi11@gmail.com']);

    $totalCount = $data->count();
    $validasiCount = $data->where('status', 0)->count();
    $pembahasanCount = $data->whereIn('status', [1, 2])->count();
    $selesaiCount = $data->where('status', 4)->count();

    $hasFilter = request()->filled('keyword') || (request()->filled('status') && request('status') !== 'all');

    // Controller mengirim seluruh koleksi (dipakai untuk ringkasan angka di atas),
    // jadi paginasi disusun di sini agar hitungan ringkasan tetap utuh.
    $perPage = (int) request('per_page', 12);
    $perPage = in_array($perPage, [12, 24, 48]) ? $perPage : 12;

    $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
    $pagedData = new \Illuminate\Pagination\LengthAwarePaginator(
        $data->forPage($currentPage, $perPage)->values(),
        $totalCount,
        $perPage,
        $currentPage,
        ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => request()->query()]
    );
@endphp

<x-page-header
    badge="PORTAL INOVATOR"
    title="Daftar Permohonan Inovasi"
    desc="Kelola seluruh usulan inovasi daerah Anda dan lacak progres verifikasi TKSD."
>
    @if((!$is_closed || $is_arif) && $identityComplete)
        <a href="{{ route('permohonan.create') }}" class="jp-btn jp-btn--accent">
            <x-icon name="document" size="18" />
            Buat Usulan Inovasi Baru
        </a>
    @endif
</x-page-header>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        @if(!$identityComplete)
            <div class="jp-notice jp-notice--amber u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="alert-triangle" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Profil diri &amp; instansi belum lengkap</strong>
                    <p class="jp-notice__text">
                        Lengkapi seluruh data diri pemohon dan profil instansi Anda 100% terlebih dahulu untuk mengaktifkan pengajuan inovasi baru.
                    </p>
                </div>
                <div class="jp-notice__action">
                    <a href="{{ route('settings.profile.index') }}" class="jp-btn jp-btn--accent">
                        Lengkapi Profil Sekarang <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        @endif

        @if($is_closed && !$is_arif)
            <div class="jp-notice jp-notice--danger u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="lock" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Pendaftaran ditutup</strong>
                    <p class="jp-notice__text">{{ pendaftaran_inovasi_pesan_tutup() }}</p>
                </div>
            </div>
        @endif

        {{-- Ringkasan status --}}
        <div class="l-grid l-grid--4 u-mb-lg">
            <x-stat-tile label="Total Usulan"        :value="$totalCount"      icon="folder"       accent="var(--c-accent)" />
            <x-stat-tile label="Menunggu Validasi"   :value="$validasiCount"   icon="clock"        accent="var(--c-amber)" />
            <x-stat-tile label="Dalam Pembahasan"    :value="$pembahasanCount" icon="chat"         accent="var(--c-sky)" />
            <x-stat-tile label="Selesai / Evaluasi"  :value="$selesaiCount"    icon="check-circle" accent="var(--c-success)" />
        </div>

        {{-- Filter & pencarian --}}
        <form action="{{ route('permohonan.index') }}" method="GET" class="jp-card u-mb-xl">
            <div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-sm u-mb-md">
                <strong class="u-flex u-align-center u-gap-xs" style="font-size: var(--t-sm); color: var(--c-ink);">
                    <x-icon name="filter" size="18" style="color: var(--c-accent);" />
                    Filter &amp; Pencarian Inovasi
                </strong>
                @if($hasFilter)
                    <a href="{{ route('permohonan.index') }}" class="jp-btn jp-btn--quiet jp-btn--sm text-danger">
                        <x-icon name="close" size="14" />
                        Reset Filter
                    </a>
                @endif
            </div>

            <div class="u-flex u-gap-sm u-flex-wrap u-align-center">
                <div style="flex: 2 1 260px; min-width: 0;">
                    <label for="filterKeyword" class="u-sr-only">Kata kunci</label>
                    <input type="text" id="filterKeyword" name="keyword" class="jp-input" value="{{ request('keyword') }}"
                           placeholder="Cari kode, nama inovasi, atau instansi…">
                </div>

                <div style="flex: 1 1 190px; min-width: 0;">
                    <label for="filterStatus" class="u-sr-only">Status</label>
                    <select name="status" id="filterStatus" class="jp-input">
                        <option value="all">-- Semua Status --</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Menunggu Validasi (0)</option>
                        <option value="pembahasan" {{ request('status') === 'pembahasan' ? 'selected' : '' }}>Dalam Pembahasan (1-2)</option>
                        <option value="4" {{ request('status') === '4' ? 'selected' : '' }}>Selesai / Evaluasi (4)</option>
                        <option value="9" {{ request('status') === '9' ? 'selected' : '' }}>Ditolak (9)</option>
                    </select>
                </div>

                <div style="flex: 0 0 auto;">
                    <label for="filterPerPage" class="u-sr-only">Jumlah per halaman</label>
                    <select name="per_page" id="filterPerPage" class="jp-input no-select2" style="width: auto;">
                        @foreach([12, 24, 48] as $opt)
                            <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>{{ $opt }} / halaman</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="jp-btn jp-btn--accent">
                    <x-icon name="search" size="16" />
                    Cari &amp; Filter
                </button>
            </div>
        </form>

        {{-- Daftar permohonan --}}
        @if($data && count($data) > 0)
            <div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-sm u-mb-md">
                <h2 class="jp-section__title u-mb-0" style="font-size: var(--t-xl);">Daftar Usulan</h2>
                <span class="jp-badge jp-badge--neutral font-mono">
                    {{ $pagedData->firstItem() }}–{{ $pagedData->lastItem() }} dari {{ $totalCount }}
                </span>
            </div>

            <div class="l-grid l-grid--3">
                @foreach($pagedData as $item)
                    @php
                        if ($item->status == 0) {
                            $cardTone = 'jp-record-card--amber';
                            $badgeClass = 'jp-badge--amber';
                            $badgeLabel = 'MENUNGGU VALIDASI';
                        } elseif ($item->status == 1 || $item->status == 2) {
                            $cardTone = 'jp-record-card--accent';
                            $badgeClass = 'jp-badge--accent';
                            $badgeLabel = 'PEMBAHASAN';
                        } elseif ($item->status == 4) {
                            $cardTone = 'jp-record-card--success';
                            $badgeClass = 'jp-badge--success';
                            $badgeLabel = 'SELESAI';
                        } elseif ($item->status == 9) {
                            $cardTone = 'jp-record-card--danger';
                            $badgeClass = 'jp-badge--danger';
                            $badgeLabel = 'DITOLAK';
                        } else {
                            $cardTone = 'jp-record-card--neutral';
                            $badgeClass = 'jp-badge--neutral';
                            $badgeLabel = 'DRAF';
                        }

                        $judul = $item->label ?? $item->nama_inovasi ?? $item->kode;
                        $opd = jp_isi(optional($item->pemohon1)->unit_kerja);
                    @endphp

                    <article class="jp-record-card {{ $cardTone }}">
                        <header class="jp-record-card__head">
                            <span class="jp-record-card__code">{{ $item->kode }}</span>
                            <span class="jp-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </header>

                        <div class="jp-record-card__body">
                            <h3 class="jp-record-card__title jp-clamp-2">
                                <a href="{{ route('permohonan.show', $item->kode) }}">{{ $judul }}</a>
                            </h3>

                            @if($item->kategori)
                                <span class="jp-badge jp-badge--neutral u-self-start">{{ $item->kategori->label ?? 'Kategori belum ditetapkan' }}</span>
                            @endif

                            <div class="jp-record-card__meta u-mt-2xs">
                                <x-icon name="building" size="14" style="color: var(--c-ink-subtle);" />
                                <span class="u-truncate">{{ $opd ?? 'Instansi belum dicantumkan' }}</span>
                            </div>

                            <div class="jp-record-card__meta">
                                <x-icon name="calendar" size="14" style="color: var(--c-ink-subtle);" />
                                <span class="font-mono">{{ $item->created_at ? $item->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}</span>
                            </div>
                        </div>

                        <footer class="jp-record-card__foot">
                            <a href="{{ route('permohonan.show', $item->kode) }}" class="jp-btn jp-btn--accent jp-btn--sm">
                                Kelola Berkas &amp; Rincian
                                <x-icon name="chevron-right" size="14" />
                            </a>
                        </footer>
                    </article>
                @endforeach
            </div>

            {{ $pagedData->links('vendor.pagination.bootstrap-4') }}
        @elseif($hasFilter)
            {{-- Kosong karena filter --}}
            <x-empty
                icon="search"
                title="Tidak ada permohonan yang cocok"
                desc="Tidak ditemukan usulan dengan kata kunci atau status yang Anda pilih. Coba ubah kata kunci atau tampilkan semua status."
            >
                <a href="{{ route('permohonan.index') }}" class="jp-btn jp-btn--ghost u-mt-sm">Tampilkan Semua Permohonan</a>
            </x-empty>
        @else
            {{-- Kosong karena belum ada data sama sekali --}}
            <x-empty
                icon="document"
                title="Belum ada permohonan inovasi"
                desc="Anda belum pernah mengajukan usulan inovasi. Mulai dari satu ide, lalu lengkapi formulir Segment 1–3 dan berkas pendukungnya."
            >
                @if((!$is_closed || $is_arif) && $identityComplete)
                    <a href="{{ route('permohonan.create') }}" class="jp-btn jp-btn--accent u-mt-sm">
                        <x-icon name="document" size="16" />
                        Buat Usulan Inovasi Baru
                    </a>
                @elseif(!$identityComplete)
                    <a href="{{ route('settings.profile.index') }}" class="jp-btn jp-btn--accent u-mt-sm">
                        Lengkapi Profil Terlebih Dahulu <span aria-hidden="true">&rarr;</span>
                    </a>
                @endif
            </x-empty>
        @endif

    </div>
</div>
@endsection
