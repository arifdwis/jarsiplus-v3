@extends('template::layouts.master')

@section('title', 'Pengaturan Akun — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="AKUN &amp; PROFIL"
    title="Pengaturan Akun Pemohon"
    desc="Kelola biodata diri dan data instansi yang dipakai pada setiap pengajuan inovasi."
    :back="url('/permohonan')"
    backLabel="Kembali ke Dashboard"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">
        <div class="l-grid l-grid--2">
            <a href="{{ route('settings.profile.index') }}" class="jp-action-card jp-action-card--accent">
                <div>
                    <span class="jp-action-card__icon-box"><x-icon name="user" size="22" /></span>
                    <h3 class="jp-action-card__title">Biodata Diri</h3>
                    <p class="jp-action-card__desc">Kelola profil, NIK, NIP, dan data kontak pribadi Anda.</p>
                </div>
                <span class="jp-action-card__link">Pengaturan Biodata <span aria-hidden="true">&rarr;</span></span>
            </a>

            <a href="{{ route('settings.corporate.index') }}" class="jp-action-card jp-action-card--teal">
                <div>
                    <span class="jp-action-card__icon-box jp-action-card__icon-box--teal"><x-icon name="building" size="22" /></span>
                    <h3 class="jp-action-card__title">Data Instansi</h3>
                    <p class="jp-action-card__desc">Kelola nama instansi/OPD, kontak resmi, dan alamat kantor.</p>
                </div>
                <span class="jp-action-card__link">Pengaturan Instansi <span aria-hidden="true">&rarr;</span></span>
            </a>
        </div>
    </div>
</div>
@endsection
