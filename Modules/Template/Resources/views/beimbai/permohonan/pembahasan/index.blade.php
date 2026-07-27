@extends('template::layouts.master', ['footer' => false, 'bottom' => false])

@section('css')
    <style type="text/css">

    </style>
@endsection

@section('content')

    <section class="page-header">
        @if(role_me() == 4)
            @if($data->status == 1)
                <div class="text-center">
                    <div class="legenda bg-primary" data-title="Selesai"
                        data-description="Permohonan dinyatakan telah selesai dan pemohon mendapatkan produk kerja sama.">
                        <iconify-icon icon="ic:twotone-check-circle"></iconify-icon>
                        <h6>Berkas Tervalidasi</h6>
                    </div>
                </div>
            @endif
        @endif

        @isset($data->validasi)
            @if($data->validasi && $data->validasi->status == 1)
                <div class="text-center">
                    <div class="legenda bg-primary" data-title="Selesai"
                        data-description="Permohonan dinyatakan telah selesai dan pemohon mendapatkan produk kerja sama.">
                        <iconify-icon icon="ic:twotone-check-circle"></iconify-icon>
                        <h6>Berkas Tervalidasi</h6>
                    </div>
                </div>
            @endif
        @endisset
        <div class="header-light text-center">
            <h1 class="title">{{$parent->kode}}</h1>
            <h4 class="subtitle text-capitalize pb-1">Pembahasan {{$parent->label}} dengan berkas {{$data->label}}.</h4>
        </div>
    </section>
    <svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
        <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z"
            fill="#f9f9f9"></path>
    </svg>

    <div class="section py-5" id="chat-view">
    </div>
@endsection

@section('other')


    @if(role_me() == 4)
        @if($data->status != 1)
            @include("$view.modal.perbaikan")
            @include("$view.footer")
        @endif
    @else

        @isset($data->validasi)
            @if(!$data->validasi || $data->validasi->status != 1)
                @include("$view.modal.validasi")
                @include("$view.footer")
            @endif
        @else
            @include("$view.modal.validasi")
            @include("$view.footer")
        @endisset

    @endif



@endsection


@section('js')
    <script type="text/javascript">

        // setInterval(ajaxCall, 30000); //300000 MS == 5 minutes
        ajaxCall();

        function ajaxCall() {
            console.log('call ajax');
            $.ajax({
                type: "GET",
                cache: true,
                url: '?ajax=true',
                success: function (data) {
                    $('#chat-view').html(data);
                }
            });

            var elem = document.getElementById('chat-view');
            elem.scrollTop = elem.scrollHeight;
        }

        $("#form-chat").submit(function (e) {
            e.preventDefault();

            var el_input = $('#input-chat');
            var val_input = el_input.val();

            if (val_input != '') {
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (data) {
                        el_input.val(null);
                        $('#chat-view').append(data);
                    }
                });
            }


        });
    </script>
@endsection