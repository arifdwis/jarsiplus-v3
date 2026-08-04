@extends('template::layouts.master')

@section('title', 'Detail Formulir Inovasi (' . $data->kode . ') — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $mapTahapan = [1 => 'Inisiatif', 2 => 'Uji Coba', 3 => 'Penerapan'];
    $mapInisiator = [1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'OPD', 4 => 'ASN', 5 => 'Masyarakat'];
    $mapJenis = [1 => 'Digital', 2 => 'Non Digital'];

    $tahapanLabel = $mapTahapan[$data->tahapan] ?? ($data->tahapan ?? null);
    $inisiatorLabel = $mapInisiator[$data->inisiator] ?? ($data->inisiator ?? null);
    $jenisLabel = $mapJenis[$data->jenis] ?? ($data->jenis ?? null);

    if ($data->status == 0) {
        $statusBadge = 'jp-badge--amber';
        $statusLabel = 'Menunggu Validasi';
    } elseif ($data->status == 1 || $data->status == 2) {
        $statusBadge = 'jp-badge--accent';
        $statusLabel = 'Tervalidasi / Pembahasan';
    } elseif ($data->status == 4) {
        $statusBadge = 'jp-badge--success';
        $statusLabel = 'Selesai';
    } else {
        $statusBadge = 'jp-badge--neutral';
        $statusLabel = 'Draf';
    }

    // Segment 1 — data umum
    $segment1 = [
        'Nama Instansi / OPD'         => $data->nama_instansi ?? optional($data->pemohon1)->unit_kerja,
        'Kabupaten / Kota'            => 'KOTA SAMARINDA',
        'Bidang Inovasi / Kategori'   => optional($data->kategori)->label,
        'Urusan Utama Pemerintahan'   => $data->urusan_utama,
        'Urusan Lainnya Berkaitan'    => $data->urusan_lainnya,
        'Tahapan Inovasi'             => $tahapanLabel,
    ];

    // Segment 2 — biodata inovator
    $segment2 = [
        'NIK Inovator'          => optional($data->pemohon1)->nik,
        'Nama Lengkap Inovator' => optional($data->pemohon1)->name ?? me()->name,
        'NIP Kepegawaian'       => optional($data->pemohon1)->nip,
        'Telp / WhatsApp'       => optional($data->pemohon1)->phone,
        'Jabatan'               => optional($data->pemohon1)->jabatan,
    ];

    // Segment 3 — narasi proposal
    $segment3 = [
        'Rancang Bangun Inovasi (300 kata)'  => $data->rancang_bangun,
        'Tujuan Inovasi Daerah (500 kata)'   => $data->tujuan_inovasi,
        'Manfaat Inovasi Daerah (500 kata)'  => $data->manfaat_inovasi,
        'Hasil Inovasi Daerah (500 kata)'    => $data->hasil_inovasi,
    ];

    $adaLampiran = $data->anggaran || $data->profil_bisnis;
@endphp

<x-page-header
    :title="$data->label"
    :back="route('permohonan.show', $data->kode ?? $data->uuid)"
    backLabel="Kembali ke Rincian Permohonan"
>
    @if($data->status > 0)
        <a href="{{ route('permohonan.indikator.index', $data->uuid) }}" class="jp-btn jp-btn--accent">
            <x-icon name="folder" size="16" />
            Kelola Indikator Dukung
        </a>
    @endif
</x-page-header>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $data->kode }}</span>
        <span class="jp-badge {{ $statusBadge }}">{{ $statusLabel }}</span>
        <span class="jp-subhead__meta">
            <x-icon name="user" size="14" />
            {{ optional($data->pemohon1)->name ?? me()->name }}
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="building" size="14" />
            {{ optional($data->pemohon1)->unit_kerja ?? 'Instansi belum dicantumkan' }}
        </span>
        <span class="jp-subhead__meta font-mono">
            <x-icon name="calendar" size="14" />
            {{ $data->created_at ? $data->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        @if(isset($data) && $data->status == 9)
            <div class="jp-notice jp-notice--danger u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="alert-circle" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Permohonan ditolak</strong>
                    <p class="jp-notice__text">{{ $data->alasan_tolak ?? 'Usulan permohonan ditolak oleh admin verifikator.' }}</p>
                </div>
            </div>
        @endif

        <div class="l-split-detail">

            {{-- Kolom utama --}}
            <div class="u-flex u-flex-col u-gap-lg">

                {{-- Segment 1 --}}
                <section class="jp-card">
                    <header class="jp-card-head">
                        <div>
                            <span class="jp-badge jp-badge--accent">SEGMENT 01</span>
                            <h3 class="u-mt-xs u-mb-0">Data Umum Inovasi Daerah</h3>
                        </div>
                        <x-icon name="document" size="26" style="color: var(--c-ink-subtle);" />
                    </header>

                    <div class="jp-field u-mb-md">
                        <span class="jp-deflist__label">Judul Inovasi Daerah</span>
                        <p style="font-size: var(--t-xl); font-weight: 700; color: var(--c-ink); margin: 2px 0 0; line-height: 1.35;">
                            {{ $data->label }}
                        </p>
                    </div>

                    <div class="jp-deflist jp-deflist--2">
                        @foreach($segment1 as $label => $value)
                            <div class="jp-deflist__row">
                                <span class="jp-deflist__label">{{ $label }}</span>
                                <span class="jp-deflist__value">
                                    @if(filled($value)){{ $value }}@else<span class="jp-value-empty"></span>@endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Segment 2 --}}
                <section class="jp-card">
                    <header class="jp-card-head">
                        <div>
                            <span class="jp-badge jp-badge--accent">SEGMENT 02</span>
                            <h3 class="u-mt-xs u-mb-0">Biodata Inovator Utama</h3>
                        </div>
                        <x-icon name="user" size="26" style="color: var(--c-ink-subtle);" />
                    </header>

                    <div class="jp-deflist jp-deflist--2">
                        @foreach($segment2 as $label => $value)
                            <div class="jp-deflist__row">
                                <span class="jp-deflist__label">{{ $label }}</span>
                                <span class="jp-deflist__value">
                                    @if(filled($value)){{ $value }}@else<span class="jp-value-empty"></span>@endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Segment 3 --}}
                <section class="jp-card">
                    <header class="jp-card-head">
                        <div>
                            <span class="jp-badge jp-badge--accent">SEGMENT 03</span>
                            <h3 class="u-mt-xs u-mb-0">Rancang Bangun &amp; Proposal (Perwali No. 22/2020)</h3>
                        </div>
                        <x-icon name="clipboard" size="26" style="color: var(--c-ink-subtle);" />
                    </header>

                    <div class="u-flex u-flex-col u-gap-md">
                        @foreach($segment3 as $label => $value)
                            <div>
                                <span class="jp-deflist__label u-block u-mb-2xs">{{ $label }}</span>
                                <p class="jp-prose {{ filled($value) ? '' : 'jp-prose--empty' }}" style="white-space: pre-line;">
                                    {{ filled($value) ? $value : 'Bagian ini belum diisi oleh pemohon.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Komentar Juri --}}
                @include('template::partials.juri-komentar')
            </div>

            {{-- Sidebar ringkasan --}}
            <aside>
                <div class="jp-card jp-sticky">
                    <header class="jp-card-head">
                        <div>
                            <span class="jp-badge jp-badge--accent">PROFIL INOVASI</span>
                            <h3 class="u-mt-xs u-mb-0">Rincian Parameter</h3>
                        </div>
                    </header>

                    <div class="u-flex u-flex-col u-gap-md">
                        <div>
                            <span class="jp-deflist__label u-block u-mb-2xs">Inisiator Inovasi</span>
                            @if(filled($inisiatorLabel))
                                <span class="jp-badge jp-badge--accent">{{ $inisiatorLabel }}</span>
                            @else
                                <span class="jp-value-empty"></span>
                            @endif
                        </div>

                        <div>
                            <span class="jp-deflist__label u-block u-mb-2xs">Jenis Inovasi</span>
                            @if(filled($jenisLabel))
                                <span class="jp-badge jp-badge--accent">{{ $jenisLabel }}</span>
                            @else
                                <span class="jp-value-empty"></span>
                            @endif
                        </div>

                        <div>
                            <span class="jp-deflist__label u-block u-mb-2xs">Waktu Uji Coba</span>
                            <span class="jp-subhead__meta font-mono">
                                <x-icon name="calendar" size="14" />
                                @if($data->waktu_uji_coba){{ tgl_indo($data->waktu_uji_coba) }}@else<span class="jp-value-empty"></span>@endif
                            </span>
                        </div>

                        <div>
                            <span class="jp-deflist__label u-block u-mb-2xs">Waktu Pelaksanaan</span>
                            <span class="jp-subhead__meta font-mono">
                                <x-icon name="calendar" size="14" />
                                @if($data->waktu_pelaksanaan){{ tgl_indo($data->waktu_pelaksanaan) }}@else<span class="jp-value-empty"></span>@endif
                            </span>
                        </div>

                        <div class="jp-divider u-mb-0"></div>

                        <div>
                            <span class="jp-deflist__label u-block u-mb-xs">Dokumen Lampiran</span>

                            @if($adaLampiran)
                                <div class="u-flex u-flex-col u-gap-xs">
                                    @if($data->anggaran)
                                        <a href="{{ asset($data->anggaran) }}" target="_blank" rel="noopener" class="jp-btn jp-btn--ghost jp-btn--sm" style="justify-content: flex-start;">
                                            <x-icon name="file" size="16" />
                                            Berkas Anggaran
                                        </a>
                                    @endif
                                    @if($data->profil_bisnis)
                                        <a href="{{ asset($data->profil_bisnis) }}" target="_blank" rel="noopener" class="jp-btn jp-btn--ghost jp-btn--sm" style="justify-content: flex-start;">
                                            <x-icon name="file" size="16" />
                                            Proposal / Profil Bisnis
                                        </a>
                                    @endif
                                </div>
                            @else
                                <p class="jp-field__hint" style="font-style: italic;">Tidak ada dokumen lampiran yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>
@endsection
