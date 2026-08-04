@extends('template::layouts.master')

@section('css')
@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center mb-3">
        <h1 class="title">Pengaturan</h1>
        <h4 class="subtitle">Kelola pengaturan anda pada halaman berikut.</h4>
    </div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section full pb-1 pt-4">
<ul class="listview link-listview">
    <li><a href="{{route('settings.profile.index')}}">Pengaturan Biodata</a></li>
    <li><a href="{{route('settings.corporate.index')}}">Pengaturan Instansi</a></li>
   
</ul>
</div>
@endsection

@section('js')
@endsection