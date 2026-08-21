@extends('template::layouts.master')

@section('title', 'Detail Permohonan (' . $data->kode . ') — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $isJuriActive = (!empty($juriComments) && count($juriComments));
    $permohonanUuid = $data->uuid ?? $data->kode;

    if ($data->status == 0) {
        $statusBadge = 'jp-badge--amber';
        $statusLabel = 'Menunggu Validasi';
    } elseif ($data->status == 1 || $data->status == 2) {
        $statusBadge = 'jp-badge--accent';
        $statusLabel = 'Tervalidasi / Pembahasan';
    } elseif ($data->status == 4) {
        $statusBadge = 'jp-badge--success';
        $statusLabel = 'Selesai / Evaluasi';
    } elseif ($data->status == 9) {
        $statusBadge = 'jp-badge--danger';
        $statusLabel = 'Ditolak';
    } else {
        $statusBadge = 'jp-badge--neutral';
        $statusLabel = 'Draf';
    }

    $pengaju = optional($data->pemohon1)->name ?? me()->name;
    $instansi = optional($data->pemohon1)->unit_kerja;
@endphp

<x-page-header
    :title="$data->label"
    :back="route('permohonan.index')"
    backLabel="Kembali ke Daftar Permohonan"
/>

{{-- Meta permohonan --}}
<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $data->kode }}</span>
        <span class="jp-badge {{ $statusBadge }}">{{ $statusLabel }}</span>
        <span class="jp-subhead__meta">
            <x-icon name="user" size="14" />
            {{ $pengaju }}
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="building" size="14" />
            {{ $instansi ?? 'Instansi belum dicantumkan' }}
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

        <div class="jp-section__head u-mb-lg">
            <h2 class="jp-section__title">Kelola Permohonan Ini</h2>
            <p class="jp-section__desc">Pilih bagian yang ingin Anda buka: rincian formulir, berkas indikator, pengiriman, catatan juri, atau riwayat aktivitas.</p>
        </div>

        <div class="l-grid l-grid--4">

            {{-- Permohonan --}}
            <a href="{{ route($prefix.'.detail', $permohonanUuid) }}" class="jp-nav-card jp-nav-card--accent">
                <span class="jp-nav-card__icon"><x-icon name="document" size="30" /></span>
                <span class="jp-nav-card__title">Permohonan</span>
                <span class="jp-nav-card__desc">Lihat rincian formulir Segment 1–3</span>
                <span class="jp-nav-card__link">Buka rincian <span aria-hidden="true">&rarr;</span></span>
            </a>

            {{-- Indikator --}}
            @if($data->status != 9 && $data->status > 0)
                <a href="{{ route($prefix.'.indikator.index', $permohonanUuid) }}" class="jp-nav-card jp-nav-card--teal">
                    <span class="jp-nav-card__icon"><x-icon name="clipboard" size="30" /></span>
                    <span class="jp-nav-card__title">Indikator</span>
                    <span class="jp-nav-card__desc">Kelola berkas bukti dukung indikator</span>
                    <span class="jp-nav-card__link">Kelola berkas <span aria-hidden="true">&rarr;</span></span>
                </a>
            @endif

            {{-- Kirim Inovasi --}}
            @if($data->status != 9 && $data->status > 1 && $data->status < 3 && role_me() == 4)
                <button type="button" class="jp-nav-card jp-nav-card--success" onclick="document.getElementById('modalKirimInovasi').showModal()">
                    <span class="jp-nav-card__icon"><x-icon name="check-circle" size="30" /></span>
                    <span class="jp-nav-card__title">Kirim Inovasi</span>
                    <span class="jp-nav-card__desc">Kirim berkas ke Tim Verifikator</span>
                    <span class="jp-nav-card__link">Kirim sekarang <span aria-hidden="true">&rarr;</span></span>
                </button>
            @endif

            {{-- Komentar Juri --}}
            @if(role_me() == 4)
                @if($isJuriActive)
                    <button type="button" class="jp-nav-card jp-nav-card--amber" onclick="document.getElementById('modalKomentarJuri').showModal()">
                        <span class="jp-nav-card__icon"><x-icon name="chat" size="30" /></span>
                        <span class="jp-nav-card__title">Komentar Juri</span>
                        <span class="jp-nav-card__desc">Catatan &amp; evaluasi dari tim juri</span>
                        <span class="jp-nav-card__link">Lihat catatan <span aria-hidden="true">&rarr;</span></span>
                    </button>
                @else
                    {{-- Belum ada catatan juri: kartu tetap tampil, tapi nonaktif & jelas alasannya --}}
                    <div class="jp-nav-card jp-nav-card--amber is-disabled" aria-disabled="true">
                        <span class="jp-nav-card__icon"><x-icon name="chat" size="30" /></span>
                        <span class="jp-nav-card__title">Komentar Juri</span>
                        <span class="jp-nav-card__desc">Belum ada catatan yang dipublikasikan</span>
                        <span class="jp-nav-card__link">Dalam proses penjurian</span>
                    </div>
                @endif
            @endif

            {{-- Riwayat --}}
            <a href="{{ route($prefix.'.riwayat', $permohonanUuid) }}" class="jp-nav-card jp-nav-card--neutral">
                <span class="jp-nav-card__icon"><x-icon name="clock" size="30" /></span>
                <span class="jp-nav-card__title">Riwayat</span>
                <span class="jp-nav-card__desc">Log aktivitas &amp; perubahan status</span>
                <span class="jp-nav-card__link">Lihat riwayat <span aria-hidden="true">&rarr;</span></span>
            </a>

        </div>
    </div>
</div>

{{-- MODAL: Kirim Inovasi --}}
@if($data->status != 9 && $data->status > 1 && $data->status < 3)
    <dialog id="modalKirimInovasi" class="jp-modal">
        <div class="jp-modal__head">
            <div class="u-flex u-align-center u-gap-sm">
                <span class="jp-modal__icon"><x-icon name="check-circle" size="22" /></span>
                <h3 class="jp-modal__title">Konfirmasi Pengiriman Inovasi</h3>
            </div>
            <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="document.getElementById('modalKirimInovasi').close()">
                <x-icon name="close" size="22" />
            </button>
        </div>

        {!! Form::open(['route' => ['permohonan.kirim', $permohonanUuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT', 'id' => 'formKirimInovasiModal']) !!}
            <div class="jp-modal__body">
                <p class="jp-notice__text">
                    Apakah Anda yakin ingin mengirim usulan berkas inovasi ini ke Tim Verifikator?
                    Pastikan seluruh nilai &amp; dokumen bukti dukung indikator telah terisi dengan benar.
                </p>
            </div>

            <div class="jp-modal__foot">
                <button type="button" class="jp-btn jp-btn--ghost" onclick="document.getElementById('modalKirimInovasi').close()">Batal</button>
                <button type="submit" class="jp-btn jp-btn--accent">Ya, Kirim Sekarang</button>
            </div>
        {!! Form::close() !!}
    </dialog>
@endif

{{-- MODAL: Komentar Juri --}}
@if($isJuriActive)
    <dialog id="modalKomentarJuri" class="jp-modal jp-modal--lg">
        <div class="jp-modal__head">
            <div class="u-flex u-align-center u-gap-sm">
                <span class="jp-modal__icon" style="background-color: var(--c-amber-soft); color: var(--c-amber);">
                    <x-icon name="chat" size="22" />
                </span>
                <h3 class="jp-modal__title">Catatan &amp; Evaluasi Juri</h3>
            </div>
            <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="document.getElementById('modalKomentarJuri').close()">
                <x-icon name="close" size="22" />
            </button>
        </div>

        <div class="jp-modal__body">
            <div class="u-flex u-flex-col u-gap-sm">
                @foreach($juriComments as $juri)
                    @php
                        $juriName = data_get($juri, 'nama_juri') ?? data_get($juri, 'name') ?? data_get($juri, 'nama') ?? 'Juri Evaluator';
                        $juriText = data_get($juri, 'komentar_juri') ?? data_get($juri, 'komentar') ?? data_get($juri, 'catatan') ?? data_get($juri, 'deskripsi') ?? null;
                    @endphp
                    <div class="jp-card jp-card--compact jp-card--flat" style="border: 1px solid var(--c-border);">
                        <strong class="u-block u-mb-2xs" style="font-size: var(--t-sm); color: var(--c-ink);">{{ $juriName }}</strong>
                        <p class="jp-card__text {{ filled($juriText) ? '' : 'jp-prose--empty' }}">
                            {{ filled($juriText) ? $juriText : 'Juri belum menuliskan catatan.' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="jp-modal__foot">
            <span class="jp-field__hint">{{ count($juriComments) }} catatan juri</span>
            <button type="button" class="jp-btn jp-btn--ghost" onclick="document.getElementById('modalKomentarJuri').close()">Tutup</button>
        </div>
    </dialog>
@endif
@endsection
