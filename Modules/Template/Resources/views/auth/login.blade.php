@extends('template::layouts.master')

@section('title', 'Masuk — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<section class="jp-section">
    <div class="l-container">
        <div class="u-max-w-600 u-mx-auto">
            <div class="jp-data-card">
                <div class="jp-data-card__bar">
                    <span class="jp-data-card__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                    <span class="jp-data-card__file">portal.pemohon</span>
                    <span class="jp-data-card__status">
                        <span class="jp-data-card__status-dot" aria-hidden="true"></span>
                        sso
                    </span>
                </div>
                <div class="jp-data-card__body" style="font-family:var(--font-body)">
                    <h2 style="font-size:var(--t-2xl);margin-bottom:4px">Masuk Portal Pemohon</h2>
                    <p class="u-mb-lg" style="color:var(--c-text-muted); font-size:var(--t-sm)">Gunakan akun SSO Pemerintah Kota Samarinda untuk masuk.</p>

                    <form method="POST" action="{{ route('sso.login') }}" class="u-flex u-flex-col u-gap-sm">
                        @csrf
                        <div class="jp-field">
                            <label class="jp-field__label">Email / NIP</label>
                            <input type="text" name="email" class="jp-input" placeholder="email@samarindakota.go.id" required autofocus>
                        </div>
                        <div class="jp-field">
                            <label class="jp-field__label">Kata Sandi</label>
                            <input type="password" name="password" class="jp-input" placeholder="Masukkan kata sandi" required>
                        </div>
                        <button type="submit" class="jp-btn jp-btn--accent u-w-100 u-mt-md">
                            <x-icon name="lock" size="18" />
                            Masuk
                        </button>
                    </form>

                    <div class="u-text-center u-mt-lg" style="font-size:var(--t-xs);color:var(--c-text-muted)">
                        Belum punya akun? Hubungi admin instansi Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
