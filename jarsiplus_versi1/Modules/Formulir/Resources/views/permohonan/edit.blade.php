@extends('layouts.app')
@section('title', "Edit :: $title")

@section('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css">

@endsection

@section('js')
    @include('core::layouts.components.tinymce')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var showPendingJuriMessage = function () {
                if (typeof window.swal === 'function') {
                    return window.swal({
                        title: 'Dalam Proses Penilaian Juri',
                        type: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            };

            document.querySelectorAll('.juri-pending-btn-admin').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    showPendingJuriMessage();
                });
            });
        });
    </script>
@endsection

@section('content')

    @include('layouts.breadcrumb', [
        'lists' => [
            'Dashboard' => 'javascript:;',
            $title => route("$prefix.index"),
            'Kelola Inovasi' => 'active'
        ]
    ])

    {!! Form::open(['route' => ["$prefix.notify-status", $edit->uuid], 'method' => 'post', 'id' => 'status-notification-form', 'class' => 'd-none']) !!}
    {!! Form::close() !!}

    {!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'method' => 'put', 'files' => true]) !!}
    <div class="card card-bordered shadow-none rounded-0">
        @include("$view.form")
    </div>
    {!! Form::close() !!}

    @include('template::partials.juri-komentar-modal')

@endsection
