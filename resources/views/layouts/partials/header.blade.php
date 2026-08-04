<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white">
    <div class="navbar-nav-wrap">
        <a class="navbar-brand" href="/" aria-label="UI">
            <img class="navbar-brand-logo" src="{{ config('nue.brand.logo.default.light') }}" alt="Logo" data-hs-theme-appearance="default">
            <img class="navbar-brand-logo" src="{{ config('nue.brand.logo.default.dark') }}" alt="Logo" data-hs-theme-appearance="dark">
            <img class="navbar-brand-logo-mini" src="{{ config('nue.brand.logo.mini.light') }}" alt="Logo" data-hs-theme-appearance="default">
            <img class="navbar-brand-logo-mini" src="{{ config('nue.brand.logo.mini.dark') }}" alt="Logo" data-hs-theme-appearance="dark">
        </a>

        <div class="navbar-nav-wrap-content-start">
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
            </button>
        </div>

        <div class="navbar-nav-wrap-content-end">
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link p-0" href="javascript:;" id="accountNavbarDropdown" onclick="var m = this.nextElementSibling; if(m) m.classList.toggle('show');" aria-expanded="false">
                                @if(Novay\Nue\Features::enabled(Novay\Nue\Features::profilePhoto()))
                                    <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src="{{ Nue::user()->photo_url }}" alt="{{ Nue::user()->name }}">
                                    </div>
                                @else
                                    <span class="avatar avatar-sm avatar-circle bg-soft-primary text-primary fw-bold flex-shrink-0 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 50%;">
                                        {{ strtoupper(substr(Nue::user()->name ?? 'U', 0, 2)) }}
                                    </span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem; right: 0; left: auto;">
                                <div class="dropdown-item-text">
                                    <div class="d-flex align-items-center">
                                        @if(Novay\Nue\Features::enabled(Novay\Nue\Features::profilePhoto()))
                                            <div class="avatar avatar-sm avatar-circle me-3">
                                                <img class="avatar-img" src="{{ Nue::user()->photo_url }}" alt="{{ Nue::user()->name }}">
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h5 class="mb-0">{{ Nue::user()->name }}</h5>
                                            <p class="card-text text-body mb-0" style="font-size: 12px;">{{ Nue::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="dropdown-divider"></div>

                                @if(Route::has('profile.show'))
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        Profile
                                    </a>
                                @endif
                                
                                <a class="dropdown-item text-danger fw-bold" href="{{ route('sso.logout') }}">
                                    Sign out / Keluar (SSO)
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</header>

<script>
    document.addEventListener('click', function (e) {
        var dropdown = document.querySelector('.navbar-dropdown-account');
        var toggle = document.getElementById('accountNavbarDropdown');
        if (dropdown && toggle && !dropdown.contains(e.target) && !toggle.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
</script>