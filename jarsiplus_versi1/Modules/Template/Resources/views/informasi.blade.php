@extends('template::layouts.master',['footer'=>false])

@section('css')

@endsection

@section('content')

<section class="page-header">
    <div class="header-light text-center mb-3">
        <h1 class="title">INFORMASI</h1>
        <h4 class="subtitle">Informasi JARSIPLUS</h4>
    </div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section full pt-2 pb-3">
    <div class="accordion" id="accordion-1">
       @foreach(Modules\Core\Entities\Laman::orderBy('id','asc')->paginate(25) as $key=>$value)
        <div class="item">
            <div class="accordion-header">
                <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#{{'accordion'.$key+1}}">
                    {{ $value->label}}
                </button>
            </div>
            <div id="{{'accordion'.$key+1}}" class="accordion-body collapse" data-parent="#accordion-1">
                <div class="accordion-content">
                    {!!$value->content!!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection


@section('js')


@endsection