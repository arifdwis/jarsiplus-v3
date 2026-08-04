@extends('template::layouts.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <section class="page-header">
        <div class="header-light text-center mb-3">
            <h1 class="title">{{$parent->indikators->label}}</h1>
            <h4 class="subtitle">Maksimal File Untuk Data Dukung 10 MB</h4>
            <a href="{{ route('indikator.data.index', $parent->uuid) }}"
                style="display: inline-block; margin-top: 10px; padding: 6px 16px; background: rgba(255,255,255,0.2); color: #fff; border-radius: 20px; font-size: 13px; text-decoration: none; border: 1px solid rgba(255,255,255,0.4);">
                ← Kembali ke Data Dukung
            </a>
        </div>
    </section>
    <svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
        <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z"
            fill="#f9f9f9"></path>
    </svg>

    <div class="section pb-1 pt-2">
        @if ($errors->any())
            <div class="alert alert-danger mb-2">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(['route' => ["$prefix.store", $parent->uuid], 'autocomplete' => 'off', 'files' => true]) !!}
        @include("$view.form")
        <div class="form-group mt-5">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({ minimumResultsForSearch: 20 });

        // Toggle field URL / File berdasarkan pilihan Jenis Berkas
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

        toggleFields();

        $('#jenis').on('change', function () {
            toggleFields();
        });

        // Validasi ukuran file maksimal 10MB
        $('#file-upload').on('change', function () {
            var file = this.files[0];
            if (file && file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10 MB! File yang dipilih: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB');
                $(this).val('');
            }
        });
    </script>
@endsection