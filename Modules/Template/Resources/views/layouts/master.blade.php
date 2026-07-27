<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>{{env('APP_NAME')}}</title>
    <meta name="description" content="{{env('APP_NAME')}}">
    <meta name="keywords" content="{{env('APP_URL')}}" />

    <link rel="icon" type="image/png" href="{{asset('images/logo-mobile/ios/Icon-32.png')}}" sizes="32x32">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.css">
    <link rel="stylesheet" href="{{asset('css/custom.css?v='.env('APP_VERSION'))}}">
    <link rel="stylesheet" href="{{asset('css/jarsiplus-tokens.css?v='.env('APP_VERSION', '1.0'))}}">
    <link rel="stylesheet" href="{{asset('css/jarsiplus.css?v='.env('APP_VERSION', '1.0'))}}">
    @yield('css')
</head>

<body class="jp-site">
    @isset($header) @yield('header') @else @include('template::layouts.partials.header') @endisset
    <!-- App Capsule -->
    <div id="appCapsule">
        @yield('content')
        @isset($footer) @else @include('template::layouts.partials.footer') @endisset
    </div>
    @yield('other')

    <!-- * App Capsule -->
     
    <!-- * Dialog Box -->
    @if(notify()->ready())
    <div class="modal fade dialogbox show" id="dialog-box" data-backdrop="static" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                @if(notify()->type() == 'success')
                <div class="modal-icon text-success">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                @endif

                @if(notify()->type() == 'error')
                <div class="modal-icon text-danger">
                    <ion-icon name="close-circle"></ion-icon>
                </div>
                @endif


                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">{!! notify()->type() !!}</h5>
                </div>

                <div class="modal-body">
                    {!! notify()->message() !!}
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn" data-dismiss="modal">CLOSE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif    
    <!-- * Dialog Box -->
    


    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Bootstrap-->

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.4/mobile-detect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>
    <!-- Base Js File -->
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js"></script>
    <script type="text/javascript" src="{{asset('js/custom.js?v='.env('APP_VERSION'))}}"></script>
    <script defer src="{{asset('js/jarsiplus.js?v='.env('APP_VERSION', '1.0'))}}"></script>
    @yield('js')
    <script type="text/javascript">
        $('#dialog-box').modal('show');
    </script>
    
</body>

</html>
