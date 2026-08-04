@extends('template::layouts.master')

@section('title', 'Upload Data Dukung — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="UPLOAD DATA DUKUNG"
    :title="$parent->label_indikator ?? 'Upload Berkas'"
    desc="Unggah dokumen atau tautan resmi sebagai bukti dukung indikator. Ukuran berkas maksimal 10 MB."
    :back="route('indikator.data.index', $parent->uuid)"
    backLabel="Kembali ke Data Dukung"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">

        @if ($errors->any())
            <div class="jp-notice jp-notice--danger u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="alert-circle" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Terjadi kesalahan pengisian</strong>
                    <ul class="jp-notice__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="jp-card">
            {!! Form::open(['route' => ["$prefix.store", $parent->uuid], 'autocomplete' => 'off', 'files' => true]) !!}
                @include("$view.form")

                <div class="jp-form-foot">
                    <a href="{{ route('indikator.data.index', $parent->uuid) }}" class="jp-btn jp-btn--ghost">Batal</a>
                    <button type="submit" class="jp-btn jp-btn--accent jp-btn--lg">
                        <x-icon name="check" size="18" />
                        Simpan Berkas Data Dukung
                    </button>
                </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    function toggleFields() {
        var jenis = $('#jenis').val();
        if (jenis === 'url') {
            $('#field-url').show();
            $('#field-file').hide();
            $('#file-upload').val('');
        } else {
            $('#field-url').hide();
            $('#field-file').show();
            $('input[name="url"]').val('');
        }
    }

    $(document).ready(function() {
        toggleFields();
        $('#jenis').on('change', function () {
            toggleFields();
        });

        $('#file-upload').on('change', function () {
            var file = this.files[0];
            if (file && file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10 MB! File yang dipilih: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB');
                $(this).val('');
            }
        });
    });
</script>
@endsection
