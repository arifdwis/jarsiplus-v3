@extends('template::layouts.master',['header'=>false])

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"/>
<style type="text/css">
    #appCapsule
    {
        min-height: 100vh;
    }
    .profile-head .in {
        margin-right: 16px;
    }
    .avatar .imaged
    {
        min-height: 140px;
    }
    .modal-content img.img-footer{
        vertical-align:bottom;
        border:0;
        height: auto;
        width: 100%;
    }
</style>
@endsection

@section('content')
    <!-- App Capsule -->
    <div id="appCapsule">
    </div>
    <!-- * App Capsule -->

    <!-- Modal Basic -->
    <div class="modal map-modal fade modalbox" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <a href="javascript:;" data-dismiss="modal" class="btn btn-sm btn-danger"><ion-icon name="exit"></ion-icon> Close</a>
                </div>
                <div class="modal-body"></div>
                <img src="https://samarindakota.go.id/assets/portal/img/menu-sarana.png" class="img-footer">
            </div>
        </div>
    </div>
    <!-- * Modal Basic -->
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/chroma-js/2.1.0/chroma.min.js"></script>
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
<script src="{{asset('js/map.js')}}"></script>
@endsection