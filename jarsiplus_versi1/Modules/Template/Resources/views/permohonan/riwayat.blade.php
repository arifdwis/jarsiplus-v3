@extends('template::layouts.master')

@section('css')

@endsection

@section('content')

<section class="page-header">
    <div class="text-center">
        <img class="imaged img-fluid" src="https://jarsiplus.samarindakota.go.id/images/jarsiplus/white.svg" alt="Logo">
    </div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>
<div class="section full pt-2 pb-3">
    <div class="section mt-1 mb-2">
        <div class="profile-info">
            <div class=" bio">
               <b>
                 <h2 >
                    Riwayat Pengajuan Inovasi Daerah
                </h2> 
               <p class="text-primary"> {{$data->label}} </p>
            </b> 
        </div>
    </div>
</div>

<div class="section full">
    <div class="wide-block transparent p-0">
        <ul class="nav nav-tabs lined iconed" role="tablist">
            <li class="nav-item">
            </li>
        </ul>
    </div>
</div>

<!-- tab content -->
<div class="section full mb-2">
    <div class="tab-content">
        <!-- settings -->
        @foreach($histori as $temp)
        <div class="wide-block pt-2 pb-2">
               <b>{{$temp->deskripsi}}</b><br>
               <small>{{tgl_indo($temp->created_at)}}</small>
            </div>
        @endforeach
        <!-- * settings -->
    </div>
</div>
@endsection

@section('other')

@endsection


@section('js')

@endsection