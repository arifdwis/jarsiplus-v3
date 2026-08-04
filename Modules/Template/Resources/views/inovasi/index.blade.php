@extends('template::layouts.master')

@section('title', 'Katalog Inovasi Daerah — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php $sedangMencari = request()->filled('keyword'); @endphp

<x-page-header
    badge="KATALOG INOVASI DAERAH"
    title="Inovasi Terdaftar & Tervalidasi"
    desc="Kumpulan hasil inovasi Perangkat Daerah, UPTD, dan masyarakat Kota Samarinda."
>
    <form action="{{ route('inovasi.index') }}" method="GET" class="jp-searchbar" style="min-width: 280px;">
        <label for="cariInovasi" class="u-sr-only">Cari inovasi</label>
        <input type="text" id="cariInovasi" name="keyword" class="jp-input" placeholder="Cari judul, urusan, atau OPD…" value="{{ request('keyword') }}">
        <button type="submit" class="jp-btn jp-btn--accent">Cari</button>
    </form>
</x-page-header>

@if($sedangMencari)
    <div class="jp-subhead">
        <div class="l-container jp-subhead__inner">
            <span class="jp-subhead__meta">
                Hasil pencarian untuk “<strong>{{ request('keyword') }}</strong>” — {{ $data->total() }} inovasi
            </span>
            <a href="{{ route('inovasi.index') }}" class="jp-link-arrow" style="font-size: var(--t-xs);">Hapus pencarian</a>
        </div>
    </div>
@endif

<div class="jp-section jp-section--sm">
    <div class="l-container">
        @if($data->total() > 0)
            <div class="l-grid l-grid--3">
                @foreach($data as $inovasi)
                    @php
                        $kategoriNama = optional($inovasi->kategori)->label ?? $inovasi->urusan_utama ?? null;
                        $opdNama = jp_isi(optional($inovasi->pemohon1)->unit_kerja);
                        $ringkas = trim(strip_tags((string) ($inovasi->rancang_bangun ?? $inovasi->tujuan_inovasi ?? '')));
                        $selesai = $inovasi->status == 4;
                    @endphp

                    <article class="jp-record-card {{ $selesai ? 'jp-record-card--success' : 'jp-record-card--accent' }}">
                        <header class="jp-record-card__head">
                            <span class="jp-badge jp-badge--neutral u-truncate" style="max-width: 62%;">
                                {{ $kategoriNama ?? 'Inovasi Daerah' }}
                            </span>
                            <span class="jp-badge {{ $selesai ? 'jp-badge--success' : 'jp-badge--accent' }}">
                                {{ $selesai ? 'Tervalidasi' : 'Pembahasan' }}
                            </span>
                        </header>

                        <div class="jp-record-card__body">
                            <h3 class="jp-record-card__title jp-clamp-2">
                                <a href="{{ route('inovasi.show', $inovasi->uuid) }}">{{ $inovasi->label }}</a>
                            </h3>

                            <div class="jp-record-card__meta">
                                <x-icon name="building" size="14" style="color: var(--c-ink-subtle);" />
                                <span class="u-truncate">{{ $opdNama ?? 'Instansi belum dicantumkan' }}</span>
                            </div>

                            <p class="jp-card__text jp-clamp-3">
                                {{ $ringkas !== '' ? Str::limit($ringkas, 120) : 'Deskripsi inovasi belum tersedia.' }}
                            </p>
                        </div>

                        <footer class="jp-record-card__foot u-justify-between">
                            <span class="font-mono" style="font-size: var(--t-2xs); color: var(--c-ink-subtle);">
                                Tahun {{ $inovasi->tahun ?? ($inovasi->created_at ? $inovasi->created_at->format('Y') : '—') }}
                            </span>
                            <a href="{{ route('inovasi.show', $inovasi->uuid) }}" class="jp-link-arrow" style="font-size: var(--t-xs);">
                                Detail <span aria-hidden="true">&rarr;</span>
                            </a>
                        </footer>
                    </article>
                @endforeach
            </div>

            {{ $data->links('vendor.pagination.bootstrap-4') }}
        @elseif($sedangMencari)
            <x-empty
                icon="search"
                title="Inovasi tidak ditemukan"
                desc="Tidak ada inovasi yang cocok dengan kata kunci Anda. Coba kata kunci lain."
                :action="route('inovasi.index')"
                actionLabel="Tampilkan Semua Inovasi"
            />
        @else
            <x-empty
                icon="folder"
                title="Belum ada inovasi terdaftar"
                desc="Saat ini belum ada inovasi daerah yang tervalidasi untuk ditampilkan pada katalog publik."
            />
        @endif
    </div>
</div>
@endsection
