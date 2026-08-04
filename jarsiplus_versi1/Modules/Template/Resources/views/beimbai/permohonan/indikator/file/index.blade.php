@extends('template::layouts.master',['footer'=>false])

@section('css')
<style>
    .legenda{
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center mb-3">
        <h1 class="title">Data Dukung</h1>
        <h4 class="subtitle">{{$parent->label_indikator}}</h4>
    </div>
</section>

<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>
<div class="section mt-3 mb-3">
    <div class="row">
        
        @if(role_me() == 4)
        @if($parent->status == 0)
        <div class="col-6 col-lg-3 mb-2">
        <a href="{{route('indikator.data.create',$parent->uuid)}}">
            <div class="card h-100">
                <div class="card-body text-center card-create pt-2" data-toggle="modal" data-target="#ModalForm">
                    <ion-icon name="create-outline"></ion-icon>
                    <h1 class="text-muted">Upload Berkas</h1>
                </div>
            </div>
        </a>
        </div>
        @endif
        @endif

        @if($parent->files)

        @foreach($parent->files as $value)
        <div class="col-6 col-lg-3 mb-2">
        <a href="{{route('indikator.data.pembahasan.index',[$parent->uuid,$value->uuid])}}">
            <div class="card  h-100">
                <div class="kode bg-primary">
                    @if($value->status == 0)
                    <iconify-icon icon="ic:twotone-pending-actions" style="font-size: 8em;"></iconify-icon>
                    @elseif($value->status == 1)
                    <iconify-icon icon="ic:twotone-check-circle" style="font-size: 8em;"></iconify-icon>
                    @else
                    <iconify-icon icon="ic:twotone-pending-actions" style="font-size: 8em;"></iconify-icon>
                    @endif
                </div>
                <div class="card-body pt-2">
                    <h6 class="mb-0">Berkas</h6>
                    <h5 class="mb-0 text-capitalize">{{$value->label}}</h5>
                </div>
            </div>
        </a>
        </div>
        @endforeach

        @endif

    </div>

</div>

<!-- Dialog Block Button -->
<div class="modal fade dialogbox" id="info_legenda" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <div class="btn-list">
                    <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">CLOSE</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Dialog Block Button -->
@endsection


@section('js')
<script>
    
    $('.legenda').click(function(){
        var title = $(this).data('title');
        var description = $(this).data('description');
        var modal = $('#info_legenda');
        modal.find('.modal-title').html(title);
        modal.find('.modal-body').html(description);
        modal.modal('show');
    });

</script>
@endsection