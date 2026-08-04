@extends('template::layouts.master')

@section('title', 'Kirim Inovasi Daerah — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="KIRIM INOVASI"
    :title="$data->label"
    :back="route('permohonan.show', $data->kode ?? $data->uuid)"
    backLabel="Kembali ke Rincian Menu"
/>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $data->kode }}</span>
        <span class="jp-subhead__meta">
            <x-icon name="user" size="14" />
            {{ optional($data->pemohon1)->name ?? me()->name }}
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="building" size="14" />
            {{ optional($data->pemohon1)->unit_kerja ?? 'Instansi belum dicantumkan' }}
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">

        {!! Form::open(['route' => ['permohonan.kirim', $data->uuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT', 'id' => 'formKirimInovasi']) !!}
            <input type="hidden" name="status" value="2">

            <div class="jp-card jp-card--featured">
                <div class="u-text-center u-mb-lg">
                    <span class="jp-result-head__icon" style="background-color: var(--c-accent-soft); border-color: var(--c-accent-line); color: var(--c-accent); margin-inline: auto;">
                        <x-icon name="check-circle" size="30" />
                    </span>
                    <h2 class="u-mt-sm u-mb-xs">Konfirmasi Pengiriman Inovasi</h2>
                    <p class="jp-section__desc">
                        Pengiriman berkas akhir inovasi untuk ditinjau oleh Tim Kerja Sama Daerah (TKSD).
                    </p>
                </div>

                <div class="jp-notice jp-notice--amber u-mb-lg">
                    <span class="jp-notice__icon"><x-icon name="alert-triangle" size="20" /></span>
                    <div class="jp-notice__body">
                        <strong class="jp-notice__title">Periksa ulang sebelum mengirim</strong>
                        <p class="jp-notice__text">
                            Mohon cek kembali seluruh data formulir dan dokumen indikator bukti dukung yang telah Anda unggah.
                            Setelah dikirim, berkas usulan akan <strong>terkunci</strong> dan tidak dapat diubah selama proses evaluasi juri.
                        </p>
                    </div>
                </div>

                <label class="jp-consent u-mb-lg">
                    <input type="checkbox" id="agreeSubmitCheck" required>
                    <span>Saya telah mengecek ulang seluruh data dan menyatakan siap mengirimkan usulan inovasi ini.</span>
                </label>

                <div class="jp-form-foot" style="margin-top: 0;">
                    <a href="{{ route('permohonan.show', $data->kode ?? $data->uuid) }}" class="jp-btn jp-btn--ghost">Batal</a>
                    <button type="submit" class="jp-btn jp-btn--accent jp-btn--lg" id="btnSubmitKirim">
                        <x-icon name="check" size="18" />
                        Kirim Berkas Inovasi
                    </button>
                </div>
            </div>
        {!! Form::close() !!}

    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('formKirimInovasi');
    if (form) {
        form.addEventListener('submit', function (e) {
            var check = document.getElementById('agreeSubmitCheck');
            if (check && !check.checked) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Konfirmasi Diperlukan',
                        text: 'Harap centang persetujuan terlebih dahulu sebelum mengirimkan berkas.',
                        icon: 'warning',
                        confirmButtonColor: '#1B4DD1'
                    });
                } else {
                    alert('Harap centang persetujuan terlebih dahulu.');
                }
            }
        });
    }
});
</script>
@endsection
