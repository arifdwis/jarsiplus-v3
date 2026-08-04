<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') :: {{ config('nue.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ config('nue.brand.favicon') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.btekno.id/templates/v2/css/vendor.min.css">
    <link rel="stylesheet" href="https://cdn.btekno.id/templates/v2/css/theme.min.css">
    <link rel="preload" href="https://cdn.btekno.id/templates/v2/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="https://cdn.btekno.id/templates/v2/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
    <link rel="stylesheet" href="https://cdn.btekno.id/templates/v2/css/nue.css">
    
    <style data-hs-appearance-onload-styles>
        *{transition:unset!important}
        body{opacity:0}
    </style>

    <script>
        window.hs_config = {
            "themeAppearance":{
                "layoutSkin": "default"
            }
        }
    </script>

    @yield('css')
</head>

<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl">
    <script src="https://cdn.btekno.id/templates/v2/js/hs.theme-appearance.js"></script>
    <script src="https://cdn.btekno.id/templates/v2/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js"></script>

    @include('layouts.partials.header')
    @include('layouts.partials.aside')

    <main id="content" role="main" class="main bg-light min-vh-100">
        @yield('content')
    </main>

    <script src="https://cdn.btekno.id/templates/v2/js/vendor.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.btekno.id/templates/v2/js/theme.min.js"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    
    <script>
        (function() {
            window.onload = function () {
                new HSSideNav('.js-navbar-vertical-aside').init()
                HSBsDropdown.init()
            }
        })()
    </script>

    @if(notify()->ready())
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 100">
            <div id="toast" class="toast align-items-center rounded-1 text-white bg-{{ notify()->type() }} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">{!! notify()->message() !!}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            if (window.bootstrap && window.bootstrap.Toast) {
                const toast = new bootstrap.Toast(document.querySelector('#toast'))
                toast.show();
            }
        </script>
    @endif
    
    @yield('js')

</body>
</html>