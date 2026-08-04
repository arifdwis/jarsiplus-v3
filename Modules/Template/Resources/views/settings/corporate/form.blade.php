@extends('template::layouts.master',['footer'=>false])

@section('content')
<div class="jp-section">
    <div class="l-container">
        <div class="jp-section__head u-flex u-justify-between u-align-center u-flex-wrap u-gap-md u-mb-xl">
            <div>
                <p class="jp-section__eyebrow">
                    <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                    INSTANSI
                </p>
                <h1 class="jp-section__title" style="margin-bottom:0">Edit Profil Instansi</h1>
            </div>
        </div>

        <div class="jp-card">
            <form action="{{ route('settings.corporate.profile.update') }}" method="POST" class="u-flex u-flex-col u-gap-lg" style="padding:var(--p-card) !important">
                @csrf
                @method('PATCH')

                <x-field id="nama" name="nama" label="Nama Instansi" value="{{ old('nama', $instansi->nama ?? '') }}" type="text" required />

                <x-field id="singular" name="singular" label="Singkatan" value="{{ old('singular', $instansi->singular ?? '') }}" type="text" required />

                <x-field id="desc" name="desc" label="Deskripsi" value="{{ old('desc', $instansi->desc ?? '') }}" type="text" />

                <div class="jp-field">
                    <label class="jp-label">Logo</label>
                    @if($instansi->logo ?? null)
                        <div class="u-mb-sm">
                            <img src="{{ asset('storage/'.$instansi->logo) }}" alt="Logo" style="max-height:80px;border-radius:var(--r-card)">
                        </div>
                    @endif
                    <x-file-drop name="logo" accept=".svg,.png,.jpg,.jpeg" />
                </div>

                <div class="jp-divider"></div>
                <div class="u-flex u-justify-end u-gap-md">
                    <a href="{{ route('settings.corporate.index') }}" class="jp-btn jp-btn--ghost">Batal</a>
                    <button type="submit" class="jp-btn jp-btn--accent">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection