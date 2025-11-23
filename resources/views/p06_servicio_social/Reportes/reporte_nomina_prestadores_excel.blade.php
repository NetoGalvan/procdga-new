@extends('layouts.main')

@section('title', 'SERVICIO SOCIAL - REPORTES - NÓMINA PARA PRESTADORES DE SERVICIO SOCIAL')

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
                'titulo' => 'SERVICIO SOCIAL - REPORTES - NÓMINA PARA PRESTADORES DE SERVICIO SOCIAL'
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
                <h3 class="card-label">Nómina para prestadores de servicio social.</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                      <strong>
                            <p class="mb-2">
                                NOTA: Solo se mostraran las nóminas que cuenten con algún prestador 
                                {{ ($user->hasRole("SUB_EA")) ? 'de su unidad administrativa' : '' }} agregado.
                            </p>
                      </strong>
                </div>
            </div>

            <form method="POST">
            @method('post')
            @csrf
                <table class="table table-bordered table-general" id="tablaNominaServicioSocial"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-pagination="true"
                    data-page-size="10"
                    data-page-list="[10, 25, 50, 100]"
                >
                    <thead>
                        <tr>
                            <th class="text-center">
                                <label class="titulo-dato">Folio</label>
                            </th>
                            <th>
                                <label class="titulo-dato text-center">Descripción</label>
                            </th>
                            <th class="text-center" >
                                <label class="titulo-dato">Tipo de validación</label>
                            </th>
                            <th class="text-center">
                                <label class="titulo-dato">Descargar nómina</label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nominas as $nomina)
                        <tr>
                            <td> {{$nomina->folio}} </td>
                            <td> {{ (trim($nomina->descripcion)) ? $nomina->descripcion : 'S/D'}}</td>
                            <td> 
                                @switch(mb_strtoupper($nomina->tipo_validacion))
                                    @case('PARCIAL')
                                        <span class="badge badge-primary badge-sm">{{ mb_strtoupper($nomina->tipo_validacion) }}</span>
                                    @break;
                                    @case('COMPLETA')
                                        <span class="badge badge-info badge-sm">{{ mb_strtoupper($nomina->tipo_validacion) }}</span>
                                    @break
                                    @default
                                        <span class="badge badge-secondary badge-sm">{{ mb_strtoupper($nomina->tipo_validacion) }}</span>
                                    @break
                                @endswitch
                            </td>
                            <td>
                                <a type="button" class="btn btn-sm btn-outline-success btn-icon btn-descargarNomina" title="Descargar reporte"
                                    data-toggle="tooltip"
                                    data-folio="{{$nomina->folio}}"
                                >
                                    <i class="fas fa-file-excel"></i>
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
        var URL_descargarReporteNomina = "{{ route('descargar.reporte.nomina.prestadores.excel') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/reportes/reporteNominaPrestadoresExcel.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
