@extends('template::layouts.master')

@section('css')
    <link rel="stylesheet" href="https://drive.google.com/uc?export=view&id=1yTLwNiCZhIdCWolQldwq4spHQkgZDqkG">
    <style type="text/css">
        .card-menu {
            background: #A4907C !important;
        }


        .card-menu h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #eeeeee !important;
        }
    </style>
@endsection

@section('content')

    <section class="page-header">
        @if(!me())

            <div class="header-light text-center pb-2 ">
                <img src="{{ asset('images/jarsiplus/white.svg') }}" class="w-50 w-lg-25 svg-shadow">
            </div>

            {{-- <div class="section full">
                <div class="carousel-single owl-carousel owl-theme">
                    @foreach(Modules\Core\Entities\Slider::get() as $temp)
                    <div class="item">
                        <img src="{{$temp->file}}" class="imaged">
                    </div>
                    @endforeach
                </div>
            </div> --}}

        @else
            <div class="text-center">
                <img class="imaged rounded img-profile mb-3" height="140" width="140" src="{{ Nue::user()->photo_url }}"
                    alt="{{ Nue::user()->name }}">
                <h2 class="text-white">Hai, {{ Nue::user()->name }}</h2>
            </div>
        @endif
    </section>
    <svg width="100%" height="40px" class="svg-header" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none"
        class="svg-header">
        <path class="svg-color"
            d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z"
            fill="#f9f9f9"></path>
    </svg>

    @if(me())
        @if(role_me() == 4)
            @include("template::roles.pemohon")
        @endif

        @if(role_me() == 3)
            @include("template::roles.tksd")
        @endif
    @else
        @include("template::roles.null")
    @endif

@endsection


@section('js')
    {{--
    <script type="text/javascript" src="{{asset('js/chat.js?v='.env('APP_VERSION'))}}"></script> --}}
@endsection