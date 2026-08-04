@extends('template::layouts.master',['footer'=>false,'bottom'=>false])

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/datetimepicker/datetimepicker.css?v='.env('APP_VERSION'))}}">
<style type="text/css">

</style>
@endsection

@section('bottom')
@endsection

@section('content')
{!! Form::open(['route' => ['permohonan.kirim', $data->uuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT']) !!}
<section class="page-header">
    <div class="header-light text-center">
        <h1 class="title"> Kirim Inovasi</h1>
        <h4 class="subtitle">{{$data->label}}</h4>
    </div>
</section>

<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section full pt-2 pb-3">
    <div class="container pt-2 pb-2">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#desk2Desk" role="tab">
                    <input type="hidden" id="kategori" name="status" value="3">
                    Peringatan
                </a>
            </li>
        </ul>
        <div class="mt-2">
            <div id="desk2Desk" class="tab-content">
                Mohon untuk melakukan pengecekan ulang terhadap data yang telah Anda berikan. Jika data telah diverifikasi dan benar, silakan lakukan pengiriman data. Harap diingat bahwa setelah data inovasi dikirimkan, tidak akan ada kemungkinan untuk mengubahnya. Terima kasih atas kerja sama yang diberikan.
            </div>
        </div>
    </div>
</div>


<div class="form-button-group">
    <button type="submit" class="btn  btn-primary btn-block">Submit Data</button>
</div>
{!! Form::close() !!}
@endsection

@section('other')

@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js" type="text/javascript"></script>
<script src="{{asset('assets/datetimepicker/datetimepicker.js?v='.env('APP_VERSION'))}}"></script>
<script type="text/javascript">
    var d = new Date();
    $('#tanggal').datetimepicker({
       format: 'd-m-Y',
       inline: true,
       sideBySide: true,
       timepicker:false,
       minDate:d,
       lang:'id',
   });
</script>
@endsection