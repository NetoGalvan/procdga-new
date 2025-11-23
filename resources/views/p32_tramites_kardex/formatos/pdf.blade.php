@php
    use App\Models\Formato;
    use Carbon\Carbon;
    $formato = Formato::where("identificador", "formato_kardex_principal")->first();
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <style>
        @page {
            margin: 250px 40px 70px 40px;
        }
        header {
            position: fixed;
            top: -250px;
            left: 0px;
            right: 0px;
            height: 250px;
        }
        footer {
            position: fixed;
            bottom: -70px;
            left: 0px;
            right: 0px;
            height: 70px;
        }
        .logo {
            height: 80px;
            width: auto;
            object-fit: contain; /* Asegura que la imagen se ajuste dentro del contenedor sin distorsionarse */
        }
        #logo_pie {
            height: 20px;
            width: auto;
            object-fit: contain; /* Asegura que la imagen se ajuste dentro del contenedor sin distorsionarse */
        }
    </style>
    <link href="{{ asset('css/layouts/pdf.css?v=1.1') }}" type="text/css" rel="stylesheet" />
    @stack('styles')
</head>
<body class="@isset($debug) border-1px @endisset">
    <header class="font-size-12">
        <table class="pt-8 w-100">
            <tr>
                <td class="w-50">
                    <img class="logo" src="{{ asset($formato->logo_principal) }}">
                </td>
                <td class="w-50">
                    <p class="m-0">
                        {!! $formato->texto_encabezado !!}
                    </p>

                </td>
            </tr>
            <tr>
                <td class="w-50 pt-1">
                     <span style="color: transparent"></span>
                </td>
                <td class="w-50 pt-1 text-right"">
                    <img class="logo" src="{{ asset($formato->logo_secundario) }}">
                </td>
            </tr>
            <tr>
                <td class="w-50 pt-1">
                     <span style="color: transparent"></span>
                </td>
                <td class="w-50 pt-1 text-right">
                    <div>Ciudad de México, {{ convertirFechaFormatoMX(Carbon::now()) }}</div>
                    <div class="mt-2"><strong>@yield("folio")</strong></div>
                </td>
            </tr>
        </table>
    </header>
    <footer class="font-size-12">
        <table class="w-100">
            <tr>
                <td class="w-50 pt-1">
                    <span>{!! $formato->texto_pie !!}</span>
                </td>
                <td class="w-50 pt-1 text-right"">
                    <img id="logo_pie" src="{!! $formato->logo_pie !!}">
                </td>
            </tr>
        </table>
    </footer>
    <main>
        @yield("contenido")
    </main>
</body>
</html>
