@extends('layouts.main')

@section('title', 'SERVICIO SOCIAL - REPORTES - NÓMINA DE SERVICIO SOCIAL')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Reportes',
                'ruta' => Route('reportes')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'SERVICIO SOCIAL - REPORTES - NÓMINA DE SERVICIO SOCIAL'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "reportes",
        ]
    ])
@endsection

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Reporte ejecutivo de nómina.</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                      <strong>
                            <p class="mb-2">
                                NOTA: Solo se mostraran los años en los que tengan nóminas generadas en esa fecha y a su vez que dichas nominas cuenten con algún prestador {{ ($user->hasRole("SUB_EA")) ? 'de su unidad administrativa' : '' }} agregado.
                            </p>
                      </strong>
                </div>
            </div>

            <form method="POST">
            @method('post')
            @csrf
                <table class="table table-bordered table-general" id="tablaAnioNominas"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-pagination="true"
                    data-page-size="5"
                    data-page-list="[5, 10, 25, 50]"
                >
                    <thead>
                        <tr>
                            <th class="text-center">
                                <label class="titulo-dato">año</label>
                            </th>
                            <th class="text-center">
                                <label class="titulo-dato">Reporte</label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anioCreacion as $anio)
                            <tr>
                                <td> {{$anio}} </td>
                                <td>
                                    <a type="button"
                                        class="btn btn-sm btn-outline-danger btn-icon btn-descargarReporteNominas"
                                        data-toggle="tooltip"
                                        data-anio="{{$anio}}"
                                        title="Descargar reporte">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_reporteEjecutivoNomina = "{{ route('descargar.pdf.reporte.ejecutivo.nomina') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/reportes/reporteEjecutivoNomina.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
