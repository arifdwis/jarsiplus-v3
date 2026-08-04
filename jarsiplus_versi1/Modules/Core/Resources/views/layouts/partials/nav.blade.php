@php
    $admin = auth()->user();
    if(!empty($admin->role)):
        $permissions = $admin->role->permissions;
        $permissions = json_decode($permissions, true);
    endif;
@endphp

<header class="site-header">
    <div class="container-fluid">
        <a href="/" class="site-logo">
            <img class="hidden-md-down" src="https://cdn-enterwind.s3-ap-southeast-1.amazonaws.com/img/header.png" alt=""/>
        </a>
        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>

        <div class="site-header-content">
            <div class="site-header-content-in">

                @if(auth()->check())

                <div class="site-header-shown">
                    <a class="btn btn-nav btn-inline btn-default-outline" href="{{ route('frontend.index') }}" target="_blank">
                        <i class="fa fa-globe"></i>
                        View Website
                    </a>
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(config('pengguna.plugin.sso'))
                                <img src="{!! auth()->user()->avatar !!}">
                            @else
                                @if(!is_null(auth()->user()->avatar))
                                    <img src="{!! viewImg(auth()->user()->avatar) !!}">
                                @else
                                    <img src="{!! Avatar::create(auth()->user()->nama)->toBase64() !!}">
                                @endif
                            @endif
                            {!! auth()->user()->nama !!}!
                            <span>
                                <i class="fa fa-user"></i>
                                {{ auth()->user()->username }}
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="{{ route('epanel.settings.profile') }}">
                            	<span class="font-icon glyphicon glyphicon-user"></span>
                            	Profil
                            </a>
                            <a class="dropdown-item" href="{{ route('epanel.settings.password') }}">
                                <span class="font-icon fa fa-unlock"></span>
                                Password
                            </a>
                            @if(auth()->user()->level == 1)
                            <a class="dropdown-item" href="{{ route('epanel.settings.setting') }}?type=general">
                            	<span class="font-icon glyphicon glyphicon-cog"></span>
                            	Pengaturan
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>

                            @if(config('pengguna.plugin.sso'))
                                <a class="dropdown-item" href="{{ route('sso.logout') }}">
                                    <span class="font-icon fa fa-times"></span>
                                    SSO Logout
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('epanel.logout') }}">
                                	<span class="font-icon fa fa-times"></span>
                                	Keluar
                                </a>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="burger-right">
                        <i class="font-icon-menu-addl"></i>
                    </button>
                </div>

                @endif
                
            </div>
        </div>
    </div>
</header>

<ul class="main-nav nav nav-inline">
    <li class="nav-item">
        <a class="nav-link @yield('tDashboard')" href="{{ route('epanel.index') }}">
            <i class="font-icon font-icon-speed"></i>
            Dashboard
        </a>
    </li>

    @if(empty($admin->role) || (!empty($permissions) && in_array('Inbox', $permissions)))
        <li class="nav-item">
            <a class="nav-link @yield('tInbox')" href="{{ route('epanel.inbox.index') }}">
                <i class="font-icon font-icon-mail"></i>
                Kotak Masuk
            </a>
        </li>
    @endif
    
    @if(empty($admin->role) || (!empty($permissions) && in_array('Agenda', $permissions)) || 
            (!empty($permissions) && in_array('Berita', $permissions)) || 
            (!empty($permissions) && in_array('Laman', $permissions)) || 
            (!empty($permissions) && in_array('Pengumuman', $permissions)))
        <li class="nav-item">
            <a class="nav-link @yield('tContent')" href="{{ route('epanel.content.index') }}">
                <i class="font-icon font-icon-post"></i>
                Content
            </a>
        </li>
    @endif 

    <li class="nav-item">
        <a class="nav-link @yield('tMedia')" href="{{ route('epanel.media.index') }}">
            <i class="font-icon font-icon-picture-double"></i>
            Media
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('tFeatures')" href="{{ route('epanel.features.index') }}">
            <i class="font-icon font-icon-folder"></i>
            Features
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('tPlugin')" href="{{ route('epanel.plugin.index') }}">
            <i class="font-icon font-icon-snippet"></i>
            Plugin
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('tTools')" href="{{ route('epanel.tools.index') }}">
            <i class="font-icon font-icon-dots"></i>
            Tools
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('tPengguna')" href="{{ route('epanel.pengguna.index') }}">
            <i class="font-icon font-icon-user"></i>
            Pengguna
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('tSettings')" href="{{ route('epanel.settings.index') }}">
            <i class="font-icon font-icon-cogwheel"></i>
            Settings
        </a>
    </li>
</ul>