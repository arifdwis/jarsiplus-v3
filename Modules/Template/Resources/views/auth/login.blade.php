@extends('template::layouts.master')

@section('title', 'Masuk Portal Pemohon — JARSIPLUS Kota Samarinda')

@push('css')
<style>
/* ============================================================
   LOGIN PAGE — High Contrast Premium Auth Styles
   ============================================================ */
.jp-auth {
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: stretch;
    background: #F8FAFC;
}

.jp-auth__split {
    display: grid;
    grid-template-columns: 1fr;
    width: 100%;
}

@media (min-width: 992px) {
    .jp-auth__split {
        grid-template-columns: 1.15fr 0.85fr;
    }
}

/* Left: Brand Panel */
.jp-auth__brand {
    position: relative;
    overflow: hidden;
    background: linear-gradient(168deg, #091322 0%, #0F2342 50%, #08111D 100%);
    color: #FFFFFF !important;
    padding: clamp(36px, 5vw, 64px) clamp(28px, 4.5vw, 64px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 32px;
}

.jp-auth__brand::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
    background-size: 44px 44px;
    mask-image: radial-gradient(ellipse at 30% 0%, rgba(0, 0, 0, 0.7) 0%, transparent 75%);
    pointer-events: none;
}

.jp-auth__glow {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.jp-auth__glow--1 {
    top: -100px;
    right: -100px;
    width: 460px;
    height: 460px;
    background: radial-gradient(circle, rgba(2, 132, 199, 0.22) 0%, transparent 65%);
}

.jp-auth__glow--2 {
    bottom: -80px;
    left: -80px;
    width: 360px;
    height: 360px;
    background: radial-gradient(circle, rgba(56, 189, 248, 0.14) 0%, transparent 60%);
}

.jp-auth__brand-inner {
    position: relative;
    z-index: 2;
}

.jp-auth__logo {
    display: inline-flex;
    align-items: center;
    margin-bottom: clamp(28px, 4vw, 44px);
}

.jp-auth__logo img {
    height: 48px;
    width: auto;
    filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
}

.jp-auth__brand-badge {
    display: inline-block;
    background: rgba(2, 132, 199, 0.22);
    border: 1px solid rgba(56, 189, 248, 0.4);
    color: #38BDF8 !important;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.6px;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.jp-auth__brand-title {
    font-size: clamp(2rem, 3.2vw, 2.75rem) !important;
    font-weight: 800 !important;
    line-height: 1.18 !important;
    letter-spacing: -0.03em !important;
    color: #FFFFFF !important;
    margin-bottom: 16px !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.jp-auth__brand-lead {
    color: #E2E8F0 !important;
    font-size: 15px !important;
    line-height: 1.65 !important;
    max-width: 500px;
    margin-bottom: clamp(28px, 4vw, 44px) !important;
    font-weight: 400;
}

.jp-auth__features {
    display: flex;
    flex-direction: column;
    gap: 14px;
    max-width: 460px;
}

.jp-auth__feature {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 16px 18px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    transition: all 0.24s ease;
}

.jp-auth__feature:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(56, 189, 248, 0.3);
    transform: translateY(-1px);
}

.jp-auth__feature-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(56, 189, 248, 0.18);
    border: 1px solid rgba(56, 189, 248, 0.35);
    color: #38BDF8 !important;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.jp-auth__feature-title {
    display: block;
    color: #FFFFFF !important;
    font-weight: 700 !important;
    font-size: 14.5px;
    line-height: 1.35;
    margin-bottom: 3px;
}

.jp-auth__feature-desc {
    display: block;
    color: #94A3B8 !important;
    font-size: 12.5px;
    line-height: 1.5;
}

.jp-auth__foot {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
    padding-top: 20px;
    color: #94A3B8 !important;
    font-family: var(--font-mono, monospace);
    font-size: 12px;
    flex-wrap: wrap;
}

.jp-auth__back {
    color: #F8FAFC !important;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    transition: color 0.18s ease;
}

.jp-auth__back:hover {
    color: #38BDF8 !important;
    text-decoration: underline;
}

/* Right: Form Panel */
.jp-auth__panel {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: clamp(36px, 5vw, 64px) clamp(24px, 4.5vw, 56px);
    background: #F8FAFC;
    position: relative;
    overflow: hidden;
}

.jp-auth__card {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 420px;
    background: #FFFFFF;
    border-radius: 20px;
    padding: clamp(28px, 4vw, 40px) clamp(24px, 3.5vw, 36px);
    box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.9);
}

.jp-auth__heading {
    margin-bottom: 28px;
    text-align: left;
}

.jp-auth__portal-badge {
    display: inline-block;
    background: #E0F2FE;
    color: #0284C7 !important;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    padding: 5px 14px;
    border-radius: 20px;
    text-transform: uppercase;
}

.jp-auth__heading-title {
    font-size: clamp(1.65rem, 2.4vw, 1.95rem) !important;
    font-weight: 800 !important;
    color: #0F172A !important;
    letter-spacing: -0.025em !important;
    margin: 12px 0 6px 0 !important;
}

.jp-auth__heading-sub {
    color: #64748B !important;
    font-size: 14px !important;
    line-height: 1.55 !important;
    margin: 0 !important;
}

.jp-auth__actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
}

.jp-auth__sso-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    height: 52px;
    background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);
    color: #FFFFFF !important;
    font-size: 15px !important;
    font-weight: 700 !important;
    border-radius: 12px;
    text-decoration: none !important;
    box-shadow: 0 6px 20px rgba(2, 132, 199, 0.3);
    transition: all 0.2s ease;
    border: none;
}

.jp-auth__sso-btn:hover {
    background: linear-gradient(135deg, #0369A1 0%, #075985 100%);
    box-shadow: 0 8px 25px rgba(2, 132, 199, 0.4);
    transform: translateY(-1px);
    color: #FFFFFF !important;
}

.jp-auth__reg-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 52px;
    background: #FFFFFF;
    border: 1.5px solid #CBD5E1;
    color: #1E293B !important;
    font-size: 14.5px !important;
    font-weight: 650 !important;
    border-radius: 12px;
    text-decoration: none !important;
    box-shadow: 0 2px 4px rgba(15, 23, 42, 0.03);
    transition: all 0.2s ease;
}

.jp-auth__reg-btn:hover {
    border-color: #0284C7;
    color: #0284C7 !important;
    background: #F8FAFC;
}

.jp-auth__divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    color: #94A3B8;
    font-size: 12px;
    font-weight: 500;
}

.jp-auth__divider::before,
.jp-auth__divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #E2E8F0;
}

.jp-auth__help {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px;
    background: #F1F5F9;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
}

.jp-auth__help-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: #E0F2FE;
    border: 1px solid #BAE6FD;
    color: #0284C7 !important;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.jp-auth__help-text {
    color: #475569 !important;
    font-size: 12.5px !important;
    line-height: 1.55 !important;
}

.jp-auth__help-text strong {
    color: #0F172A !important;
    font-weight: 700;
}

.jp-auth__secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
    color: #64748B !important;
    font-family: var(--font-mono, monospace);
    font-size: 11.5px;
}

.jp-auth__secure .jp-icon {
    color: #16A34A;
}

@media (max-width: 991px) {
    .jp-auth__brand {
        padding: clamp(28px, 5vw, 44px) clamp(20px, 4.5vw, 36px);
        min-height: auto;
    }
    .jp-auth__panel {
        padding: clamp(28px, 5vw, 44px) clamp(20px, 4.5vw, 36px);
    }
}
</style>
@endpush

@section('content')
<div class="jp-auth">
    <div class="jp-auth__split">

        {{-- Left: Brand Panel --}}
        <section class="jp-auth__brand">
            <div class="jp-auth__glow jp-auth__glow--1"></div>
            <div class="jp-auth__glow jp-auth__glow--2"></div>

            <div class="jp-auth__brand-inner">
                <div class="jp-auth__logo">
                    <a href="{{ url('/') }}">
                        <img
                            src="{{ asset(file_exists(public_path('img/brand/logo-white.svg')) ? 'img/brand/logo-white.svg' : (file_exists(public_path('img/brand/logo-jarsiplus.svg')) ? 'img/brand/logo-jarsiplus.svg' : 'images/logo-jarsiplus.svg')) }}"
                            alt="Logo JARSIPLUS"
                        >
                    </a>
                </div>

                <span class="jp-auth__brand-badge">PEMERINTAH KOTA SAMARINDA</span>

                <h1 class="jp-auth__brand-title">Jaringan Inovasi Plus Daerah</h1>

                <p class="jp-auth__brand-lead">
                    Platform resmi Bapperida Kota Samarinda untuk pengelolaan,
                    evaluasi, dan publikasi usulan inovasi pelayanan publik
                    &amp; tata kelola pemerintahan daerah.
                </p>

                <div class="jp-auth__features">
                    <div class="jp-auth__feature">
                        <span class="jp-auth__feature-icon">
                            <x-icon name="check" size="20" />
                        </span>
                        <span>
                            <span class="jp-auth__feature-title">Pengajuan Standar IGA</span>
                            <span class="jp-auth__feature-desc">Kriteria Indeks Inovasi Daerah Kementerian Dalam Negeri</span>
                        </span>
                    </div>

                    <div class="jp-auth__feature">
                        <span class="jp-auth__feature-icon">
                            <x-icon name="info" size="20" />
                        </span>
                        <span>
                            <span class="jp-auth__feature-title">Pelacakan Berkas Real-Time</span>
                            <span class="jp-auth__feature-desc">Pantau progres pembahasan oleh Tim Kerja Sama Daerah (TKSD)</span>
                        </span>
                    </div>
                </div>
            </div>

            <footer class="jp-auth__foot">
                <span>// Bapperida Kota Samarinda &copy; {{ date('Y') }}</span>
                <a href="{{ url('/') }}" class="jp-auth__back">
                    <x-icon name="arrow-left" size="14" />
                    Kembali ke Beranda
                </a>
            </footer>
        </section>

        {{-- Right: Form Panel --}}
        <section class="jp-auth__panel">
            <div class="jp-auth__card">

                <header class="jp-auth__heading">
                    <span class="jp-auth__portal-badge">PORTAL INOVATOR</span>
                    <h2 class="jp-auth__heading-title">Masuk ke Portal</h2>
                    <p class="jp-auth__heading-sub">Gunakan akun SSO Pemkot Samarinda yang sudah terverifikasi.</p>
                </header>

                @if(Auth::check())
                    <div class="jp-card jp-card--compact jp-auth__user-card" style="margin-bottom: 20px; padding: 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px;">
                        <span class="text-muted jp-auth__user-label" style="font-size: 11px; display: block;">Masuk sebagai:</span>
                        <strong class="jp-auth__user-name" style="font-size: 15px; color: #0F172A; display: block; margin-top: 2px;">{{ Auth::user()->name }}</strong>
                        <span class="font-mono text-muted jp-auth__user-email" style="font-size: 12px; color: #64748B;">{{ Auth::user()->email }}</span>
                    </div>

                    <div class="jp-auth__actions">
                        <a href="{{ url('/permohonan') }}" class="jp-auth__sso-btn">
                            <x-icon name="user" size="18" />
                            Masuk ke Portal Pemohon
                            <span class="jp-auth__sso-arrow"><x-icon name="arrow-right" size="16" /></span>
                        </a>
                        <a href="{{ route('sso.logout') }}" class="jp-auth__reg-btn">
                            Keluar / Ganti Akun
                        </a>
                    </div>
                @else
                    <div class="jp-auth__actions">
                        <a
                            href="{{ route('sso.authorize') }}"
                            class="jp-auth__sso-btn"
                        >
                            <x-icon name="lock" size="18" />
                            Masuk via SSO Samarinda
                            <span class="jp-auth__sso-arrow"><x-icon name="arrow-right" size="16" /></span>
                        </a>

                        <a
                            href="https://sso.samarindakota.go.id"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="jp-auth__reg-btn"
                        >
                            <x-icon name="user" size="18" />
                            Registrasi Akun SSO Baru
                            <x-icon name="chevron-right" size="16" />
                        </a>
                    </div>

                    <div class="jp-auth__divider">atau</div>

                    <div class="jp-auth__help">
                        <span class="jp-auth__help-icon">
                            <x-icon name="info" size="18" />
                        </span>
                        <span class="jp-auth__help-text">
                            <strong>Petunjuk:</strong>
                            Akun SSO terintegrasi dengan NIK/Email terverifikasi
                            Pemerintah Kota Samarinda.
                        </span>
                    </div>

                    <div class="jp-auth__secure">
                        <x-icon name="shield" size="15" />
                        <span>Terhubung aman via SSO Pemkot Samarinda</span>
                    </div>
                @endif

            </div>
        </section>

    </div>
</div>
@endsection
