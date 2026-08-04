@extends('template::layouts.master',['footer'=>false])

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css">

@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center">
        <h1 class="title">{{$data->kode}}</h1>
        <h4 class="subtitle">Riwayat permohonan yang telah anda ajukan.</h4>
    </div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section mt-3 mb-3">
    <div class="row">

        <div class="col-6 col-lg-3 mb-2">
            <a href="{{route("$prefix.permohonan.detail",$data->uuid)}}">
                <div class="card h-100">
                    <div class="kode bg-primary">
                        <iconify-icon icon="ic:twotone-pending-actions"></iconify-icon>
                        <h3>Permohonan</h3>
                    </div>
                </div>
            </a>
        </div>

        @if($data->status != 9 && $data->status < 3)
        
        @if($data->status > 0)
        <div class="col-6 col-lg-3 mb-2">
            <a href="{{route("$prefix.indikator.index",$data->uuid)}}">
                <div class="card h-100">
                    <div class="kode bg-primary">
                        <iconify-icon icon="ic:twotone-note-alt"></iconify-icon>
                        <h3>Indikator</h3>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if($data->status > 1)
        <div class="col-6 col-lg-3 mb-2">
            <a href="{{route("$prefix.persetujuan",$data->uuid)}}">
                <div class="card h-100">
                    <div class="kode bg-primary">
                        <iconify-icon icon="ic:twotone-send"></iconify-icon>
                        <h3>Kirim Inovasi</h3>
                    </div>
                </div>
            </a>
        </div>
        @endif
        @endif

        @php
            $isJuriActive = (!empty($juriComments) && count($juriComments));
        @endphp
        <div class="col-6 col-lg-3 mb-2">
            <a href="{{ $isJuriActive ? '#' : 'javascript:;' }}"
                @if($isJuriActive)
                    data-toggle="modal" data-target="#modalKomentarJuri"
                @else
                    class="juri-pending-btn"
                @endif
                title="Dalam Proses Penilaian Juri">
                <div class="card h-100">
                    <div class="kode {{ $isJuriActive ? 'bg-primary' : 'bg-secondary' }}" style="{{ $isJuriActive ? '' : 'opacity:.8;' }}">
                        <iconify-icon icon="{{ $isJuriActive ? 'ic:twotone-chat-bubble-outline' : 'mdi:comment-off-outline' }}"></iconify-icon>
                        <h3>Komentar Juri</h3>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-3 mb-2">
            <a href="{{route("$prefix.riwayat",$data->uuid)}}">
                <div class="card h-100">
                    <div class="kode bg-primary">
                        <iconify-icon icon="uim:history-alt"></iconify-icon>
                        <h3>Riwayat</h3>
                    </div>
                </div>
            </a>
        </div>

        @if($data->status == 4)
        <div class="col-6 col-lg-3 mb-2">
            <a href="{{route("$prefix.finish",$data->uuid)}}">
                <div class="card h-100">
                    <div class="kode bg-primary">
                        <iconify-icon icon="ic:twotone-check-circle"></iconify-icon>
                        <h3>Nilai</h3>
                    </div>
                </div>
            </a>
        </div>
        @endif

    </div>
</div>

@include('template::partials.juri-komentar-modal')

@endsection


@section('js')
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

        document.querySelectorAll('.juri-pending-btn').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                showPendingJuriMessage();
            });
        });
    });
</script>

@endsection