<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" type="image/png" href="https://cdn.btekno.id/samarinda/img/logo.png">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('css')

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.enterwind.com/template/epanel/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.enterwind.com/template/epanel/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.enterwind.com/template/epanel/css/main.css">

    <style type="text/css">
        .horizontal-navigation .main-nav {
            top: 50px;
            height: 40px;
        }
        .horizontal-navigation .main-nav .nav-link {
            line-height: 40px;
        }
        .side-menu {
            top: 90px;
        }
        .side-menu .jspPane {
            padding-top: 25px!important;
        }
        .site-header .user-menu.dropdown .dropdown-toggle {
            line-height: 16px;
        }
        .site-header .user-menu.dropdown .dropdown-toggle img {
            margin-right: 8px;
        }
        .site-header .user-menu.dropdown .dropdown-toggle span {
            display: block;
            text-align: left;
            color: #b2bcc1;
            font-size: 75%;
        }
        .site-header .user-menu.dropdown .dropdown-toggle:after {
            display: none;
        }
        .horizontal-navigation .page-content {
            padding-top: 105px;
        }
        .card {
            background: #f7f8fa;
        }
        .box-typical .box-typical-header .tbl-cell.tbl-cell-title h3 {
            line-height: 25px;
        }
        .img-top{
            background:url(https://cdn.btekno.id/img/bg-top.png) repeat-x;
            position:fixed;
            width:100%;
            height:100%;
            z-index:0
        }
        .site-header{
            background:transparent;
            background:url(https://cdn.btekno.id/img/bg-top.png) repeat-x;
        }
        .img-bottom{
            /*background:url(https://cdn.btekno.id/img/bg-bottom.png) repeat-x bottom left;*/
            position:fixed;
            width:100%;
            height:100%;
            z-index:0;
            bottom:0
        }
        .box-typical, .box-typical .box-typical-header{
            background:transparent
        }
        .horizontal-navigation .page-content{
            position:relative
        }
        .site-header{
            background:#fff!important;
            border-bottom:solid 1px #e8e8e8
        }
        .side-menu{
            background:#fff!important;
            border-right: 1px solid rgb(232, 232, 232);
        }
        .side-menu-list li.opened, .side-menu-list a:hover, .side-menu-list li>span:hover {
            border-radius: 0;
        }
        .with-side-menu .page-content {
            position: absolute;
            width: 100%;
        }
        .form-control-label {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 80%;
            color: #6c7a86;
        }
        .side-menu-list .font-icon {
            top:10px;
        }

        .page-content
        {
            overflow-y: auto;
            padding-bottom: 200px;
        }
    </style>

</head>
<body class="horizontal-navigation @yield('sidebar-class')">

    <div class="background">
        <div class="img-top"></div>
        <div class="img-bottom"></div>
    </div>
    
    @include('core::layouts.partials.nav')

    @yield('sidebar')

    <div class="page-content">
        @yield('content')
    </div>

    <div class="statusbar">
        <div class="statusbar-item title">
            <strong>E-Panel CMS v{{ config('core.version') }} by Enter(wind)</strong>
        </div> 
        <div class="statusbar-item">
            <strong>Selamat Datang, </strong> {!! auth()->user()->nama !!}
        </div> 
        <div class="statusbar-item">
            <strong>Last Login: </strong> {!! auth()->user()->last_login->diffForHumans() !!}
        </div>
        <div class="statusbar-item">
            <strong>IP Address: </strong> {!! request()->ip() !!}
        </div> 
        <div class="statusbar-item">
            <b>
                <span id="date"></span>
                <strong>-</strong> 
                <span id="jam"></span>
            </b>
        </div>
    </div>

    {{-- {!! Minify::javascript([
        'https://cdn.enterwind.com/template/epanel/js/lib/jquery/jquery.min.js', 
        'https://cdn.enterwind.com/template/epanel/js/lib/tether/tether.min.js', 
        'https://cdn.enterwind.com/template/epanel/js/lib/bootstrap/bootstrap.min.js', 
        'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js', 
        'https://cdn.enterwind.com/template/epanel/js/plugins.js', 
        'https://cdn.enterwind.com/template/epanel/js/dashboard.js', 
        'https://cdn.enterwind.com/template/epanel/js/app.js', 
        'https://cdnjs.cloudflare.com/ajax/libs/inobounce/0.2.0/inobounce.min.js'
    ])->withFullUrl() !!} --}}

    <script src="https://cdn.enterwind.com/template/epanel/js/lib/jquery/jquery.min.js"></script>
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/tether/tether.min.js"></script>
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
    <script src="https://cdn.enterwind.com/template/epanel/js/plugins.js"></script>

    <script src="https://cdn.enterwind.com/template/epanel/js/dashboard.js"></script>
    <script src="https://cdn.enterwind.com/template/epanel/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inobounce/0.2.0/inobounce.min.js"></script>

    @yield('js')
    
    @if(notify()->ready())
        <script type="text/javascript">
            swal({
                title: 'Perhatian!',
                type: '{!! notify()->type() !!}',
                html: '{!! notify()->message() !!}'
            });
        </script>
    @endif    

</body>
</html>