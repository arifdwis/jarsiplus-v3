@extends('template::layouts.master',['footer'=>false])

@section('title', 'Edit Profil — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="PROFIL"
    title="Edit Profil"
    desc="Perbarui nama, email, dan foto profil akun Anda."
    :back="route('settings.profile.index')"
    backLabel="Kembali ke Profil"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">
        <div class="jp-card">
            <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data" class="u-flex u-flex-col u-gap-lg">
                @csrf
                @method('PATCH')

                <div class="jp-form-grid">
                    <div class="jp-field">
                        <label class="jp-label" for="profil_name">Nama <span class="jp-label__required">*</span></label>
                        <input type="text" id="profil_name" name="name" class="jp-input" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    </div>
                    <div class="jp-field">
                        <label class="jp-label" for="profil_email">Email <span class="jp-label__required">*</span></label>
                        <input type="email" id="profil_email" name="email" class="jp-input" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div>
                </div>

                <div class="jp-field">
                    <label class="jp-label">Foto Profil</label>
                    @if(auth()->user()->avatar ?? null)
                        <div class="u-mb-sm">
                            <img src="{{ file_url(auth()->user()->avatar) }}" alt="Foto profil saat ini"
                                 style="width: 80px; height: 80px; border-radius: var(--r-md); object-fit: cover; border: 1px solid var(--c-border);">
                        </div>
                    @endif
                    <x-file-drop name="avatar" accept=".jpg,.jpeg,.png" maxSize="2MB" />
                </div>

                <div class="jp-form-foot" style="margin-top: 0;">
                    <a href="{{ route('settings.profile.index') }}" class="jp-btn jp-btn--ghost">Batal</a>
                    <button type="submit" class="jp-btn jp-btn--accent">
                        <x-icon name="check" size="16" />
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
