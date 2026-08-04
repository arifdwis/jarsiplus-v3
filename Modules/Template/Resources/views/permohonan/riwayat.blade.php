@extends('template::layouts.master')

@section('title', 'Log Histori Aktivitas — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    :title="$data->label"
    badge="LOG AKTIVITAS"
    :back="route('permohonan.show', $data->kode ?? $data->uuid)"
    backLabel="Kembali ke Rincian Menu"
/>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $data->kode }}</span>
        <span class="jp-subhead__meta">
            <x-icon name="user" size="14" />
            {{ optional($data->pemohon1)->name ?? me()->name }}
        </span>
        <span class="jp-subhead__meta font-mono">
            <x-icon name="calendar" size="14" />
            {{ $data->created_at ? $data->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">

        <div class="jp-section__head u-mb-lg">
            <h2 class="jp-section__title">Lini Masa Aktivitas Inovasi</h2>
            <p class="jp-section__desc">
                Seluruh catatan perubahan status, revisi berkas, dan tindakan verifikator pada usulan ini —
                diurutkan dari yang terbaru.
            </p>
        </div>

        @if(isset($histori) && $histori->count() > 0)
            <div class="jp-timeline">
                @foreach($histori as $index => $temp)
                    @php
                        $stepNumber = $histori->count() - $index;
                        $formattedDate = $temp->created_at ? $temp->created_at->format('d M Y') : null;
                        $formattedTime = $temp->created_at ? $temp->created_at->format('H:i') : null;
                        $isLatest = $index === 0;
                    @endphp

                    <div class="jp-timeline__item {{ $isLatest ? 'is-latest' : '' }}">
                        <div class="jp-timeline__marker">
                            <span></span>
                        </div>

                        <div class="jp-timeline__content">
                            <div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-xs u-mb-xs">
                                <span class="jp-badge {{ $isLatest ? 'jp-badge--accent' : 'jp-badge--neutral' }} font-mono">
                                    LOG #{{ $stepNumber }}@if($isLatest) &middot; TERBARU @endif
                                </span>

                                <time class="jp-timeline__time">
                                    @if($formattedDate)
                                        {{ $formattedDate }}@if($formattedTime) &middot; {{ $formattedTime }} WITA @endif
                                    @else
                                        Waktu tidak tercatat
                                    @endif
                                </time>
                            </div>

                            <p class="jp-timeline__desc {{ filled($temp->deskripsi) ? '' : 'jp-prose--empty' }}">
                                {{ filled($temp->deskripsi) ? $temp->deskripsi : 'Tidak ada keterangan pada catatan ini.' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-empty
                icon="clock"
                title="Belum ada riwayat aktivitas"
                desc="Belum ada catatan perubahan status atau revisi berkas pada usulan permohonan ini. Riwayat akan muncul otomatis setiap kali terjadi tindakan pada usulan Anda."
            >
                <a href="{{ route('permohonan.show', $data->kode ?? $data->uuid) }}" class="jp-btn jp-btn--ghost u-mt-sm">
                    Kembali ke Rincian Permohonan
                </a>
            </x-empty>
        @endif

    </div>
</div>
@endsection
