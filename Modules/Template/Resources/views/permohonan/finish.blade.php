@extends('template::layouts.master',['footer'=>false,'bottom'=>false])

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/datetimepicker/datetimepicker.css?v='.env('APP_VERSION'))}}">
<style type="text/css">

</style>
@endsection

@section('bottom')
@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center">
        <h1 class="title"> Skor Inovasi</h1>
        <h4 class="subtitle">{{$data->label}}</h4>
    </div>
</section>

<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

@if($data->status==4)
    <div class="section full pt-2 pb-3">
    <div class="card comment-box">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" style="margin: 0 auto;">
                <path fill="currentColor" d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8s8-3.58 8-8s-3.58-8-8-8zM8.88 7.82L11 9.94L9.94 11L8.88 9.94L7.82 11L6.76 9.94l2.12-2.12zM12 17.5c-2.33 0-4.31-1.46-5.11-3.5h10.22c-.8 2.04-2.78 3.5-5.11 3.5zm4.18-6.5l-1.06-1.06L14.06 11L13 9.94l2.12-2.12l2.12 2.12L16.18 11z" opacity=".3"/><path fill="currentColor" d="M8.88 9.94L9.94 11L11 9.94L8.88 7.82L6.76 9.94L7.82 11zm4.12 0L14.06 11l1.06-1.06L16.18 11l1.06-1.06l-2.12-2.12zM11.99 2C6.47 2 2 6.47 2 12s4.47 10 9.99 10S22 17.53 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8s8 3.58 8 8s-3.58 8-8 8zm0-2.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
            </svg>
        </div>
        <h4 class="card-title text-center">Skor Anda {{$data->nilai_akhir}} !</h4>
        <div class="text">
            Ucapan terima kasih untuk partisipasi dan inovasi yang Anda berikan. Kami menghargai kontribusi Anda dalam meningkatkan kualitas dan kemajuan kami.
        </div>
    </div>
</div>

@else
    <div class="section full pt-2 pb-3">
    <div class="card comment-box">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" style="margin: 0 auto;">
                <path fill="currentColor" d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8s8-3.58 8-8s-3.58-8-8-8zm3.5 4c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5zm-7 0c.83 0 1.5.67 1.5 1.5S9.33 11 8.5 11S7 10.33 7 9.5S7.67 8 8.5 8zm3.5 9.5c-2.33 0-4.32-1.45-5.12-3.5h1.67c.7 1.19 1.97 2 3.45 2s2.76-.81 3.45-2h1.67c-.8 2.05-2.79 3.5-5.12 3.5z" opacity=".3"/>
                <circle cx="15.5" cy="9.5" r="1.5" fill="currentColor"/>
                <circle cx="8.5" cy="9.5" r="1.5" fill="currentColor"/>
                <path fill="currentColor" d="M12 16c-1.48 0-2.75-.81-3.45-2H6.88a5.495 5.495 0 0 0 10.24 0h-1.67c-.69 1.19-1.97 2-3.45 2zm-.01-14C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8s8 3.58 8 8s-3.58 8-8 8z"/>
            </svg>
        </div>
        <h4 class="card-title text-center">Masih menunggu validasi</h4>
        <div class="text">
            Masih menunggu validasi untuk setiap aspek yang telah Anda kontribusikan. Kami akan segera memeriksa dan mengonfirmasi kontribusi Anda.
        </div>
    </div>
</div>
@endif



@endsection

@section('other')

@endsection


@section('js')

@endsection