@extends('template::layouts.master')

@section('title', 'Pemeliharaan Sistem — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<section class="jp-section jp-section--graphite" style="min-height:60vh;display:flex;align-items:center">
    <div class="l-container u-text-center">
        <div class="jp-data-card" style="max-width:500px;margin:0 auto;text-align:left">
            <div class="jp-data-card__bar">
                <span class="jp-data-card__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                <span class="jp-data-card__file">system.status</span>
                <span class="jp-data-card__status">
                    <span class="jp-data-card__status-dot" style="background-color:var(--c-amber)" aria-hidden="true"></span>
                    maintenance
                </span>
            </div>
            <div class="jp-data-card__body" style="font-family:var(--font-body);text-align:center">
                <x-icon name="shield" size="48" style="color:var(--c-amber);margin-bottom:12px" />
                <h2 style="font-size:var(--t-2xl);margin-bottom:8px">Sistem Dalam Pemeliharaan</h2>
                <p style="color:var(--c-text-muted); font-size:var(--t-sm);line-height:1.7">Kami sedang melakukan peningkatan performa dan pemeliharaan rutin pada platform JARSIPLUS Kota Samarinda untuk memberikan layanan yang lebih baik.</p>
                <div style="margin-top:16px;padding:12px;border:1px solid var(--c-border);border-radius:var(--r-card);font-size:var(--t-sm)">
                    <span style="color:var(--c-text-muted)">Estimasi Selesai: <strong style="color:var(--c-text)">Segera</strong></span>
                </div>
                <a href="{{ url('/') }}" class="jp-btn jp-btn--accent u-w-100 u-mt-md">Coba Muat Ulang Halaman</a>
            </div>
        </div>
    </div>
</section>
@endsection
