<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title') </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('metronic/css/pages/login/classic/login-2.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/plugins/global/plugins.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/style.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/header/base/light.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/header/menu/light.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/brand/dark.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/themes/layout/aside/dark.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/layouts/auth.css?v=7.0.4') }}" type="text/css" rel="stylesheet" />
    @stack('styles')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-row-fluid bg-white" id="kt_login">
            <div class="login-aside order-2 order-lg-1 d-flex flex-column-fluid flex-lg-row-auto bgi-size-cover bgi-no-repeat p-7 p-lg-10">
                <div class="d-flex flex-row-fluid flex-column justify-content-between">
                    <div class="d-flex flex-column-fluid flex-column flex-center mt-5 mt-lg-0">
                        <a href="{{ route("login") }}" class="mb-15 text-center">
                            <img src="{{ asset('images/logos/logo.png') }}" class="max-h-55px" alt="" />
                        </a>
                        <div class="login-form login-signin">
                            <div class="text-center mb-10 mb-lg-20">
                                <h2 class="font-weight-bold">@yield("title")</h2>
                                <p class="text-muted font-weight-bold">@yield("subtitle")</p>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                    <div class="d-flex flex-column-auto justify-content-between mt-15">
                        <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">{{ date("Y") }} PROCDGA</div>
                    </div>
                </div>
            </div>
            <div class="order-1 order-lg-2 flex-column-auto flex-lg-row-fluid d-flex flex-column p-7" style="background-image: url({{ asset('metronic/media/bg/bg-finanzas.jpg') }});">
                <div class="d-flex flex-column-fluid flex-lg-center">
                    <div class="d-flex flex-column justify-content-center">
                        <h3 class="display-3 font-weight-bold my-7 text-white">Bienvenido al sistema PROCDGA</h3>
                        <p class="font-weight-bold font-size-lg text-white opacity-80">Procesos administrativos de la Secretaría de Administración y Finanzas
                        <br /> de la Ciudad de México.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    </script>
    <script src="{{ asset('metronic/plugins/global/plugins.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('metronic/js/scripts.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/jqueryvalidate/messages_es.js') }}"></script>
    <script src="{{ asset('js/validacion_formularios/validacion_formularios.js') }}"></script>
    <script src="{{ asset('js/layouts/auth.js?v=1.16') }}"></script>
    <script>
        var asset = @json(asset(''));
    </script>
    @stack('scripts')
</body>
</html>
