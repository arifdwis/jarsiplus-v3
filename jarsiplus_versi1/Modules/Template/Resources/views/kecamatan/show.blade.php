@extends('template::layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css">
<style type="text/css">
    .modal-body img
    {
        width: 100% !important;
        height: auto !important;
    }
    .modal-content img.img-footer{
        vertical-align:bottom;
        border:0;
        height: auto;
        width: 100%;
    }
    .lity-iframe-container
    {
        height: 100vh!important;
        width: 100%!important;
        padding: 0px!important;
    }
</style>
@endsection

@section('content')
<div id="appCapsule">

    <div class="section mt-2">
        <div class="profile-head">
            <div class="avatar">
                <img src="{{$parent->kecamatan->foto_camat}}" alt="avatar" class="imaged w120">
            </div>
            <div class="in">
                <h3 class="name">{{$parent->kecamatan->camat}}</h3>
                <h5 class="subtext">Camat {{$parent->nama}}</h5>
            </div>
        </div>
    </div>

    <div class="section full mt-2">
        <div class="profile-stats pl-2 pr-2">
            <a href="#" class="item">
                <strong>152</strong>photo
            </a>
            <a href="#" class="item">
                <strong>52</strong>albums
            </a>
            <a href="#" class="item">
                <strong>27k</strong>followers
            </a>

            <a href="#" class="item">
                <strong>506</strong>following
            </a>
        </div>
    </div>

    <div class="section mt-1 mb-2">
        <div class="profile-info">
            <div class=" bio">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur at magna porttitor lorem mollis
                ornare. Fusce varius varius massa.
            </div>
            <div class="link">
                <a href="#">Paris</a>,
                <a href="#">France</a>
            </div>
        </div>
    </div>

    <div class="section full">
        <div class="wide-block transparent p-0">
            <ul class="nav nav-tabs lined iconed" role="tablist">
                
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#feed" role="tab">
                        <ion-icon name="grid-outline" role="img" class="md hydrated" aria-label="grid outline"></ion-icon>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#friends" role="tab">
                        <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bookmarks" role="tab">
                        <ion-icon name="bookmark-outline" role="img" class="md hydrated" aria-label="bookmark outline"></ion-icon>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                        <ion-icon name="settings-outline" role="img" class="md hydrated" aria-label="settings outline"></ion-icon>
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <!-- tab content -->
    <div class="section full mb-2">
        <div class="tab-content">

            <!-- feed -->
            <div class="tab-pane fade show active" id="feed" role="tabpanel">
                <div class="mt-2 pr-2 pl-2">
                    <div class="row" id="news">
                    </div>
                </div>
            </div>
            <!-- * feed -->

            <!-- * friends -->
            <div class="tab-pane fade" id="friends" role="tabpanel">
                <ul class="listview image-listview flush transparent pt-1">
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Edward Lindgren
                                    <div class="text-muted">532 followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Emelda Scandroot
                                    <div class="text-muted">120k followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar5.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Henry Bove
                                    <div class="text-muted">920k followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Ava Gregoraci
                                    <div class="text-muted">5092 followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar6.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Emmy Elsner
                                    <div class="text-muted">92 followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar7.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Lisanne Viscaal
                                    <div class="text-muted">893 followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar10.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    Cecilia Pozo
                                    <div class="text-muted">51k followers</div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- * friends -->

            <!--  bookmarks -->
            <div class="tab-pane fade" id="bookmarks" role="tabpanel">
                <ul class="listview image-listview media flush transparent pt-1">
                    <li>
                        <a href="#" class="item">
                            <div class="imageWrapper">
                                <img src="assets/img/sample/photo/1.jpg" alt="image" class="imaged w64">
                            </div>
                            <div class="in">
                                <div>
                                    Birds
                                    <div class="text-muted">62 photos</div>
                                </div>
                                <span class="badge badge-primary">5</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="imageWrapper">
                                <img src="assets/img/sample/photo/2.jpg" alt="image" class="imaged w64">
                            </div>
                            <div class="in">
                                <div>
                                    Street Photos
                                    <div class="text-muted">15 photos</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="imageWrapper">
                                <img src="assets/img/sample/photo/3.jpg" alt="image" class="imaged w64">
                            </div>
                            <div class="in">
                                <div>
                                    Dogs
                                    <div class="text-muted">97 photos</div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- * bookmarks -->
            <!-- settings -->
            <div class="tab-pane fade" id="settings" role="tabpanel">
                <ul class="listview image-listview text flush transparent pt-1">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    Mute
                                    <footer>Disabled notifications from this person</footer>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1"></label>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="in">
                                <div class="text-danger">Block</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="in">
                                <div>Report</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="in">
                                <div>Share This Profile</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="in">
                                <div>Send a Message</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- * settings -->
        </div>
    </div>
    <!-- * tab content -->

</div>


@endsection


@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js"></script>
<script type="text/javascript">
$.ajax({
    url  : '?news=true',
    success: function(response) {
        var news = '';
        var data = response['data'];
        $.each(data, function(key,item) {
            news += `<div class="col-6 mb-2">
            <a href="${item['url']}" data-lity>
            <img data-id="${key}" src="${item['thumbnail_m']}" alt="image" class="imaged w-100 news">
            </a>
            </div>`;
        });
        $('#news').html(news);
    },
    error: function() {
        alert('Error occured');
    }
});
 
</script>
@endsection