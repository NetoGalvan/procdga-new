@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    @php
        use Carbon\Carbon;
    @endphp     
    <form action="{{ route('movimiento.personal.altas.lista.documentacion', [$movimientoPersonal, $instanciaTarea]) }}" method="POST" id="form_lista_documentacion">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["tipo_movimiento", "fecha_Solicitud"],
                        "plaza" => [],
                        "candidato" => ["datos_psicometrico", "datos_adicionales", "datos_direccion"],
                        "movimiento" => []
                    ]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Documentación</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-light-success mb-10" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Documentación que debe contener el expediente activo del proceso de contratación de personal
                    </div>
                </div>
                <div class="row mb-10">
                    <table 
                        id="tabla_tipos_documentos" 
                        class="table" 
                        data-toggle="table">
                        <thead class="text-center">
                            <th data-field="tipo_documento_id">No.</th>
                            <th data-field="nombre">Descripción del documento</th>
                            <th data-field="se_adjunta" data-checkbox="true">¿Se adjunta?</th>
                        </thead>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Nombre: </label>
                        <span class="valor-dato"> {{ Auth::user()->nombre }} {{ Auth::user()->apellido_paterno }} {{ Auth::user()->apellido_materno }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Puesto: </label>
                        <span class="valor-dato"> {{ Auth::user()->puesto }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Área: </label>
                        <span class="valor-dato"> {{ Auth::user()->area->nombre }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Fecha: </label>
                        <span class="valor-dato normalizar-texto"> {{ convertirFechaFormatoMX(Carbon::now()) }} </span>
                    </div>                  
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button 
                        type="button"
                        id="btn_descargar_pdf"
                        class="btn btn-primary mr-2" 
                        href="{{ route('movimiento.personal.altas.descargar.lista.documentacion', $movimientoPersonal) }}">
                        <i class="fas fa-file-download"></i> Descargar PDF
                    </button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        var tiposDocumentos = @json($tiposDocumentos)
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
	<script src="{{ asset('js/p01_movimientos_personal/tareas/TA06_listaDocumentos.js?v=1.1')}}"></script>
@endpush
