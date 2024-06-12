<!DOCTYPE html>
<html lang="id" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/ico" href="{{ asset('favicon.ico') }}" />

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}" />

    <!-- Title -->
    @hasSection('title')
        <title>{{ $__env->yieldContent('title') }} &bullet; {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Core Hot Reload -->
    @vite('resources/js/app.js')
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('core/images/brands/png/icon-color.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('core/images/brands/png/icon-color.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <div
            class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-4">
                        <div class="text-center d-flex flex-column align-items-center gap-3">
                            <img src="{{ asset("core/images/errors/{$__env->yieldContent('code')}.svg") }}"
                                alt="modernize-img" class="img-fluid mb-4" width="400" />
                            <h1 class="fw-semibold mb-0 fs-9">
                                @yield('code')
                            </h1>
                            <h4 class="fw-semibold mb-4 text-muted">
                                @yield('message')
                            </h4>

                            <div class="mx-auto">
                                @if ($__env->yieldContent('code') !== '503')
                                    <a class="btn btn-primary" href="{{ url('/panel') }}" role="button">Kembali Ke
                                        Beranda</a>
                                @endif
                            </div>

                            <img src="{{ asset('core/images/brands/svg/logo-color.svg') }}" alt="SIDEKA DKD Jatim"
                                height="48" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- Import Js Files -->
    <script src="{{ asset('dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--  core files -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
