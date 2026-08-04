@extends('layouts.app')
@section('title', __('Profile'))

@section('js')
    <script>
        (function() {
            new HSFileAttach('.js-file-attach')
            new HSTogglePassword('.js-toggle-password')
        })()
    </script>
@endsection

@section('content')
    <div class="content container-fluid">

        <div class="row">
            <div class="col-lg-3">
                <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
                    <div class="d-grid">
                        <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                            <span class="d-flex justify-content-between align-items-center">
                                <span class="text-dark">Menu</span>

                                <span class="navbar-toggler-default">
                                    <i class="bi-list"></i>
                                </span>

                                <span class="navbar-toggler-toggled">
                                    <i class="bi-x"></i>
                                </span>
                            </span>
                        </button>
                    </div>

                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <ul id="navbarSettings" class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical" data-hs-sticky-block-options='{
                                "parentSelector": "#navbarVerticalNavMenu",
                                "targetSelector": "#header",
                                "breakpoint": "lg",
                                "startPoint": "#navbarVerticalNavMenu",
                                "endPoint": "#stickyBlockEndPoint",
                                "stickyOffsetTop": 20
                            }'>
                            @if(Novay\Nue\Features::enabled(Novay\Nue\Features::updateProfile()))
                                <li class="nav-item">
                                    <a class="nav-link {{ !request('page') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                                        <span class="iconify nav-icon me-2" data-icon="icon-park-twotone:id-card-h"></span>
                                        Profile Information
                                    </a>
                                </li>
                            @endif
                            @if(Novay\Nue\Features::enabled(Novay\Nue\Features::updateEmail()))
                                <li class="nav-item">
                                    <a class="nav-link {{ request('page') == 'email' ? 'active' : '' }}" href="{{ route('profile.show') }}?page=email">
                                        <span class="iconify nav-icon me-2" data-icon="icon-park-twotone:email-block"></span> 
                                        Email
                                    </a>
                                </li>
                            @endif
                            @if(Novay\Nue\Features::enabled(Novay\Nue\Features::updatePassword()))
                                <li class="nav-item">
                                    <a class="nav-link {{ request('page') == 'password' ? 'active' : '' }}" href="{{ route('profile.show') }}?page=password">
                                        <i class="iconify nav-icon me-2" data-icon="icon-park-twotone:lock"></i>
                                        Password
                                    </a>
                                </li>
                            @endif
                            @if(Novay\Nue\Features::enabled(Novay\Nue\Features::terminateAccount()))
                                <li class="nav-item">
                                    <a class="nav-link text-danger {{ request('page') == 'terminate' ? 'active' : '' }}" href="{{ route('profile.show') }}?page=terminate">
                                        <span class="iconify nav-icon me-2" data-icon="icon-park-twotone:delete-five"></span>
                                        Delete account
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="d-grid gap-3 gap-lg-5">
                    
                    @if(Novay\Nue\Features::enabled(Novay\Nue\Features::updateProfile()))
                        @if(!request('page'))
                            @include('profile.page.basic')
                        @endif
                    @endif

                    @if(Novay\Nue\Features::enabled(Novay\Nue\Features::updateEmail()))
                        @if(request('page') == 'email')
                            @include('profile.page.email')
                        @endif
                    @endif

                    @if(Novay\Nue\Features::enabled(Novay\Nue\Features::updatePassword()))
                        @if(request('page') == 'password')
                            @include('profile.page.password')
                        @endif
                    @endif

                    @if(Novay\Nue\Features::enabled(Novay\Nue\Features::terminateAccount()))
                        @if(request('page') == 'terminate')
                            @include('profile.page.terminate')
                        @endif
                    @endif

                </div>
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
    </div>
@endsection
