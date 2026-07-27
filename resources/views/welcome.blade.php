@extends('layouts.blank')
@section('title', __('Welcome'))

@section('css')
    <style type="text/css">
        @media (min-width: 1400px) {
            .container-lg {
                max-width: 1140px;
            }
        }
        .nue-title {
            font-size: 3.75rem;
            line-height: 1;
            letter-spacing: -0.025em;
            font-weight: 800;
        }
    </style>
@endsection

@section('js')
    <script>
        (function() {
            new HSHeader('#header').init()
        })()
    </script>
@endsection

@section('content')
    <header id="header" class="navbar navbar-expand-lg navbar-center navbar-light bg-white navbar-absolute-top navbar-show-hide" data-hs-header-options='{
            "fixMoment": 0,
            "fixEffect": "slide"
        }'>
        <div class="container-lg">
            <nav class="js-mega-menu navbar-nav-wrap">
                <a class="navbar-brand" href="/" aria-label="Logo">
                    <img class="navbar-brand-logo" height="50" src="{{ config('nue.brand.logo.default.light') }}" alt="Logo" data-hs-theme-appearance="default">
                    <img class="navbar-brand-logo" height="50" src="{{ config('nue.brand.logo.default.dark') }}" alt="Logo" data-hs-theme-appearance="dark">
                    <span class="position-absolute top-50 translate-middle-y h1 fw-bold">
                        {{ config('nue.name') }}
                    </span>
                </a>
                <div class="navbar-nav-wrap-secondary-content">
                    <div class="dropdown">
                        <a href="javascript:;" class="me-2 text-secondary" id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation></a>
                        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="selectThemeDropdown">
                            <a class="dropdown-item" href="#" data-icon="ic:twotone-deblur" data-value="auto">
                                <i class="iconify i-2x me-2" data-icon="ic:twotone-deblur"></i>
                                <span class="text-truncate" title="Auto (system default)">Auto (system default)</span>
                            </a>
                            <a class="dropdown-item" href="#" data-icon="ic:twotone-light-mode" data-value="default">
                                <i class="iconify i-2x me-2" data-icon="ic:twotone-light-mode"></i>
                                <span class="text-truncate" title="Default (light mode)">Default (light mode)</span>
                            </a>
                            <a class="dropdown-item active" href="#" data-icon="ic:twotone-dark-mode" data-value="dark">
                                <i class="iconify i-2x me-2" data-icon="ic:twotone-dark-mode"></i>
                                <span class="text-truncate" title="Dark">Dark</span>
                            </a>
                        </div>
                    </div>
                    @guest
                        @if(Route::has('login'))
                            <a class="btn btn-sm btn-secondary navbar-btn" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        @endif
                        @if(Route::has('register'))
                            <a class="btn btn-sm btn-primary navbar-btn" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @else
                        <a class="btn btn-sm btn-secondary navbar-btn" href="{{ config('nue.home') }}">
                            {{ __('Dashboard') }}
                        </a>
                    @endguest
                </div>
                <div class="collapse navbar-collapse" id="navbarContainerNavDropdown"></div>
            </nav>
        </div>
    </header>
    <main id="content" role="main" class="main">
        <div class="overflow-hidden gradient-radial-sm-primary">
            <div class="animated fadeInUp container-lg content-space-t-3 content-space-t-lg-4">
                <div class="w-lg-75 mx-lg-auto mx-auto">
                    <div class="text-center mb-5">
                        <h1 class="nue-title mb-3">Nue Package for everyone!</h1>
                        <p class="fs-2">
                            Developer friendly and highly customizable Admin &amp; Dashboard for Laravel.
                        </p>
                    </div>
                    <div class="card bg-dark mb-5">
                        <div class="card-body font-monospace">
                            <div class="d-grid gap-6">
                                <span class="d-grid gap-1">
                                    <span class="d-block text-white-70">&gt; $ composer require novay/nue</span>
                                    <span class="d-block text-success">Package manifest generated successfully.</span>
                                    <span class="d-block text-white-70">&gt; $ php artisan nue</span>
                                    <span class="d-block text-white-70"></span>
                                    <span class="d-block text-success">Nue version 2.00</span>
                                    <span class="d-block text-success">&nbsp;</span>
                                    <span class="d-block text-warning">Available commands:</span>
                                    <span class="d-block text-white">&nbsp;nue:install&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Install the Nue components and resources.</span>
                                    <span class="d-block text-white">&nbsp;nue:auth&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Scaffold the authentication controllers (silent call).</span>
                                    <span class="d-block text-white">&nbsp;nue:uninstall&nbsp;&nbsp;&nbsp;Uninstall the Nue package.</span>
                                    <span class="d-block text-white-70">&nbsp;nue:extend&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Build your own Nue extension.</span>
                                    <span class="d-block text-white-70">&nbsp;nue:import&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Import your Nue extension.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid mx-auto" style="max-width: 10rem;">
                    <a class="btn btn-dark btn-lg" href="https://github.com/novay/nue" target="_blank">
                        <span class="iconify me-1" data-icon="simple-icons:github"></span>
                        Github
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection