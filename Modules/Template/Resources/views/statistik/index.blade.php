@extends('template::layouts.master')

@section('title', 'Dashboard Statistik — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $mapInisiator = [1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'Perangkat Daerah (OPD)', 4 => 'ASN', 5 => 'Masyarakat'];
    $mapTahapan   = [1 => 'Inisiatif', 2 => 'Uji Coba', 3 => 'Penerapan'];
    $bulanID      = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

    // --- Deret bulanan: buang bulan kosong di ujung agar grafik tidak melompong
    $bulanLabel = $permohonanPerBulan['months'] ?? [];
    $bulanNilai = $permohonanPerBulan['counts'] ?? [];
    $bulanMax   = count($bulanNilai) ? max($bulanNilai) : 0;
    $bulanTotal = array_sum($bulanNilai);

    // --- Deret harian
    $hariLabel = $permohonanPerHari['dates'] ?? [];
    $hariNilai = $permohonanPerHari['counts'] ?? [];
    $hariMax   = count($hariNilai) ? max($hariNilai) : 0;
    $hariTotal = array_sum($hariNilai);

    $urusanMax    = $permohonanPerUrusan->max('total') ?: 1;
    $inisiatorMax = $permohonanPerInisiator->max('total') ?: 1;
    $tahapanMax   = $permohonanPerTahapan->max('total') ?: 1;

    $persen = fn ($n, $d) => $d > 0 ? round(($n / $d) * 100) : 0;
@endphp

<x-page-header
    badge="TRANSPARANSI KINERJA"
    title="Dashboard Statistik Inovasi"
    desc="Data pengajuan, verifikasi, dan sebaran inovasi daerah Kota Samarinda."
>
    <span class="jp-subhead__meta font-mono">
        <x-icon name="clock" size="14" />
        Diperbarui {{ date('d M Y H:i') }}
    </span>
</x-page-header>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--wide">

        {{-- ============ Ringkasan angka ============ --}}
        <div class="l-grid l-grid--3 u-mb-lg jp-kpi-grid">
            <x-stat-tile label="Total Permohonan"  :value="number_format($permohonan)" icon="folder"       accent="var(--c-accent)" />
            <x-stat-tile label="Menunggu Validasi" :value="number_format($proses)"     icon="clock"        accent="var(--c-amber)" />
            <x-stat-tile label="Dalam Pembahasan"  :value="number_format($setuju)"     icon="chat"         accent="var(--c-sky)" />
            <x-stat-tile label="Selesai / Evaluasi" :value="number_format($selesai)"   icon="check-circle" accent="var(--c-success)" />
            <x-stat-tile label="Ditolak"           :value="number_format($tolak)"      icon="close"        accent="var(--c-danger)" />
            <x-stat-tile label="Pemohon Terdaftar" :value="number_format($cpemohon)"   icon="user"         accent="var(--c-ink-subtle)" />
        </div>

        {{-- ============ Tren waktu ============ --}}
        <div class="jp-chart-row u-mb-lg">

            {{-- Per bulan --}}
            <section class="jp-card">
                <header class="jp-chart__head">
                    <div>
                        <h2 class="jp-chart__title">Permohonan per Bulan</h2>
                        <p class="jp-chart__sub">12 bulan terakhir &middot; total {{ number_format($bulanTotal) }} usulan</p>
                    </div>
                    <span class="jp-badge jp-badge--neutral font-mono">Puncak {{ $bulanMax }}</span>
                </header>

                @if($bulanMax > 0)
                    <div class="jp-bars" role="img"
                         aria-label="Grafik batang jumlah permohonan per bulan selama 12 bulan terakhir">
                        @foreach($bulanLabel as $i => $bln)
                            @php
                                $n = $bulanNilai[$i] ?? 0;
                                [$th, $bl] = array_pad(explode('-', $bln), 2, null);
                                $labelBulan = ($bulanID[(int) $bl] ?? $bl);
                            @endphp
                            <div class="jp-bars__col" tabindex="0">
                                <span class="jp-bars__value {{ $n === 0 ? 'is-zero' : '' }}">{{ $n }}</span>
                                <div class="jp-bars__track">
                                    <div class="jp-bars__fill" style="height: {{ $bulanMax > 0 ? max(2, $persen($n, $bulanMax)) : 0 }}%;"></div>
                                </div>
                                <span class="jp-bars__label">{{ $labelBulan }}</span>
                                <span class="jp-bars__tip">{{ $labelBulan }} {{ $th }} — {{ $n }} usulan</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty icon="chart" title="Belum ada data bulanan"
                             desc="Belum ada permohonan yang tercatat dalam 12 bulan terakhir." />
                @endif
            </section>

            {{-- Per hari --}}
            <section class="jp-card">
                <header class="jp-chart__head">
                    <div>
                        <h2 class="jp-chart__title">Permohonan Harian</h2>
                        <p class="jp-chart__sub">8 hari terakhir &middot; total {{ number_format($hariTotal) }} usulan</p>
                    </div>
                    <span class="jp-badge jp-badge--neutral font-mono">Puncak {{ $hariMax }}</span>
                </header>

                @if($hariTotal > 0)
                    <div class="jp-bars" role="img" aria-label="Grafik batang jumlah permohonan harian selama 8 hari terakhir">
                        @foreach($hariLabel as $i => $tgl)
                            @php
                                $n = $hariNilai[$i] ?? 0;
                                $d = \Carbon\Carbon::parse($tgl);
                            @endphp
                            <div class="jp-bars__col" tabindex="0">
                                <span class="jp-bars__value {{ $n === 0 ? 'is-zero' : '' }}">{{ $n }}</span>
                                <div class="jp-bars__track">
                                    <div class="jp-bars__fill" style="height: {{ $hariMax > 0 ? max(2, $persen($n, $hariMax)) : 0 }}%;"></div>
                                </div>
                                <span class="jp-bars__label">{{ $d->format('d/m') }}</span>
                                <span class="jp-bars__tip">{{ $d->format('d M Y') }} — {{ $n }} usulan</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty icon="chart" title="Belum ada pengajuan"
                             desc="Tidak ada permohonan masuk dalam 8 hari terakhir." />
                @endif
            </section>
        </div>

        {{-- ============ Sebaran ============ --}}
        <div class="l-grid l-grid--3 u-mb-lg">

            {{-- Urusan --}}
            <section class="jp-card">
                <header class="jp-chart__head">
                    <div>
                        <h2 class="jp-chart__title">Urusan Pemerintahan Teratas</h2>
                        <p class="jp-chart__sub">10 urusan dengan usulan terbanyak</p>
                    </div>
                </header>

                @if($permohonanPerUrusan->count() > 0)
                    <ul class="jp-hbars">
                        @foreach($permohonanPerUrusan as $row)
                            <li class="jp-hbars__item">
                                <span class="jp-hbars__label" title="{{ $row->urusan_utama }}">{{ $row->urusan_utama }}</span>
                                <span class="jp-hbars__track">
                                    <span class="jp-hbars__fill" style="width: {{ max(2, $persen($row->total, $urusanMax)) }}%;"></span>
                                </span>
                                <span class="jp-hbars__value font-mono">{{ $row->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <x-empty icon="chart" title="Belum ada data urusan" desc="Belum ada usulan dengan urusan pemerintahan terisi." />
                @endif
            </section>

            {{-- Inisiator --}}
            <section class="jp-card">
                <header class="jp-chart__head">
                    <div>
                        <h2 class="jp-chart__title">Inisiator Inovasi</h2>
                        <p class="jp-chart__sub">Asal gagasan inovasi daerah</p>
                    </div>
                </header>

                @if($permohonanPerInisiator->count() > 0)
                    <ul class="jp-hbars">
                        @foreach($permohonanPerInisiator as $row)
                            <li class="jp-hbars__item">
                                <span class="jp-hbars__label">{{ $mapInisiator[(int) $row->inisiator] ?? 'Lainnya' }}</span>
                                <span class="jp-hbars__track">
                                    <span class="jp-hbars__fill" style="width: {{ max(2, $persen($row->total, $inisiatorMax)) }}%;"></span>
                                </span>
                                <span class="jp-hbars__value font-mono">{{ $row->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <x-empty icon="chart" title="Belum ada data inisiator" desc="Belum ada usulan dengan inisiator terisi." />
                @endif
            </section>

            {{-- Tahapan --}}
            <section class="jp-card">
                <header class="jp-chart__head">
                    <div>
                        <h2 class="jp-chart__title">Tahapan Inovasi</h2>
                        <p class="jp-chart__sub">Kematangan inovasi yang diusulkan</p>
                    </div>
                </header>

                @if($permohonanPerTahapan->count() > 0)
                    <ul class="jp-hbars">
                        @foreach($permohonanPerTahapan as $row)
                            <li class="jp-hbars__item">
                                <span class="jp-hbars__label">{{ $mapTahapan[(int) $row->tahapan] ?? 'Lainnya' }}</span>
                                <span class="jp-hbars__track">
                                    <span class="jp-hbars__fill" style="width: {{ max(2, $persen($row->total, $tahapanMax)) }}%;"></span>
                                </span>
                                <span class="jp-hbars__value font-mono">{{ $row->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <x-empty icon="chart" title="Belum ada data tahapan" desc="Belum ada usulan dengan tahapan terisi." />
                @endif
            </section>
        </div>

        {{-- ============ Pemohon terbaru ============ --}}
        <section>
            <div class="u-flex u-justify-between u-align-end u-flex-wrap u-gap-sm u-mb-md">
                <div>
                    <h2 class="jp-section__title u-mb-0" style="font-size: var(--t-xl);">Pemohon Terbaru</h2>
                    <p class="jp-section__desc">Sepuluh pemohon yang paling baru terdaftar dari {{ number_format($cpemohon) }} total pemohon.</p>
                </div>
                <a href="{{ route('inovasi.index') }}" class="jp-link-arrow">
                    Lihat Katalog Inovasi <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            @if($pemohon->count() > 0)
                <div class="jp-table-wrapper">
                    <table class="jp-table">
                        <thead>
                            <tr>
                                <th style="width: 48px;">#</th>
                                <th>Nama Pemohon</th>
                                <th>Unit Kerja / Instansi</th>
                                <th style="width: 200px;">Jabatan</th>
                                <th style="width: 130px;">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemohon as $i => $p)
                                <tr>
                                    <td class="font-mono" style="color: var(--c-ink-subtle);">{{ $i + 1 }}</td>
                                    <td style="font-weight: 600; color: var(--c-ink);">
                                        @if(jp_isi($p->name)){{ $p->name }}@else<span class="jp-value-empty"></span>@endif
                                    </td>
                                    <td>
                                        @if(jp_isi($p->unit_kerja)){{ $p->unit_kerja }}@else<span class="jp-value-empty"></span>@endif
                                    </td>
                                    <td>
                                        @if(jp_isi($p->jabatan)){{ $p->jabatan }}@else<span class="jp-value-empty"></span>@endif
                                    </td>
                                    <td class="font-mono" style="white-space: nowrap; color: var(--c-ink-subtle);">
                                        {{ $p->created_at ? $p->created_at->format('d M Y') : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty icon="user" title="Belum ada pemohon" desc="Belum ada pemohon yang terdaftar pada sistem." />
            @endif
        </section>

    </div>
</div>
@endsection
