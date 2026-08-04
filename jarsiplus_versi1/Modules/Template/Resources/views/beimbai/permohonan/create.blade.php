@extends('template::layouts.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            display: block !important;
        }
    </style>
@endsection

@section('content')
    @include("$view.permohonan.form.header")

    <div class="section pb-1 pt-2">
        <h3 class="section-title text-uppercase font-weight-bold pb-0" style="line-height: 1.2">Formulih Inovasi Pemerintah
            Daerah</h3>
        <h5 class="section-subtitle mt-1">Mohon untuk melengkapi semua data untuk Inovasi Pemerintah Daerah</h5>

        {!! Form::open(['route' => ["$prefix.store", 'pengajuan'], 'autocomplete' => 'off', 'files' => true]) !!}
        <span style="font-size: .8rem" class="mb-2">
            (<span style="color: #d93659; font-weight: bold;">*</span>) Tidak boleh kosong
        </span>
        <hr>
        @include("$view.permohonan.form.segment_1")
        @include("$view.permohonan.form.segment_2")
        @include("$view.permohonan.form.segment_3")
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: {
                id: 'null', // the value of the option
                text: '-- Pilih Salah Satu --'
            }
        });

        // Prevent double form submission
        $('form').on('submit', function (e) {
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');

            if ($form.data('submitted') === true) {
                e.preventDefault();
                return false;
            }

            $form.data('submitted', true);
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim...');
        });
    </script>
    <script src="{{asset('js/permohonan.js?v=' . env('APP_VERSION'))}}"></script>
@endsection