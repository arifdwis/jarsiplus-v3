@extends('template::layouts.master')

@section('title', 'Profil Pemohon & Data Instansi — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="PENGATURAN AKUN"
    title="Profil Pemohon & Data Instansi"
    desc="Kelola data diri pemohon dan data unit kerja instansi Kota Samarinda."
    :back="url('/permohonan')"
    backLabel="Kembali ke Dashboard"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        <div class="jp-notice jp-notice--amber u-mb-lg">
            <span class="jp-notice__icon"><x-icon name="info" size="20" /></span>
            <div class="jp-notice__body">
                <strong class="jp-notice__title">Persyaratan wajib pengajuan inovasi</strong>
                <p class="jp-notice__text">
                    Seluruh kolom bertanda bintang (<span class="jp-label__required">*</span>) pada Profil Diri dan Data Instansi
                    wajib diisi lengkap agar Anda dapat mengajukan usulan inovasi daerah baru.
                </p>
            </div>
        </div>

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

        <form action="{{ route('settings.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- 1. Identitas pemohon --}}
            <section class="jp-card u-mb-lg">
                <header class="jp-card-head">
                    <div>
                        <span class="jp-badge jp-badge--accent">BAGIAN 01</span>
                        <h3 class="u-mt-xs u-mb-0">Identitas Pemohon Inovasi</h3>
                        <p class="jp-field__hint u-mt-2xs">Data pribadi pemohon atau inovator pelayanan publik.</p>
                    </div>
                    <x-icon name="user" size="26" style="color: var(--c-ink-subtle);" />
                </header>

                <div class="jp-form-grid u-mb-md">
                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_name">Nama Lengkap Pemohon <span class="jp-label__required">*</span></label>
                        <input type="text" id="pf_name" name="name" class="jp-input" value="{{ old('name', $data->name ?? auth()->user()->name ?? '') }}" required placeholder="Nama sesuai KTP">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_nickname">Nama Panggilan</label>
                        <input type="text" id="pf_nickname" name="nickname" class="jp-input" value="{{ old('nickname', $data->nickname ?? '') }}" placeholder="Nama panggilan">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_nik">NIK <span class="jp-label__required">*</span></label>
                        <input type="text" id="pf_nik" name="nik" class="jp-input font-mono" value="{{ old('nik', $data->nik ?? '') }}" required placeholder="16 digit sesuai KTP">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_nip">NIP</label>
                        <input type="text" id="pf_nip" name="nip" class="jp-input font-mono" value="{{ old('nip', $data->nip ?? '') }}" placeholder="18 digit, kosongkan bila kategori umum">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_email">Alamat Email Pemohon <span class="jp-label__required">*</span></label>
                        <input type="email" id="pf_email" name="email" class="jp-input" value="{{ old('email', $data->email ?? auth()->user()->email ?? '') }}" required placeholder="email@domain.com">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_phone">No. Telepon / WhatsApp <span class="jp-label__required">*</span></label>
                        <input type="text" id="pf_phone" name="phone" class="jp-input font-mono" value="{{ old('phone', $data->phone ?? '') }}" required placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_unit">Sub-Unit Kerja / Bidang <span class="jp-label__required">*</span></label>
                        <input type="text" id="pf_unit" name="unit_kerja" class="jp-input" value="{{ old('unit_kerja', $data->unit_kerja ?? '') }}" required placeholder="Contoh: UPTD Puskesmas / Bidang Inovasi">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_jabatan">Jabatan Pemohon <span class="jp-label__required">*</span></label>
                        <input type="text" id="pf_jabatan" name="jabatan" class="jp-input" value="{{ old('jabatan', $data->jabatan ?? '') }}" required placeholder="Contoh: Kepala Puskesmas / Staf">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_gender">Jenis Kelamin <span class="jp-label__required">*</span></label>
                        <select id="pf_gender" name="gender" class="jp-input" required>
                            <option value="L" {{ old('gender', $data->gender ?? 'L') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $data->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="pf_kota">Kabupaten / Kota Domisili</label>
                        <select id="pf_kota" name="kota_id" class="jp-input">
                            <option value="">-- Pilih Kota / Kabupaten --</option>
                            @foreach($kotas as $k)
                                <option value="{{ $k->id }};{{ $k->name }}" {{ old('kota_id', $data->kota_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="jp-field">
                    <label class="jp-field__label" for="pf_address">Alamat Domisili Lengkap <span class="jp-label__required">*</span></label>
                    <textarea id="pf_address" name="address" class="jp-textarea" rows="2" required placeholder="Alamat domisili lengkap">{{ old('address', $data->address ?? '') }}</textarea>
                </div>
            </section>

            {{-- 2. Data instansi --}}
            <section class="jp-card u-mb-lg">
                <header class="jp-card-head">
                    <div>
                        <span class="jp-badge jp-badge--accent">BAGIAN 02</span>
                        <h3 class="u-mt-xs u-mb-0">Data Unit Kerja &amp; Instansi OPD</h3>
                        <p class="jp-field__hint u-mt-2xs">Informasi resmi Perangkat Daerah tempat pengusul bertugas.</p>
                    </div>
                    <x-icon name="building" size="26" style="color: var(--c-ink-subtle);" />
                </header>

                <div class="jp-form-grid u-mb-md">
                    <div class="jp-field">
                        <label class="jp-field__label" for="cp_name">Nama Instansi / OPD <span class="jp-label__required">*</span></label>
                        <input type="text" id="cp_name" name="corporate_name" class="jp-input" value="{{ old('corporate_name', $corporate->name ?? $data->unit_kerja ?? '') }}" required placeholder="Badan / Dinas / UPTD">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="cp_website">Website Resmi Instansi</label>
                        <input type="text" id="cp_website" name="corporate_website" class="jp-input" value="{{ old('corporate_website', $corporate->website ?? '') }}" placeholder="https://instansi.samarindakota.go.id">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="cp_phone">No. Telepon Kantor <span class="jp-label__required">*</span></label>
                        <input type="text" id="cp_phone" name="corporate_phone" class="jp-input font-mono" value="{{ old('corporate_phone', $corporate->phone ?? '') }}" required placeholder="(0541) xxxxxx">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="cp_email">Email Resmi Instansi <span class="jp-label__required">*</span></label>
                        <input type="email" id="cp_email" name="corporate_email" class="jp-input" value="{{ old('corporate_email', $corporate->email ?? '') }}" required placeholder="instansi@samarindakota.go.id">
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="cp_kota">Kabupaten / Kota Kantor</label>
                        <select id="cp_kota" name="corporate_kota_id" class="jp-input">
                            <option value="">-- Pilih Kota / Kabupaten --</option>
                            @foreach($kotas as $k)
                                <option value="{{ $k->id }};{{ $k->name }}" {{ old('corporate_kota_id', $corporate->kota_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="jp-field">
                        <label class="jp-field__label" for="cp_pos">Kode Pos Kantor</label>
                        <input type="text" id="cp_pos" name="corporate_postal_code" class="jp-input font-mono" value="{{ old('corporate_postal_code', $corporate->postal_code ?? '') }}" placeholder="75123">
                    </div>
                </div>

                <div class="jp-field">
                    <label class="jp-field__label" for="cp_address">Alamat Kantor Lengkap <span class="jp-label__required">*</span></label>
                    <textarea id="cp_address" name="corporate_address" class="jp-textarea" rows="2" required placeholder="Alamat kantor Perangkat Daerah">{{ old('corporate_address', $corporate->address ?? '') }}</textarea>
                </div>
            </section>

            <div class="jp-card jp-form-foot" style="margin-top: 0;">
                <a href="{{ url('/permohonan') }}" class="jp-btn jp-btn--ghost">Batal &amp; Kembali</a>
                <button type="submit" class="jp-btn jp-btn--accent jp-btn--lg">
                    <x-icon name="check" size="18" />
                    Simpan Profil &amp; Data Instansi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
