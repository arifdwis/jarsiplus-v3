@extends('template::layouts.master')

@section('title', 'Unit Kerja & Instansi (Corporate) — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<div class="jp-section" style="padding-top: 36px; padding-bottom: 56px;">
    <div class="l-container" style="max-width: 900px;">
        {{-- Section Header --}}
        <div class="jp-section__head u-mb-lg">
            <span class="jp-badge jp-badge--accent u-mb-xs">PENGATURAN AKUN</span>
            <h1 class="jp-section__title" style="margin-bottom: 4px;">Unit Kerja &amp; Profil Instansi</h1>
            <p style="color:var(--c-text-muted); font-size: var(--t-sm); margin-bottom: 0;">Kelola data profil Perangkat Daerah, OPD, dan Alamat Instansi (`pemohon_corporate`).</p>
        </div>

        {{-- Tab Navigation Strip --}}
        <div class="u-flex u-gap-xs u-mb-lg" style="border-bottom: 2px solid var(--c-border); padding-bottom: 2px;">
            <a href="{{ route('settings.profile.index') }}" class="jp-btn jp-btn--ghost jp-btn--sm" style="border-radius: 6px 6px 0 0; color: var(--c-text-muted);">
                <x-icon name="user" size="16" />
                Ubah Profil (Pemohon)
            </a>
            <a href="{{ route('settings.corporate.index') }}" class="jp-btn jp-btn--accent jp-btn--sm" style="border-radius: 6px 6px 0 0; font-weight: 700;">
                <x-icon name="info" size="16" />
                Unit Kerja &amp; Instansi (Corporate)
            </a>
        </div>

        {{-- Form Content Card --}}
        <div class="jp-card" style="padding: 32px; background: #FFFFFF; border: 1px solid var(--c-border); box-shadow: var(--shadow-soft);">
            <form action="{{ route('settings.corporate.update', $data->uuid ?? 'default') }}" method="POST" class="u-flex u-flex-col u-gap-lg">
                @csrf
                @method('PUT')

                <div>
                    <h4 style="font-size: 1.05rem; color: var(--c-text); margin-bottom: 16px; font-weight: 700; border-bottom: 1px solid var(--c-border); padding-bottom: 8px;">
                        Data Profil Instansi                    </h4>

                    <div class="l-grid l-grid--2 u-mb-md">
                        <div class="jp-field">
                            <label class="jp-field__label">Nama Instansi / Perangkat Daerah <span style="color:var(--c-danger)">*</span></label>
                            <input type="text" name="name" class="jp-input" value="{{ old('name', $data->name ?? me()->pemohon->unit_kerja ?? '') }}" required placeholder="Nama instansi lengkap (contoh: Badan Perencanaan Pembangunan Daerah)...">
                        </div>
                        <div class="jp-field">
                            <label class="jp-field__label">Website Resmi Instansi</label>
                            <input type="text" name="website" class="jp-input" value="{{ old('website', $data->website ?? '') }}" placeholder="https://bapperida.samarindakota.go.id">
                        </div>
                    </div>

                    <div class="l-grid l-grid--2 u-mb-md">
                        <div class="jp-field">
                            <label class="jp-field__label">No. Telepon Kantor</label>
                            <input type="text" name="phone" class="jp-input" value="{{ old('phone', $data->phone ?? '') }}" placeholder="(0541) xxxxxx">
                        </div>
                        <div class="jp-field">
                            <label class="jp-field__label">Email Resmi Instansi</label>
                            <input type="email" name="email" class="jp-input" value="{{ old('email', $data->email ?? '') }}" placeholder="instansi@samarindakota.go.id">
                        </div>
                    </div>

                    <div class="l-grid l-grid--2 u-mb-md">
                        <div class="jp-field">
                            <label class="jp-field__label">Kabupaten / Kota Kantor</label>
                            <select name="kota_id" class="jp-input">
                                <option value="">-- Pilih Kota / Kabupaten --</option>
                                @foreach($kotas as $k)
                                    <option value="{{ $k->id }};{{ $k->name }}" {{ old('kota_id', $data->kota_id ?? '') == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="jp-field">
                            <label class="jp-field__label">Kode Pos Kantor</label>
                            <input type="text" name="postal_code" class="jp-input" value="{{ old('postal_code', $data->postal_code ?? '') }}" placeholder="75123">
                        </div>
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label">Alamat Kantor Lengkap</label>
                        <textarea name="address" class="jp-input" rows="3" placeholder="Jl. Balai Kota No. 1, Samarinda...">{{ old('address', $data->address ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-md u-mt-lg pt-3" style="border-top: 1px solid var(--c-border);">
                    <a href="{{ url('/permohonan') }}" class="jp-btn jp-btn--ghost">&larr; Kembali ke Dashboard</a>
                    <button type="submit" class="jp-btn jp-btn--accent" style="padding: 11px 24px;">
                        <x-icon name="check" size="16" />
                        Simpan Profil Instansi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection