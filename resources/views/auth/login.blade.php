@extends('template::layouts.master')

@section('title', 'Masuk Portal Pemohon — JARSIPLUS Kota Samarinda')

@push('css')
<style>
/* ============================================================
   CLEAN MINIMALIST LOGIN PAGE — JARSIPLUS COBALT
   ============================================================ */
.jp-auth {
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    background: #FFFFFF;
}

.jp-auth__split {
    display: grid;
    grid-template-columns: 1fr;
    width: 100%;
    min-height: 100vh;
    min-height: 100dvh;
}

@media (min-width: 992px) {
    .jp-auth__split {
        grid-template-columns: 50% 50%;
    }
}

/* ------------------------------------------------------------
   LEFT PANEL: BRAND (DARK COBALT NAVY)
   ------------------------------------------------------------ */
.jp-auth__brand {
    position: relative;
    overflow: hidden;
    background: linear-gradient(160deg, #06111F 0%, #0D213F 55%, #050D19 100%);
    color: #FFFFFF !important;
    display: flex;
    flex-direction: column;
}

.jp-auth__brand::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    mask-image: radial-gradient(ellipse at 30% 20%, rgba(0, 0, 0, 0.7) 0%, transparent 75%);
    pointer-events: none;
}

.jp-auth__glow {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.jp-auth__glow--1 {
    top: -120px;
    right: -120px;
    width: 480px;
    height: 480px;
    background: radial-gradient(circle, rgba(2, 132, 199, 0.22) 0%, transparent 65%);
}

.jp-auth__glow--2 {
    bottom: -100px;
    left: -100px;
    width: 380px;
    height: 380px;
    background: radial-gradient(circle, rgba(56, 189, 248, 0.12) 0%, transparent 60%);
}

.jp-auth__brand-inner {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: clamp(36px, 5vw, 64px) clamp(32px, 5vw, 64px);
    box-sizing: border-box;
}

.jp-auth__head-left {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: clamp(32px, 4vw, 56px);
}

.jp-auth__logo img {
    height: 52px;
    width: auto;
    display: block;
    filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
}

.jp-auth__main-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 480px;
}

.jp-auth__brand-title {
    font-size: clamp(2.2rem, 3.5vw, 3rem) !important;
    font-weight: 800 !important;
    line-height: 1.15 !important;
    letter-spacing: -0.035em !important;
    color: #FFFFFF !important;
    margin: 0 0 20px 0 !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
}

.jp-auth__brand-lead {
    color: #CBD5E1 !important;
    font-size: 15.5px !important;
    line-height: 1.7 !important;
    margin: 0 !important;
    font-weight: 400;
}

.jp-auth__foot-left {
    position: relative;
    z-index: 2;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 20px;
    margin-top: 32px;
    color: #94A3B8 !important;
    font-family: var(--font-mono, monospace);
    font-size: 12px;
}

/* ------------------------------------------------------------
   RIGHT PANEL: FORM (WHITE & HIGH CONTRAST)
   ------------------------------------------------------------ */
.jp-auth__form-panel {
    background: #FFFFFF;
    display: flex;
    flex-direction: column;
}

.jp-auth__form-inner {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: clamp(36px, 5vw, 64px) clamp(32px, 5vw, 64px);
    box-sizing: border-box;
}

.jp-auth__head-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-bottom: clamp(32px, 4vw, 56px);
}

.jp-auth__back-link {
    color: #64748B !important;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    font-size: 13.5px;
    transition: color 0.18s ease;
}

.jp-auth__back-link:hover {
    color: #0284C7 !important;
}

.jp-auth__form-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 420px;
    margin: 0 auto;
    width: 100%;
}

.jp-auth__heading-title {
    font-size: clamp(2rem, 2.8vw, 2.4rem) !important;
    font-weight: 800 !important;
    color: #0F172A !important;
    letter-spacing: -0.03em !important;
    margin: 0 0 10px 0 !important;
    line-height: 1.2 !important;
}

.jp-auth__heading-sub {
    color: #64748B !important;
    font-size: 14.5px !important;
    line-height: 1.55 !important;
    margin: 0 0 36px 0 !important;
}

.jp-auth__actions {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 28px;
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

.jp-auth__sso-arrow {
    display: inline-flex;
    align-items: center;
    margin-left: 4px;
    transition: transform 0.2s ease;
}

.jp-auth__sso-btn:hover .jp-auth__sso-arrow {
    transform: translateX(4px);
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
    gap: 14px;
    margin-bottom: 28px;
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
    background: #F8FAFC;
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

.jp-auth__foot-right {
    border-top: 1px solid #F1F5F9;
    padding-top: 20px;
    margin-top: 32px;
}

.jp-auth__secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #64748B !important;
    font-family: var(--font-mono, monospace);
    font-size: 11.5px;
}

.jp-auth__secure .jp-icon {
    color: #16A34A;
}

@media (max-width: 991px) {
    .jp-auth__brand-inner,
    .jp-auth__form-inner {
        padding: clamp(28px, 5vw, 44px) clamp(20px, 4.5vw, 36px);
        min-height: auto;
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
                <div class="jp-auth__head-left">
                    <a href="{{ url('/') }}" class="jp-auth__logo">
                        <img src="{{ asset('img/brand/logo-white.svg') }}" alt="Logo JARSIPLUS">
                    </a>
                </div>

                <div class="jp-auth__main-left">
                    <h1 class="jp-auth__brand-title">Jaringan Inovasi Plus Daerah</h1>
                    <p class="jp-auth__brand-lead">
                        Platform resmi Bapperida Kota Samarinda untuk pengelolaan,
                        evaluasi, dan publikasi usulan inovasi pelayanan publik
                        &amp; tata kelola pemerintahan daerah.
                    </p>
                </div>

                <footer class="jp-auth__foot-left">
                    <span>// Bapperida Kota Samarinda &copy; {{ date('Y') }}</span>
                </footer>
            </div>
        </section>

        {{-- Right: Form Panel --}}
        <section class="jp-auth__form-panel">
            <div class="jp-auth__form-inner">
                <div class="jp-auth__head-right">
                    <a href="{{ url('/') }}" class="jp-auth__back-link">
                        <x-icon name="arrow-left" size="14" />
                        Kembali ke Beranda
                    </a>
                </div>

                <div class="jp-auth__form-main">
                    <h2 class="jp-auth__heading-title">Masuk ke Portal</h2>
                    <p class="jp-auth__heading-sub">Gunakan akun SSO Pemkot Samarinda yang sudah terverifikasi.</p>

                    @if(Auth::check())
                        <div style="margin-bottom: 24px; padding: 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px;">
                            <span style="font-size: 11px; color: #64748B; display: block;">Masuk sebagai:</span>
                            <strong style="font-size: 15px; color: #0F172A; display: block; margin-top: 2px;">{{ Auth::user()->name }}</strong>
                            <span style="font-size: 12px; color: #64748B; font-family: monospace;">{{ Auth::user()->email }}</span>
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
                    @endif
                </div>

                <footer class="jp-auth__foot-right">
                    <div class="jp-auth__secure">
                        <x-icon name="shield" size="15" />
                        <span>Terhubung aman via SSO Pemkot Samarinda</span>
                    </div>
                </footer>
            </div>
        </section>

    </div>
</div>
@endsection
