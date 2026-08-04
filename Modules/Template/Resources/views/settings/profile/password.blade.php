@extends('template::layouts.master')

@section('title', 'Ubah Password — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="PENGATURAN AKUN"
    title="Ubah Password Akun"
    desc="Perbarui kata sandi keamanan akun Anda."
    :back="route('settings.profile.index')"
    backLabel="Kembali ke Profil"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">
        @if ($errors->any())
            <div class="jp-notice jp-notice--danger u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="alert-circle" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Perbaiki isian berikut</strong>
                    <ul class="jp-notice__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="jp-card">
            <form action="{{ route('settings.profile.update') }}" method="POST" class="u-flex u-flex-col u-gap-md">
                @csrf
                @method('PATCH')

                <div class="jp-field">
                    <label class="jp-field__label" for="old_password">Password Saat Ini</label>
                    <input type="password" id="old_password" name="old_password" class="jp-input" placeholder="Masukkan password lama" required>
                </div>

                <div class="jp-field">
                    <label class="jp-field__label" for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="jp-input" placeholder="Minimal 8 karakter" required>
                    <p class="jp-field__hint">Gunakan kombinasi huruf, angka, dan simbol agar lebih aman.</p>
                </div>

                <div class="jp-field">
                    <label class="jp-field__label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="jp-input" placeholder="Ulangi password baru" required>
                </div>

                <div class="jp-form-foot">
                    <a href="{{ route('settings.profile.index') }}" class="jp-btn jp-btn--ghost">Batal</a>
                    <button type="submit" class="jp-btn jp-btn--accent">
                        <x-icon name="check" size="16" />
                        Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
