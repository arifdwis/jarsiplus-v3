@extends('template::layouts.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @include('template::partials.juri-komentar')

@endsection

@section('content')
@include("$view.permohonan.form.header")

<div class="section pb-1 pt-2">
    <h3 class="section-title text-uppercase font-weight-bold pb-0" style="line-height: 1.2">Formulir Permohonan Inovasi Daerah</h3>
    <h5 class="section-subtitle mt-1">Mohon untuk melengkapi semua data untuk Kelengkapan Inovasi</h5>
    {!! Form::model($data, ['route' => ["$prefix.update", $data->uuid], 'autocomplete' => 'off', 'method' => 'PUT']) !!}
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
<script src="{{asset('js/permohonan.js?v='.env('APP_VERSION'))}}"></script>
<script type="text/javascript">
    $('input').attr('disabled','true');
    $('select').attr('disabled','true');
    $('textarea').attr('disabled','true');
    $('.btn-next-form').removeAttr('disabled');
    $('.custom-switch').hide();
    $('.btn-submit').hide();
</script>
@endsection