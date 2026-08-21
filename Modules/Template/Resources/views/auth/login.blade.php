@extends('template::layouts.master')

@section('title', 'Masuk Portal Pemohon — JARSIPLUS Kota Samarinda')

@push('css')
<style>
/* ============================================================
   ASYMMETRIC SPLIT AUTH — COBALT CIVIC
   Hallmark · macrostructure: Asymmetric Split Auth · theme: Cobalt Civic · enrichment: none
   ============================================================ */

/* Page flows naturally — no viewport locking */
.jp-auth {
    display: grid;
    grid-template-columns: 1fr;
    min-height: 100vh;
    min-height: 100dvh;
    background-color: var(--c-bg);
}

@media (min-width: 900px) {
    .jp-auth {
        grid-template-columns: 1.15fr 0.85fr;
    }
}

/* ------------------------------------------------------------
   LEFT PANEL: BRAND (GRAPHITE SURFACE)
   ------------------------------------------------------------ */
.jp-auth__brand {
    position: relative;
    background-color: var(--c-graphite);
    color: #FFFFFF;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: clamp(40px, 5vw, 64px) clamp(32px, 4.5vw, 60px);
    border-right: 1px solid var(--c-graphite-border);
}

.jp-auth__brand::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: radial-gradient(ellipse at 25% 15%, rgba(0, 0, 0, 0.5) 0%, transparent 65%);
    pointer-events: none;
}

.jp-auth__brand-inner {
    position: relative;
    z-index: 1;
    max-width: 480px;
}

.jp-auth__logo {
    display: inline-flex;
    align-items: center;
    margin-bottom: clamp(24px, 3vw, 40px);
}

.jp-auth__logo img {
    height: 44px;
    width: auto;
}

.jp-auth__brand-title {
    font-size: clamp(2rem, 3vw, 2.75rem);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.03em;
    color: #FFFFFF;
    margin: 0 0 16px 0;
    text-wrap: balance;
}

.jp-auth__brand-lead {
    color: rgba(255, 255, 255, 0.68);
    font-size: 15px;
    line-height: 1.7;
    margin: 0;
    font-weight: 400;
    max-width: 52ch;
}

.jp-auth__brand-foot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: var(--s-md);
    border-top: 1px solid var(--c-graphite-border);
    padding-top: var(--s-lg);
    color: rgba(255, 255, 255, 0.38);
    font-family: var(--font-mono);
    font-size: var(--t-2xs);
    flex-wrap: wrap;
}

.jp-auth__back-link {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    font-size: 13.5px;
    transition: color var(--duration-fast) var(--ease-std);
}

.jp-auth__back-link:hover {
    color: #FFFFFF;
}

/* ------------------------------------------------------------
   RIGHT PANEL: FORM (LIGHT SURFACE)
   ------------------------------------------------------------ */
.jp-auth__form-panel {
    background-color: var(--c-bg);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: clamp(32px, 4vw, 56px) clamp(32px, 4.5vw, 60px);
}

.jp-auth__form-inner {
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
}

.jp-auth__heading {
    margin-bottom: var(--s-xl);
}

.jp-auth__heading-title {
    font-size: clamp(1.6rem, 2.2vw, 1.95rem);
    font-weight: 800;
    color: var(--c-ink);
    letter-spacing: -0.025em;
    margin: 0 0 8px 0;
    line-height: 1.2;
}

.jp-auth__heading-sub {
    color: var(--c-ink-muted);
    font-size: var(--t-sm);
    line-height: 1.55;
    margin: 0;
}

/* Authenticated state */
.jp-auth__user-card {
    padding: var(--s-md) var(--s-lg);
    margin-bottom: var(--s-lg);
    background-color: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: var(--r-md);
}

.jp-auth__user-label {
    font-size: var(--t-2xs);
    color: var(--c-ink-subtle);
    display: block;
    margin-bottom: 2px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.jp-auth__user-name {
    display: block;
    font-size: var(--t-base);
    font-weight: 700;
    color: var(--c-ink);
    margin-bottom: 2px;
}

.jp-auth__user-email {
    font-size: var(--t-2xs);
    color: var(--c-ink-muted);
    font-family: var(--font-mono);
}

/* Actions */
.jp-auth__actions {
    display: flex;
    flex-direction: column;
    gap: var(--s-sm);
    margin-bottom: var(--s-lg);
}

.jp-auth__sso-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    height: 48px;
    background-color: var(--c-accent);
    color: #FFFFFF !important;
    font-size: var(--t-sm);
    font-weight: 650;
    font-family: var(--font-heading);
    border-radius: var(--r-btn);
    text-decoration: none !important;
    border: none;
    box-shadow: var(--shadow-soft);
    transition: background-color var(--duration-fast) var(--ease-std),
                box-shadow var(--duration-fast) var(--ease-std);
}

.jp-auth__sso-btn:hover {
    background-color: var(--c-accent-hover);
    box-shadow: var(--shadow-md);
    color: #FFFFFF !important;
}

.jp-auth__sso-btn:focus-visible {
    outline: 2px solid var(--c-accent);
    outline-offset: 2px;
}

.jp-auth__reg-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 48px;
    background-color: var(--c-surface);
    border: 1px solid var(--c-border);
    color: var(--c-ink) !important;
    font-size: var(--t-sm);
    font-weight: 600;
    font-family: var(--font-heading);
    border-radius: var(--r-btn);
    text-decoration: none !important;
    box-shadow: var(--shadow-xs);
    transition: border-color var(--duration-fast) var(--ease-std),
                background-color var(--duration-fast) var(--ease-std),
                color var(--duration-fast) var(--ease-std);
}

.jp-auth__reg-btn:hover {
    border-color: var(--c-accent);
    color: var(--c-accent) !important;
    background-color: var(--c-accent-soft);
}

.jp-auth__reg-btn:focus-visible {
    outline: 2px solid var(--c-accent);
    outline-offset: 2px;
}

/* Divider */
.jp-auth__divider {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: var(--s-lg);
    color: var(--c-ink-subtle);
    font-size: var(--t-xs);
    font-weight: 500;
}

.jp-auth__divider::before,
.jp-auth__divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background-color: var(--c-border);
}

/* Help card */
.jp-auth__help {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    background-color: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: var(--r-md);
}

.jp-auth__help-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background-color: var(--c-accent-soft);
    border: 1px solid var(--c-accent-line);
    color: var(--c-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

.jp-auth__help-text {
    color: var(--c-ink-muted);
    font-size: var(--t-xs);
    line-height: 1.6;
}

.jp-auth__help-text strong {
    color: var(--c-ink);
    font-weight: 650;
}

/* Secure badge */
.jp-auth__secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: var(--s-lg);
    color: var(--c-ink-subtle);
    font-family: var(--font-mono);
    font-size: var(--t-2xs);
}

.jp-auth__secure .jp-icon {
    color: var(--c-success);
}

/* Mobile adjustments */
@media (max-width: 899px) {
    .jp-auth__brand {
        padding: clamp(32px, 5vw, 48px) clamp(24px, 4.5vw, 36px);
        text-align: left;
    }

    .jp-auth__brand-title {
        text-align: left;
    }

    .jp-auth__brand-lead {
        text-align: left;
    }

    .jp-auth__form-panel {
        padding: clamp(28px, 4vw, 40px) clamp(20px, 4.5vw, 32px);
    }

    .jp-auth__heading-title {
        text-align: left;
    }

    .jp-auth__heading-sub {
        text-align: left;
    }
}
</style>
@endpush

@section('content')
<div class="jp-auth">

    {{-- Left: Brand Panel --}}
    <section class="jp-auth__brand" aria-labelledby="brand-title">
        <div class="jp-auth__brand-inner">
            <div class="jp-auth__logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/brand/logo-white.svg') }}" alt="Logo JARSIPLUS">
                </a>
            </div>

            <div>
                <h1 id="brand-title" class="jp-auth__brand-title">Jaringan Aplikasi Inovasi Plus Kota Samarinda</h1>
                <p class="jp-auth__brand-lead">
                    Platform resmi Bapperida Kota Samarinda untuk pengelolaan,
                    evaluasi, dan publikasi usulan inovasi pelayanan publik
                    & tata kelola pemerintahan daerah.
                </p>
            </div>

            <div class="jp-auth__brand-foot">
                <a href="{{ url('/') }}" class="jp-auth__back-link">
                    <x-icon name="arrow-left" size="14" />
                    Kembali ke Beranda
                </a>
                <span>Cobalt Civic v3.1</span>
            </div>
        </div>
    </section>

    {{-- Right: Form Panel --}}
    <section class="jp-auth__form-panel">
        <div class="jp-auth__form-inner">

            <div class="jp-auth__heading">
                <h2 class="jp-auth__heading-title">Masuk ke Portal</h2>
                <p class="jp-auth__heading-sub">Gunakan akun SSO Pemkot Samarinda yang sudah terverifikasi.</p>
            </div>

            @if(Auth::check())
                <div class="jp-auth__user-card">
                    <span class="jp-auth__user-label">Masuk sebagai</span>
                    <strong class="jp-auth__user-name">{{ Auth::user()->name }}</strong>
                    <span class="jp-auth__user-email">{{ Auth::user()->email }}</span>
                </div>

                <div class="jp-auth__actions">
                    <a href="{{ url('/permohonan') }}" class="jp-auth__sso-btn">
                        <x-icon name="user" size="18" />
                        Masuk ke Portal Pemohon
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

            <div class="jp-auth__secure">
                <x-icon name="shield" size="14" />
                <span>Portal terenkripsi end-to-end</span>
            </div>

        </div>
    </section>

</div>
@endsection