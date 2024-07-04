<!doctype html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="{{ asset('/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('/assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('/assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('/assets/css/style-preset.css') }}" />
    @yield('css')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
    <div class="page-loader">
        <div class="bar"></div>
    </div>

    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid logo-lg" alt="logo" />
                    <span class="badge bg-light-success rounded-pill ms-1 theme-version">v1.0</span>
                </a>
            </div>
            <div class="navbar-content">
                @include('layouts.menubar')
            </div>
        </div>
    </nav>

    <header class="pc-header">
        @include('layouts.header')
    </header>

    <div class="pc-container">
        {{ $slot }}
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="my-1 col">
                    <p class="m-0">
                        &copy; {{ date('Y') }} PT Harjulianto Teknologi Indonesia
                    </p>
                </div>
                <div class="col-auto my-1">
                    <ul class="mb-0 list-inline footer-link">
                        <li class="list-inline-item">
                            v1.0
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('/assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/feather.min.js') }}"></script>

    <script>
        layout_change('light');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>

    <script>
        main_layout_change('vertical');
    </script>

    @stack('scripts')
</body>

</html>
