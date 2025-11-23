@extends('layouts.main')

@section('title', 'BUSQUEDA DE EXPEDIENTE')

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'BUSQUEDA DE EXPEDIENTE'
            ]
        ]
    ]])
@endsection

@section('contenido')
    @include('p23_digitalizacion_archivo.partials.detalles_proceso')
    <form method="POST" id="form_buscar_expediente">
        @csrf @method('post')
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Buscar expediente</h3>
                </div>
            </div>
            <div class="card-body py-4">
                <div class="alert alert-custom alert-success py-0 pt-2" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2 font-size-xl">Instrucciones:</p>
                            <ul class="mb-0">
                                <li>
                                    Buscar expediente atraves del número de empleado, nombre del empleado, rfc o número de expediente.
                                </li>
                                <li>
                                    Seleccione la ficha del expediente que desea digitalizar.
                                </li>
                                <br>
                                NOTA:
                                <p class="font-size-lg">
                                    Si no encuentra la ficha del expediente deseado o ningún resultado correspondiente, seleccione el botón de "Crear nuevo expediente".
                                </p>
                            </ul>
                        </strong>
                    </div>
                </div>
                <hr>

                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" id="tabla_expedientes"
                    data-toggle="table"
                    data-search="true"
                    data-search-align="left"
                    data-pagination="true"
                    data-page-size="10"
                    data-page-list="[10, 25, 50, 100]"
                    >
                        <thead>
                            <tr>
                                <th data-field="numero_empleado" class="text-center w-20">
                                    <label class="titulo-dato">Número de empleado</label>
                                </th>
                                <th data-field="nombre_empleado_completo" class="w-20">
                                    <label class="text-center titulo-dato">Nombre del Empleado</label>
                                </th>
                                <th data-field="rfc" class="text-center w-20">
                                    <label class="titulo-dato">RFC</label>
                                </th>
                                <th data-field="numero_expediente" class="text-center w-20">
                                    <label class="titulo-dato">Número de expediente</label>
                                </th>
                                <th data-field="archivo_digitalizado" class="text-center w-20">
                                    <label class="titulo-dato">Archivo digitalizado</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indiceDigitalizacion as $indice)
                            <tr class="cursor-pointer" 
                            data-url="{{ route('digitalizacion.archivos.expediente.encontrado', [$digitalizacion, $instanciaTarea, $indice->numero_expediente]) }}"
                            data-expediente="{{$indice->numero_expediente}}"
                            >
                                <td>{{$indice->numero_empleado}}</td>
                                <td>{{$indice->nombre_empleado_completo}}</td>
                                <td>{{$indice->rfc}}</td>
                                <td>{{$indice->numero_expediente}}</td>
                                <td>
                                    @if(!is_null($indice->archivo_expediente))
                                        <span class="badge badge-primary">Si</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="crearFichaExpediente" name="nuevo_expediente" class="btn btn-primary">
                        <i class="far fa-address-card"></i>Crear nuevo expediente
                    </button>
                    <button id="cancelar_proceso" class="btn btn-danger" type="button">
                        <i class="fas fa-times"></i>Cancelar proceso
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_buscarDatosExpediente = "{{ route('digitalizacion.archivos.buscar.datos.expediente', [$digitalizacion, $instanciaTarea]) }}";  
        var URL_cancelarProceso = "{{ route('cancelar.proceso.digitalizacion.archivo', [$digitalizacion, $instanciaTarea]) }}";

        var formBuscarExpediente = $('#form_buscar_expediente');
    </script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/sweet_alert_general.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/tareas/TDIG01_buscarDatosExpediente.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush