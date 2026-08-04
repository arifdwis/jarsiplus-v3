@extends('template::layouts.master')

@section('title', $data->label . ' — Katalog Inovasi ' . config('app.name', 'JARSIPLUS Samarinda'))
@section('meta_description', Str::limit(strip_tags((string) ($data->rancang_bangun ?? $data->tujuan_inovasi ?? '')), 155))

@section('content')
@php
    $mapTahapan = [1 => 'Inisiatif', 2 => 'Uji Coba', 3 => 'Penerapan'];
    $mapInisiator = [1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'OPD', 4 => 'ASN', 5 => 'Masyarakat'];
    $mapJenis = [1 => 'Digital', 2 => 'Non Digital'];

    // jp_isi() memperlakukan "-" dan string kosong sebagai belum diisi.
    $instansi = jp_isi($data->nama_instansi ?? null) ?? jp_isi(optional($data->pemohon1)->unit_kerja);
    $statusSelesai = $data->status == 4;

    // Hanya profil inovasinya. Identitas pribadi inovator tidak ditampilkan
    // di halaman publik ini.
    $profil = array_map('jp_isi', [
        'Instansi / OPD'        => $instansi,
        'Kategori'              => optional($data->kategori)->label,
        'Urusan Utama'          => $data->urusan_utama,
        'Urusan Lainnya'        => $data->urusan_lainnya,
        'Tahapan Inovasi'       => $mapTahapan[$data->tahapan] ?? null,
        'Jenis Inovasi'         => $mapJenis[$data->jenis] ?? null,
        'Inisiator'             => $mapInisiator[$data->inisiator] ?? null,
        'Waktu Uji Coba'        => $data->waktu_uji_coba ? tgl_indo($data->waktu_uji_coba) : null,
        'Waktu Pelaksanaan'     => $data->waktu_pelaksanaan ? tgl_indo($data->waktu_pelaksanaan) : null,
    ]);

    $narasi = array_map('jp_isi', [
        'Rancang Bangun & Pokok Perubahan' => $data->rancang_bangun,
        'Tujuan Inovasi'                   => $data->tujuan_inovasi,
        'Manfaat Inovasi'                  => $data->manfaat_inovasi,
        'Hasil Inovasi'                    => $data->hasil_inovasi,
    ]);
@endphp

<x-page-header
    badge="KATALOG INOVASI DAERAH"
    :title="$data->label"
    :back="route('inovasi.index')"
    backLabel="Kembali ke Katalog Inovasi"
/>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge {{ $statusSelesai ? 'jp-badge--success' : 'jp-badge--accent' }}">
            {{ $statusSelesai ? 'TERVALIDASI' : 'DALAM PEMBAHASAN' }}
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="building" size="14" />
            {{ $instansi ?? 'Instansi belum dicantumkan' }}
        </span>
        <span class="jp-subhead__meta font-mono">
            <x-icon name="calendar" size="14" />
            Tahun {{ $data->tahun ?? ($data->created_at ? $data->created_at->format('Y') : '—') }}
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container">
        <div class="l-split-detail">

            <div class="u-flex u-flex-col u-gap-lg">
                <section class="jp-card">
                    <header class="jp-card-head">
                        <div>
                            <span class="jp-badge jp-badge--accent">PROFIL INOVASI</span>
                            <h2 class="u-mt-xs u-mb-0">Data Umum</h2>
                        </div>
                        <x-icon name="document" size="26" style="color: var(--c-ink-subtle);" />
                    </header>

                    <div class="jp-deflist jp-deflist--2">
                        @foreach($profil as $label => $value)
                            <div class="jp-deflist__row">
                                <span class="jp-deflist__label">{{ $label }}</span>
                                <span class="jp-deflist__value">
                                    @if(filled($value)){{ $value }}@else<span class="jp-value-empty"></span>@endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="jp-card">
                    <header class="jp-card-head">
                        <div>
                            <span class="jp-badge jp-badge--accent">URAIAN</span>
                            <h2 class="u-mt-xs u-mb-0">Rancang Bangun &amp; Dampak</h2>
                        </div>
                        <x-icon name="clipboard" size="26" style="color: var(--c-ink-subtle);" />
                    </header>

                    <div class="u-flex u-flex-col u-gap-md">
                        @foreach($narasi as $label => $value)
                            <div>
                                <span class="jp-deflist__label u-block u-mb-2xs">{{ $label }}</span>
                                <p class="jp-prose {{ filled($value) ? '' : 'jp-prose--empty' }}" style="white-space: pre-line;">
                                    {{ filled($value) ? $value : 'Bagian ini belum diisi.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside>
                <div class="jp-card jp-sticky">
                    <span class="jp-action-card__icon-box"><x-icon name="star" size="22" /></span>
                    <h3 class="u-mb-xs">Punya inovasi juga?</h3>
                    <p class="jp-card__text u-mb-md">
                        Ajukan inovasi daerah Anda melalui portal JARSIPLUS Kota Samarinda.
                    </p>
                    <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--accent u-w-100">
                        <x-icon name="document" size="16" />
                        Ajukan Inovasi
                    </a>

                    @if($lainnya->count() > 0)
                        <div class="jp-divider"></div>
                        <h4 class="jp-deflist__label u-block u-mb-xs">Inovasi Lainnya</h4>
                        <div class="u-flex u-flex-col u-gap-xs">
                            @foreach($lainnya as $item)
                                <a href="{{ route('inovasi.show', $item->uuid) }}" class="jp-linklist__item">
                                    <span class="jp-linklist__title jp-clamp-2">{{ $item->label }}</span>
                                    <span class="jp-linklist__meta u-truncate">
                                        {{ optional($item->pemohon1)->unit_kerja ?? 'Kota Samarinda' }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </aside>

        </div>
    </div>
</div>
@endsection
