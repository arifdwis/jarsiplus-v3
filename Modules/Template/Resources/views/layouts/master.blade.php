<!doctype html>
<html lang="id" data-theme="cobalt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'JARSIPLUS Samarinda'))</title>
    <meta name="description" content="@yield('meta_description', 'Jaringan Inovasi Plus Daerah Kota Samarinda — Platform Pengajuan & Evaluation Inovasi.')">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="@yield('title', config('app.name', 'JARSIPLUS Samarinda'))">
    <meta property="og:description" content="@yield('meta_description', 'Jaringan Inovasi Plus Daerah Kota Samarinda')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/brand/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css">
    @php
        // Cache-busting berbasis waktu ubah berkas. config('app.version') tidak
        // pernah didefinisikan sehingga nilainya selalu "3.1" dan browser terus
        // memakai CSS/JS lama setiap kali aset diperbarui.
        //
        // Docroot yang benar-benar disajikan adalah public_html/ (di situlah
        // index.php berada), sementara public_path() menunjuk ke public/.
        // Karena itu public_html/ diperiksa lebih dulu.
        $jpAssetVersion = function (string $path) {
            foreach ([base_path('public_html/' . $path), public_path($path)] as $candidate) {
                if (file_exists($candidate)) {
                    return filemtime($candidate);
                }
            }
            return config('app.version', '3.1');
        };
    @endphp

    <link rel="stylesheet" href="{{ asset('css/jarsiplus-tokens.css?v='.$jpAssetVersion('css/jarsiplus-tokens.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/jarsiplus.css?v='.$jpAssetVersion('css/jarsiplus.css')) }}">
    <style>
        /* Select2 Cobalt Spacious Premium Styles */
        .select2-container--default .select2-selection--single {
            height: 46px !important;
            border: 1px solid var(--c-border) !important;
            border-radius: 8px !important;
            padding: 8px 14px !important;
            font-size: 13.5px !important;
            background-color: #FFFFFF !important;
            display: flex !important;
            align-items: center !important;
            box-shadow: 0 1px 2px rgba(15,23,42,0.04) !important;
            transition: all 0.2s ease !important;
        }
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--c-accent) !important;
            box-shadow: 0 0 0 3px rgba(0,71,255,0.12) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--c-text) !important;
            line-height: normal !important;
            padding-left: 0 !important;
            font-weight: 500 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
            right: 10px !important;
        }
        .select2-dropdown {
            border: 1px solid var(--c-border) !important;
            border-radius: 10px !important;
            box-shadow: 0 20px 45px rgba(15,23,42,0.18) !important;
            background: #FFFFFF !important;
            padding: 6px !important;
            z-index: 999999 !important;
        }
        .select2-search--dropdown {
            padding: 6px 6px 8px 6px !important;
        }
        .select2-search__field {
            border: 1px solid var(--c-border) !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
            font-size: 13px !important;
            outline: none !important;
            background-color: var(--c-bg) !important;
        }
        .select2-results__option {
            padding: 10px 14px !important;
            font-size: 13px !important;
            line-height: 1.5 !important;
            border-radius: 6px !important;
            margin-bottom: 2px !important;
            color: var(--c-text) !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--c-accent) !important;
            color: #FFFFFF !important;
            font-weight: 600 !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: var(--c-accent-soft) !important;
            color: var(--c-accent) !important;
            font-weight: 700 !important;
        }
    </style>
    @yield('css')
    @stack('css')
</head>
<body>
    <a href="#main" class="u-sr-only">Lewati ke konten utama</a>

    @unless(request()->is('login*') || View::hasSection('no_layout'))
        @include('template::layouts.partials.header')
    @endunless

    <main id="main">
        @yield('content')
    </main>

    @unless(request()->is('login*') || View::hasSection('no_layout'))
        @include('template::layouts.partials.footer')
    @endunless

    {{-- Iconify tidak lagi dimuat: seluruh ikon frontend kini SVG inline lokal
         (lihat components/icon.blade.php), sehingga tidak ada permintaan ke
         api.iconify.design dan ikon tetap tampil tanpa koneksi. --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js"></script>
    <script>
        // Global SweetAlert2 Alert & Confirm Overrides
        window.nativeAlert = window.alert;
        window.alert = function(message, title = 'Perhatian', icon = 'warning') {
            if (typeof Swal !== 'undefined') {
                return Swal.fire({
                    title: title,
                    text: message,
                    icon: icon,
                    confirmButtonColor: '#0047FF',
                    confirmButtonText: 'Ya, Mengerti'
                });
            } else {
                window.nativeAlert(message);
            }
        };

        window.confirmSwal = function(message, callback, title = 'Konfirmasi Tindakan', confirmBtnText = 'Ya, Lanjutkan') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: title,
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0047FF',
                    cancelButtonColor: '#64748B',
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed && typeof callback === 'function') {
                        callback();
                    }
                });
            } else if (confirm(message)) {
                if (typeof callback === 'function') callback();
            }
        };

        // Automatic Select2 Initialization
        $(document).ready(function() {
            function initSelect2() {
                $('select.jp-input, select.select2').each(function() {
                    if (!$(this).hasClass('select2-hidden-accessible') && !$(this).hasClass('no-select2') && !$(this).closest('dialog, .jp-modal').length) {
                        var ph = $(this).find('option[value=""]').text() || '-- Pilih Salah Satu --';
                        $(this).select2({
                            placeholder: ph,
                            allowClear: true,
                            width: '100%'
                        });
                    }
                });
            }

            initSelect2();
            $(document).on('change', '#modal_jenis', function() {
                setTimeout(initSelect2, 100);
            });
        });
    </script>

    {{-- SweetAlert2 Automatic Trigger for Session Flash Notifications --}}
    @if(function_exists('notify') && notify()->ready())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: "{{ ucfirst(notify()->type() == 'danger' ? 'Perhatian' : (notify()->type() == 'success' ? 'Berhasil' : notify()->type())) }}",
                        text: "{!! addslashes(notify()->message()) !!}",
                        icon: "{{ notify()->type() == 'danger' ? 'error' : (notify()->type() == 'success' ? 'success' : (notify()->type() == 'warning' ? 'warning' : 'info')) }}",
                        confirmButtonColor: '#0047FF',
                        confirmButtonText: 'OK, Mengerti'
                    });
                }
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{!! addslashes(session('success')) !!}",
                        icon: 'success',
                        confirmButtonColor: '#0047FF',
                        confirmButtonText: 'OK, Mengerti'
                    });
                }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Terjadi Kesalahan',
                        text: "{!! addslashes(session('error')) !!}",
                        icon: 'error',
                        confirmButtonColor: '#0047FF',
                        confirmButtonText: 'OK, Mengerti'
                    });
                }
            });
        </script>
    @endif

    @if(session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Peringatan',
                        text: "{!! addslashes(session('warning')) !!}",
                        icon: 'warning',
                        confirmButtonColor: '#0047FF',
                        confirmButtonText: 'OK, Mengerti'
                    });
                }
            });
        </script>
    @endif

    <x-chatbot-widget />

    <script defer src="{{ asset('js/jarsiplus.js?v='.$jpAssetVersion('js/jarsiplus.js')) }}"></script>
    @yield('js')
    @stack('js')
</body>
</html>
