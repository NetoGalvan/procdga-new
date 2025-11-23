@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

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
                'titulo' => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->area->identificador }} - {{ $premioPuntualidad->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Quincena de pago </label>
                    <span class="valor-dato"> {{ $premioPuntualidad->quincena }} </span>
                </div>
                <div class="col-md-12">
                    <label class="titulo-dato"> Instrucciones </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->instrucciones }} </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Áreas</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    Se muestra el listado de las áreas incluidas en este proceso de pago de premio de puntualidad y asistencia.
                </div>
                <div class="col-md-12">

                    <table
                        id="tabla_subproceso"
                        class="text-center"
                        data-toggle="table"
                        data-data-field="data"
                        data-total-field="total"
                        data-pagination="true"
                        data-page-size="10"
                        data-search="false"
                        data-pagination-h-align="left"
                        data-pagination-detail-h-align="right"
                        data-search-align="right">
                        <thead>
                            <th data-field="area_id" data-visible="false">Id</th>
                            <th data-field="areas" data-formatter="areasFormatter" data-align="center"><label class="titulo-dato">Áreas</label></th>
                        </thead>
                    </table>

                </div>
            </div>

            <form action="{{ route('generacion.archivos.pago', [$premioPuntualidad, $instanciaTarea]) }}"  method="POST" id="form_generacion_archivos">
                @method('post') @csrf
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{-- <a type="button" id="descargar_relacion" class="btn btn-danger" data-toggle="tooltip" title="Descargar relación de empleados para pago"> <i class="fas fa-file-pdf"></i> Descargar relación de empleados para pago </a> --}}
                        <a type="button" id="descargar_con_nombres" class="btn btn-success" data-toggle="tooltip" title="Descargar layout con nombres"> <i class="fas fa-file-excel"></i> Descargar layout con nombres </a>
                        <a type="button" id="descargar_sin_nombres" class="btn btn-success" data-toggle="tooltip" title="Descargar layout sin nombres"> <i class="fas fa-file-excel"></i> Descargar layout sin nombres </a>
                    </div>
                </div>
            </form>

        </div>
        <div class="card-footer">
            <div class="text-center">
                <button type="button" class="btn btn-danger" id="btn_cancelar_proceso"><i class="fas fa-trash"></i>Cancelar proceso</button>

                <button type="button" id="btn_finalizar" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar proceso</button>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/TPPA03_generacionArchivoPagos.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        let subprocesos = @json($subprocesos);
        let premioPuntualidad = @json($premioPuntualidad);
        let urlDescargarLayoutConNombres = "{{ route('descargar.excel.layout.con.nombres') }}";
        let urlDescargarLayoutSinNombres = "{{ route('descargar.excel.layout.sin.nombres') }}";
        let urlDescargarRelacionEmpleados = "{{ route('descargar.pdf.relacion.empleados') }}";
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
