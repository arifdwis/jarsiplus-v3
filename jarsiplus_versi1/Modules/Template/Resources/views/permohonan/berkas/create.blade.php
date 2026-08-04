@extends('template::layouts.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center mb-3">
        <h1 class="title">Berkas</h1>
        <h4 class="subtitle">Data Dukung Anda</h4>
    </div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section pb-1 pt-2">
    {!! Form::open(['route' => ["$prefix.store",$parent->uuid] , 'autocomplete' => 'off', 'files' => true]) !!}
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
    $('.select2').select2({minimumResultsForSearch: 20});
</script>
@endsection