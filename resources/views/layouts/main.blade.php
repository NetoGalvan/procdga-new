<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('metronic/plugins/global/plugins.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/style.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/header/base/light.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/header/menu/light.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/brand/light.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/aside/light.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/layouts/main.css?v=7.24') }}" type="text/css" rel="stylesheet" />
    @stack('styles')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading {{ session("asideMinimize") ? 'aside-minimize' : ''}}">
    @include('layouts.partials.main.header_movile')
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
                @include('layouts.partials.main.aside_header')
                @yield('aside_menu')
            </div>
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                @include('layouts.partials.main.header')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @yield('subheader')
                    <div class="d-flex flex-column-fluid">
                        <div class="container-fluid">
                            @yield('contenido')
                        </div>
                    </div>
                </div>
                @include('layouts.partials.main.footer')
            </div>
        </div>
    </div>
    <div id="sidebar-overlay" class="sidebar-overlay"></div>
    @include('layouts.partials.main.user_panel')
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121"},
                    "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0"},
                    "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff"}
                },
                "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121"}
            },
            "font-family": "Poppins"
        };

        var asideMinimize = @json(session('asideMinimize'));
        var rutaTotalNotificaciones = @json(route("getTareas", ["NOTIFICACION", "TOTAL_REGISTROS"]));
    </script>
    <script src="{{ asset('metronic/plugins/global/plugins.bundle.js?v=7.0.5') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('metronic/js/scripts.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/jqueryvalidate/messages_es.js') }}"></script>
    <script src="{{ asset('js/layouts/main.js?v=1.21') }}"></script>
    <script src="{{ asset('js/validacion_formularios/validacion_formularios.js?v=1.0') }}"></script>
    <script src="{{ asset('js/validacion_formularios/validacion_regex.js') }}"></script>
    <script>
        var asset = @json(asset(''));
        @if (session('success') || session('mensaje'))
            Swal.fire("{{ session('success') ?? session('mensaje') }}", "", "success");
        @endif
        @if (session('error'))
            Swal.fire("{{ session('error') }}", "", "error");
        @endif

        blockBack();
    </script>
    @stack('scripts')
</body>
</html>
