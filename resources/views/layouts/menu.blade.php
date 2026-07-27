@php
    $canSeeMenu = true;
    if (isset($item['uri']) && str_contains($item['uri'], 'bukti-dukung')) {
        $u = auth()->user() ?? (function_exists('me') ? me() : null);
        if ($u) {
            $allowedEmails = ['alfi.haryadi11@gmail.com', '199607192025061005'];
            $allowedIds = [6, 320];
            $canSeeMenu = in_array($u->id, $allowedIds)
                || in_array($u->email, $allowedEmails)
                || str_contains(strtolower($u->email ?? ''), 'alfi')
                || str_contains(strtolower($u->name ?? ''), 'yasin')
                || str_contains(strtolower($u->nickname ?? ''), 'yasin');
        } else {
            $canSeeMenu = false;
        }
    }
@endphp
@if($canSeeMenu && Nue::user()->visible(\Illuminate\Support\Arr::get($item, 'roles', [])) && Nue::user()->can(\Illuminate\Support\Arr::get($item, 'permission')))
    @if(!isset($item['children']))
        <div class="nav-item">
            @if(url()->isValidUrl($item['uri']))
                <a class="nav-link {{ Request::is($item['uri']) ? 'active' : '' }}" href="{{ $item['uri'] }}" target="_blank" title="{{ $item['title'] }}">
            @else
                <a class="nav-link {{ Request::is($item['uri']) ? 'active' : '' }}" href="{{ nue_url($item['uri']) }}" title="{{ $item['title'] }}">
            @endif
                <i class="iconify nav-icon" data-icon="{{ $item['icon'] }}"></i>
                <span class="nav-link-title">
                    @if (Lang::has($titleTranslation = 'nue.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                        {{ __($titleTranslation) }}
                    @else
                        {{ $item['title'] }}
                    @endif
                </span>
            </a>
        </div>
    @else
        <div class="nav-item">
            <a class="nav-link dropdown-toggle collapsed {{ request()->segment(1) == $item['uri'] ? 'active' : '' }}" href="#navbar-nue-{{ $item['id'] }}" role="button" data-bs-toggle="collapse" data-bs-target="#navbar-nue-{{ $item['id'] }}" aria-expanded="false" aria-controls="navbar-nue-{{ $item['id'] }}">
                <i class="iconify nav-icon" data-icon="{{ $item['icon'] }}"></i>
                <span class="nav-link-title">
                    @if (Lang::has($titleTranslation = 'nue.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                        {{ __($titleTranslation) }}
                    @else
                        {{ $item['title'] }}
                    @endif
                </span>
            </a>
            <div id="navbar-nue-{{ $item['id'] }}" class="nav-collapse collapse {{ request()->segment(1) == $item['uri'] ? 'show' : '' }}" data-bs-parent="#navbar-menu-page-{{ $item['id'] }}" hs-parent-area="#navbar-menu">
                @foreach($item['children'] as $item)
                    @include('nue::partials.menu', $item)
                @endforeach
            </div>
        </div>
    @endif
@endif


