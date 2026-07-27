@extends('nue::blank')
@section('title', __('Lock-Screen'))

@section('js')
    <script>
        $(function () {
            $('input').focus();
        });
    </script>
@endsection

@section('content')
    <main id="content" role="main" class="main">
        <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url(https://cdn.btekno.id/templates/v2/svg/components/card-6.svg);">
            <div class="shape shape-bottom zi-1">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
                    <polygon fill="#fff" points="0,273 1921,273 1921,0 " />
                </svg>
            </div>
        </div>
        <div class="container py-5 py-sm-7">
            <a class="d-flex justify-content-center mb-3" href="/">
                <div class="text-center zi-2">
                    <img src="{{ config('nue.brand.logo.default.light') }}" alt="" style="width: 5rem;">
                    <span class="d-block display-5 text-dark fw-bold">
                        {{ config('nue.name') }}
                    </span>
                </div>
            </a>
            <div class="mx-auto" style="max-width: 30rem;">
                <form method="POST" action="{{ route('nue-unlock') }}">
                    @csrf
                    <div class="card card-lg mb-5">
                        <div class="card-body text-center">

                            <span class="avatar avatar-xxl avatar-circle mb-3">
                                <img class="avatar-img" src="{{ Nue::user()->photo_url }}" alt="{{ Nue::user()->name }}">
                            </span>

                            <div class="mb-3">
                                <h1 class="display-5 mb-0">{{ Nue::user()->name }}</h1>
                                <p>Enter your password to sign in.</p>
                            </div>

                            <div class="input-group gx-2 gx-sm-3 mb-3">
                                <input type="password" class="form-control form-control-single-number" {{ old('password') ? 'style=color:red;' : '' }} placeholder="Password" name="password" value="{{ old('password') }}"/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-door-open h1 mb-0 text-light"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('logout') }}" class="btn btn-soft-secondary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                    <i class="bi bi-box-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </main>
@endsection
