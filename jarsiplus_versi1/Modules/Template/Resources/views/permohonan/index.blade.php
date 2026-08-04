@extends('template::layouts.master', ['footer' => false])

@section('css')
    <style>
        .legenda {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <section class="page-header">
        <div class="header-light text-center mb-3">
            <h1 class="title">Permohonan</h1>
            <h4 class="subtitle">Riwayat permohonan yang telah anda ajukan.</h4>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-3 px-1">
                    <div class="legenda bg-primary" data-title="Permohonan"
                        data-description="Pemohon mengajukan permohonan Inovasi dan menunggu validasi data pengajuan.">
                        <iconify-icon icon="ic:twotone-pending-actions"></iconify-icon>
                        <h6>Permohonan</h6>
                    </div>
                </div>
                <div class="col-3 px-1">
                    <div class="legenda bg-primary" data-title="Pembahasan"
                        data-description="Pemohon melengkapi dokumen hingga dokumen yang diajukan telah sesuai.">
                        <iconify-icon icon="ic:twotone-timer"></iconify-icon>
                        <h6>Pembahasan</h6>
                    </div>
                </div>
                <div class="col-3 px-1">
                    <div class="legenda bg-primary" data-title="Persetujuan"
                        data-description="Pemohon diharuskan mengisi indikator dan paramaeter yang harus diisi.">
                        <iconify-icon icon="ic:twotone-auto-stories"></iconify-icon>
                        <h6>Persetujuan</h6>
                    </div>
                </div>
                <div class="col-3 px-1">
                    <div class="legenda bg-primary" data-title="Selesai"
                        data-description="Permohonan dinyatakan telah selesai.">
                        <iconify-icon icon="ic:twotone-check-circle"></iconify-icon>
                        <h6>Selesai</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
        <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z"
            fill="#f9f9f9"></path>
    </svg>
    <div class="section mt-3 mb-3">
        <div class="row">

            @php
                $is_closed = pendaftaran_permohonan_ditutup();
                // Email Arif Dwi Syafutra & Alfi Haryadi
                $is_arif = Nue::user() && in_array(Nue::user()->email, ['arifdwi@samarindakota.go.id', 'alfi.haryadi11@gmail.com']);
            @endphp

            {{-- Kartu 1: Khusus Arif - selalu bisa akses --}}
            @if($is_arif && $identityComplete)
                <div class="col-6 col-lg-3 mb-2">
                    <a href="{{route('permohonan.create')}}">
                        <div class="card h-100">
                            <div class="card-body text-center card-create pt-2">
                                <ion-icon name="create-outline"></ion-icon>
                                <h1 class="text-muted">New Permohonan</h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- Kartu 2: User biasa - buka tutup berdasarkan tanggal --}}
            @if(!$is_arif)
            <div class="col-6 col-lg-3 mb-2">
                @if(!$identityComplete)
                    <a href="{{ route('settings.profile.index') }}">
                        <div class="card h-100">
                            <div class="card-body text-center card-create pt-2">
                                <ion-icon name="person-add-outline"></ion-icon>
                                <h1 class="text-muted">New Permohonan</h1>
                                <small class="text-danger">Lengkapi Biodata</small>
                            </div>
                        </div>
                    </a>
                @elseif(!$is_closed)
                    <a href="{{ route('permohonan.create') }}">
                        <div class="card h-100">
                            <div class="card-body text-center card-create pt-2">
                                <ion-icon name="create-outline"></ion-icon>
                                <h1 class="text-muted">New Permohonan</h1>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card h-100 permohonan-closed" style="cursor: not-allowed; opacity: 0.6;">
                        <div class="card-body text-center card-create pt-2">
                            <ion-icon name="create-outline"></ion-icon>
                            <h1 class="text-muted">New Permohonan</h1>
                            <small class="text-danger">{{ pendaftaran_inovasi_pesan_tutup() }}</small>
                        </div>
                    </div>
                @endif
            </div>
            @endif

            @if($data)

                @foreach($data as $value)
                    <div class="col-6 col-lg-3 mb-2">
                        <a href="{{route('permohonan.show', $value->kode)}}">
                            <div class="card  h-100">
                                <div class="kode bg-primary">
                                    @if($value->status == 0)
                                        <iconify-icon icon="ic:twotone-pending-actions"></iconify-icon>
                                    @elseif($value->status == 1)
                                        <iconify-icon icon="ic:twotone-timer"></iconify-icon>
                                    @elseif($value->status == 2)
                                        <iconify-icon icon="ic:twotone-auto-stories"></iconify-icon>
                                    @elseif($value->status == 3)
                                        <iconify-icon icon="ic:twotone-content-paste-go"></iconify-icon>
                                    @elseif($value->status == 4)
                                        <iconify-icon icon="ic:twotone-check-circle"></iconify-icon>
                                    @elseif($value->status == 9)
                                        <iconify-icon icon="icon-park-twotone:close-one"></iconify-icon>
                                    @endif
                                    <h2>{{$value->kode}}</h2>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="mb-0">Permohonan</h6>
                                    <h5 class="mb-0">{{$value->label}}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            @endif

        </div>

    </div>

    <!-- Dialog Block Button -->
    <div class="modal fade dialogbox" id="info_legenda" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">CLOSE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Block Button -->
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $('.legenda').click(function () {
            var title = $(this).data('title');
            var description = $(this).data('description');
            var modal = $('#info_legenda');
            modal.find('.modal-title').html(title);
            modal.find('.modal-body').html(description);
            modal.modal('show');
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cards = document.querySelectorAll('.permohonan-closed');
            cards.forEach(function (card) {
                card.addEventListener('click', function () {
                    Swal.fire({
                        icon: 'info',
                        title: 'Input Ditutup',
                        text: 'Input permohonan saat ini ditutup. Silakan menunggu pengumuman pembukaan input kembali.',
                        confirmButtonText: 'OK'
                    });
                });
            });
        });
    </script>

@endsection
