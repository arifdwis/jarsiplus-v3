@extends('template::layouts.master')

@section('title', 'Hasil Evaluasi Inovasi Daerah — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $nilaiAkhir = $data->nilai_akhir;
    $adaNilai = filled($nilaiAkhir) && is_numeric($nilaiAkhir);

    // Predikat diturunkan dari nilai, bukan teks tetap.
    if (!$adaNilai) {
        $predikat = null;
    } elseif ($nilaiAkhir >= 85) {
        $predikat = 'Sangat Inovatif';
    } elseif ($nilaiAkhir >= 70) {
        $predikat = 'Inovatif';
    } elseif ($nilaiAkhir >= 55) {
        $predikat = 'Cukup Inovatif';
    } else {
        $predikat = 'Kurang Inovatif';
    }

    $instansi = optional($data->pemohon1)->unit_kerja;
    $inovator = optional($data->pemohon1)->name ?? me()->name;
@endphp

<x-page-header
    :title="$data->label"
    badge="HASIL EVALUASI"
    :back="route('permohonan.show', $data->kode ?? $data->uuid)"
    backLabel="Kembali ke Rincian Menu"
/>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $data->kode }}</span>
        <span class="jp-subhead__meta">
            <x-icon name="user" size="14" />
            {{ $inovator }}
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="building" size="14" />
            {{ $instansi ?? 'Instansi belum dicantumkan' }}
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">
        @if($data->status == 4)
            <div class="jp-card u-p-0" style="overflow: hidden;">

                {{-- Kepala sertifikat --}}
                <div class="jp-result-head">
                    <span class="jp-result-head__icon"><x-icon name="star" size="34" /></span>
                    <span class="jp-badge jp-badge--success">EVALUASI TERVALIDASI</span>
                    <h2 class="jp-result-head__title">Hasil Skor Inovasi Daerah</h2>
                    <p class="jp-result-head__sub">Kota Samarinda &middot; Indeks Inovasi Daerah (IGA)</p>
                </div>

                <div class="u-p-xl">
                    {{-- Nilai akhir --}}
                    <div class="jp-score">
                        <span class="jp-score__label">Nilai Akhir Inovasi</span>

                        @if($adaNilai)
                            <span class="jp-score__value">{{ number_format($nilaiAkhir, 2) }}</span>
                            <span class="jp-badge jp-badge--success">PREDIKAT: {{ strtoupper($predikat) }}</span>
                        @else
                            {{-- Nilai belum tersedia: jangan tampilkan angka contoh --}}
                            <span class="jp-score__value jp-score__value--empty">—</span>
                            <span class="jp-badge jp-badge--neutral">NILAI BELUM DIPUBLIKASIKAN</span>
                            <p class="jp-field__hint u-mt-xs">
                                Evaluasi telah selesai, namun nilai akhir belum dipublikasikan oleh tim penilai.
                            </p>
                        @endif
                    </div>

                    {{-- Metadata --}}
                    <div class="jp-deflist jp-deflist--2 u-mt-lg">
                        <div class="jp-deflist__row">
                            <span class="jp-deflist__label">Judul Inovasi</span>
                            <span class="jp-deflist__value">{{ $data->label }}</span>
                        </div>
                        <div class="jp-deflist__row">
                            <span class="jp-deflist__label">Inovator / Instansi</span>
                            <span class="jp-deflist__value">
                                {{ $inovator }}@if($instansi) &middot; {{ $instansi }}@endif
                            </span>
                        </div>
                        <div class="jp-deflist__row">
                            <span class="jp-deflist__label">Urusan Utama</span>
                            <span class="jp-deflist__value">
                                @if(filled($data->urusan_utama)){{ $data->urusan_utama }}@else<span class="jp-value-empty"></span>@endif
                            </span>
                        </div>
                        <div class="jp-deflist__row">
                            <span class="jp-deflist__label">Tanggal Evaluasi</span>
                            <span class="jp-deflist__value font-mono">
                                @if($data->updated_at){{ $data->updated_at->format('d M Y') }}@else<span class="jp-value-empty"></span>@endif
                            </span>
                        </div>
                    </div>

                    <p class="u-text-center u-mt-lg" style="font-size: var(--t-sm); color: var(--c-ink-muted);">
                        Terima kasih atas partisipasi dan dedikasi Anda dalam memberikan kontribusi inovasi daerah
                        untuk kemajuan pelayanan publik Kota Samarinda.
                    </p>

                    <div class="u-flex u-justify-center u-gap-sm u-flex-wrap u-mt-lg pt-3" style="border-top: 1px solid var(--c-border);">
                        <a href="{{ route('permohonan.show', $data->kode ?? $data->uuid) }}" class="jp-btn jp-btn--ghost">
                            Kembali ke Permohonan
                        </a>
                        <a href="{{ route('permohonan.index') }}" class="jp-btn jp-btn--accent">
                            Daftar Inovasi Daerah <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            {{-- Belum selesai dievaluasi --}}
            <x-empty
                icon="clock"
                title="Masih dalam proses verifikasi"
                desc="Tim verifikator masih meninjau setiap aspek usulan yang Anda kontribusikan. Hasil evaluasi akan tampil di halaman ini setelah proses penilaian selesai."
            >
                <a href="{{ route('permohonan.show', $data->kode ?? $data->uuid) }}" class="jp-btn jp-btn--accent u-mt-sm">
                    Cek Progres Inovasi
                </a>
            </x-empty>
        @endif
    </div>
</div>
@endsection
