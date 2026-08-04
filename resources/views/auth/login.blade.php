@extends('template::layouts.master')

@section('title', 'Masuk Portal Pemohon — JARSIPLUS Kota Samarinda')

@section('content')
<div style="min-height: 100vh; width: 100%; display: flex; align-items: stretch; background-color: #0F172A;">
    <div class="l-split-fullscreen">
        {{-- Left Column: Dark Graphite Brand & Value Highlights --}}
        <div style="background-color: #0F172A; color: #FFFFFF; padding: 56px 48px; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden;">
            {{-- Radial Accent Glow --}}
            <div style="position: absolute; top: -120px; right: -120px; width: 420px; height: 420px; border-radius: 50%; background: radial-gradient(circle, rgba(30,64,175,0.35) 0%, rgba(15,23,42,0) 70%); pointer-events: none;"></div>
            <div style="position: absolute; bottom: -80px; left: -80px; width: 320px; height: 320px; border-radius: 50%; background: radial-gradient(circle, rgba(6,182,212,0.15) 0%, rgba(15,23,42,0) 70%); pointer-events: none;"></div>

            <div style="position: relative; z-index: 2;">
                {{-- Brand Logo --}}
                <div class="u-mb-xl">
                    <a href="{{ url('/') }}" style="display: inline-block;">
                        @if(file_exists(public_path('img/brand/logo-jarsiplus.svg')) || file_exists(public_path('images/logo-jarsiplus.svg')))
                            <img src="{{ asset(file_exists(public_path('img/brand/logo-jarsiplus.svg')) ? 'img/brand/logo-jarsiplus.svg' : 'images/logo-jarsiplus.svg') }}" alt="Logo JARSIPLUS" style="height: 48px; width: auto;" />
                        @else
                            <span class="jp-brand__icon" style="background-color: var(--c-accent); color: #FFF; width: 44px; height: 44px; font-size: 1.25rem;">J</span>
                        @endif
                    </a>
                </div>

                <div class="u-mb-lg">
                    <span class="jp-badge" style="background: rgba(38, 93, 245, 0.2); color: #60A5FA; border: 1px solid rgba(96, 165, 250, 0.3); margin-bottom: 18px; padding: 6px 12px; font-size: 11px;">
                        PEMERINTAH KOTA SAMARINDA
                    </span>

                    <h1 style="font-size: clamp(2rem, 3.5vw, 2.75rem); color: #FFFFFF; font-weight: 700; line-height: 1.2; margin-bottom: 16px; letter-spacing: -0.03em;">
                        Jaringan Inovasi Plus Daerah
                    </h1>

                    <p style="color: rgba(255,255,255,0.75); font-size: 1.05rem; line-height: 1.6; max-width: 520px; margin-bottom: 40px;">
                        Platform resmi Bapperida Kota Samarinda untuk pengelolaan, evaluasi, dan publikasi usulan inovasi pelayanan publik &amp; tata kelola pemerintahan daerah.
                    </p>
                </div>

                <div class="u-flex u-flex-col u-gap-lg" style="max-width: 480px;">
                    <div class="u-flex u-align-center u-gap-md">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #60A5FA; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <x-icon name="check" size="20" />
                        </div>
                        <div>
                            <strong style="color: #FFFFFF; font-size: var(--t-base); display: block; margin-bottom: 2px;">Pengajuan Standar IGA</strong>
                            <span style="color: rgba(255,255,255,0.6); font-size: var(--t-xs);">Kriteria Indeks Inovasi Daerah Kementerian Dalam Negeri</span>
                        </div>
                    </div>

                    <div class="u-flex u-align-center u-gap-md">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #60A5FA; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <x-icon name="info" size="20" />
                        </div>
                        <div>
                            <strong style="color: #FFFFFF; font-size: var(--t-base); display: block; margin-bottom: 2px;">Pelacakan Berkas Real-Time</strong>
                            <span style="color: rgba(255,255,255,0.6); font-size: var(--t-xs);">Pantau progres pembahasan oleh Tim Kerja Sama Daerah (TKSD)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="position: relative; z-index: 2; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; color: rgba(255,255,255,0.5); font-size: var(--t-xs); font-family: var(--font-mono); display: flex; justify-content: space-between; align-items: center;">
                <span>// Bapperida Kota Samarinda © 2026</span>
                <a href="{{ url('/') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;">&larr; Kembali ke Beranda</a>
            </div>
        </div>

        {{-- Right Column: White Auth Card --}}
        <div style="background-color: var(--c-surface); padding: 56px 48px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <div style="width: 100%; max-width: 420px;">
                <div class="u-mb-xl">
                    <span class="jp-badge jp-badge--teal u-mb-xs">PORTAL INOVATOR</span>
                    <h2 style="font-size: 2rem; color: var(--c-ink); margin-bottom: 8px; font-weight: 700;">Masuk ke Portal</h2>
                    <p class="text-muted" style="font-size: var(--t-sm); margin-bottom: 0; line-height: 1.5;">
                        Autentikasi menggunakan akun Single Sign-On (SSO) Pemkot Samarinda.
                    </p>
                </div>

                @if(Auth::check())
                    <div class="jp-card u-mb-lg" style="background: var(--c-bg); border: 1px solid var(--c-border); padding: 18px 20px;">
                        <span class="text-muted" style="font-size: var(--t-xs);">Masuk sebagai:</span>
                        <strong style="display: block; color: var(--c-ink); font-size: var(--t-base); margin-top: 2px;">{{ Auth::user()->name }}</strong>
                        <span class="font-mono text-muted" style="font-size: var(--t-xs);">{{ Auth::user()->email }}</span>
                    </div>

                    <div class="u-flex u-flex-col u-gap-sm">
                        <a href="{{ url('/permohonan') }}" class="jp-btn jp-btn--accent u-w-100" style="padding: 13px 20px; font-size: var(--t-base);">
                            <x-icon name="user" size="18" />
                            Masuk ke Portal Pemohon &rarr;
                        </a>
                        <a href="{{ route('sso.logout') }}" class="jp-btn jp-btn--ghost u-w-100">
                            Keluar / Ganti Akun
                        </a>
                    </div>
                @else
                    <div class="u-flex u-flex-col u-gap-md u-mb-xl">
                        <a href="{{ route('sso.authorize') }}" class="jp-btn jp-btn--accent u-w-100" style="padding: 14px 24px; font-size: var(--t-base); font-weight: 700;">
                            <x-icon name="lock" size="18" />
                            Masuk via SSO Samarinda
                        </a>
                        <a href="https://sso.samarindakota.go.id" target="_blank" rel="noopener" class="jp-btn jp-btn--ghost u-w-100" style="padding: 12px 20px;">
                            Registrasi Akun SSO Baru &rarr;
                        </a>
                    </div>

                    <div style="background-color: var(--c-bg); border-radius: var(--r-card); padding: 16px; border: 1px solid var(--c-border);">
                        <small class="text-muted" style="font-size: var(--t-xs); line-height: 1.6; display: block;">
                            💡 <strong>Petunjuk:</strong> Akun SSO terintegrasi dengan NIK/Email terverifikasi Pemerintah Kota Samarinda.
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection