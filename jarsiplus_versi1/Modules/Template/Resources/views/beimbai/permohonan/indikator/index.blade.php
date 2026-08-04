@extends('template::layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/datetimepicker/datetimepicker.css?v='.env('APP_VERSION'))}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container
    {
        display: block !important;
    }
</style>

<style type="text/css">
    .card.product-card {
        height: 100%;
    }
    
    .card.product-card .card-body {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .card.product-card .title {
        margin-bottom: 0;
    }
    .h5{
        color: white;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 700;
        padding-left: 1em;
        padding-right: 1em;
    }
    .card-equal-height {
        display: flex;
        align-items: stretch;
    }
</style>
@endsection
@section('bottom')
@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center">
        <h1 class="title"> Indikator Inovasi </h1>
        <h4 class="subtitle">{{$parent->label}}</h4>
    </div>
</section>

<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section mt-3 mb-3">
    <div class="row card-equal-height">
        @foreach($data as $temp)
        <div class="col-6 col-lg-3 mb-2">
            <a href="#" data-toggle="modal" data-target="#ModalForm{{$temp->id}}">
                <div class="card" style="height: 100%;">
                    <div class="kode bg-primary" style="height: 100%;">
                        @if($temp->status == 1)
                        <iconify-icon icon="ic:twotone-mood"></iconify-icon>
                        @else
                        <iconify-icon icon="ic:twotone-mood-bad"></iconify-icon>
                        @endif
                        <h5 class="h5 pt-1 pb-1">{{$temp->label_indikator}}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection


@section('other')
@include("template::permohonan.indikator.modal")
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2({      
        placeholder: {
            id: 'null', // the value of the option
            text: '-- Pilih Salah Satu --'
        }
    });
</script>
<script src="{{asset('js/permohonan.js?v='.env('APP_VERSION'))}}"></script>
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
<!-- jQuery Circle Progress -->
<script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
<!-- Base Js File -->
<script src="assets/js/base.js"></script>

@endpush