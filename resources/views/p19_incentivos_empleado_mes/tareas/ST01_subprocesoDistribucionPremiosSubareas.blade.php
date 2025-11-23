@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

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
                'titulo' => $instanciaTarea->tarea->nombre
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

@section('contenido')

    <form method="POST" id="form_subproceso_distribuir_premios_subareas" action="{{ route('incentivos.empleado.mes.subproceso.distribucion.premios.subarea', [$subproceso->p19_subproceso_id, $instanciaTarea->instancia_tarea_id]) }}">
        @method('POST')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Incentivo empleado del mes</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <p>Se ha lanzado el proceso de pago del premio incentivo del mes:</p>
                                <ul>
                                    <ol>Atienda a los comentarios de la Subdirección de Prestaciones y Capacitación</ol>
                                    <ol>Asigne los premios para cada una de sus sub áreas</ol>
                                    <ol>Dé indicaciones precisas a sus operadores de premio incentivo del mes</ol>
                                </ul>
                                <br>
                                <p>NOTA: existen áreas que NO ESTÁN INCLUÍDAS debido a que NO cuentan con usuarios con roles:</p>
                                <ul>
                                    <li>SUB_EA - Subdirector de Enlace Administrativo</li>
                                    <li>OPER_INC_19 - Operador de incentivo</li>
                                </ul>
                                <p>Si requiere que se incluya a alguna de las áreas:</p>
                                <ol>
                                    <li>Salga de la tarea</li>
                                    <li>Comuníquese con la área encargada para que haga las asignaciones de usuarios necesarias</li>
                                    <li>Una vez hechas las asignaciones de usuarios, regrese a esta la tarea y continúe normalmente</li>
                                </ol>
                            </div>
                        </div>
                        <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Distribución de premios por áreas</h3>
                </div>
            </div>
            <div class="card-body" >

                <div class="row mb-6">
                    <div class="col-md-4">
                        <label class="titulo-dato"> Folio: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->folio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subproceso->area->identificador) }} - {{ mb_strtoupper($subproceso->area->nombre) }}  </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Premios autorizados: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->premios_aprobados }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Quincena de pago: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->nombre_quincena }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Mes a evaluar: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->nombre_mes_anio_evaluacion }} </b> </span>
                    </div>
                    <div class="col-md-12">
                        <label class="titulo-dato"> Instrucciones Áreas: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subproceso->comentarios_opera_incen) }} </b> </span>
                    </div>

                </div>

                <br>
                <br>

                <input type="hidden" id="arreglo_sub_areas" name="arreglo_sub_areas" value="">
                <input type="hidden" id="premios_asignados_total" name="premios_asignados_total" value="">
                <div class="row">
                    <div class="col-12 form-group">
                        <table id="tabla_subproceso_distribuir_premios_subarea"
                            data-unique-id="area_id"
                            data-total-field="total"
                            data-data-field="data"
                            data-side-pagination="server"
                            data-pagination="true"
                            data-query-params="queryParams"
                            data-search="false"
                            data-search-align="right"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-cache="false">
                            <thead>
                                <tr>
                                    <th data-field="identificador" class="text-center"><label class="titulo-dato"><b>Identificador</b></label></th>
                                    <th data-field="nombre" class="text-center"><label class="titulo-dato"><b>Áreas</b></label></th>
                                    <th data-field="cantidad_premios" class="text-center cantidad" data-formatter="cantidadPremiosFormatter"><label class="titulo-dato"><b>Cantidad premios</b></label></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="alert alert-custom alert-outline-success" role="alert">
                            <div class="alert-text">
                                <div class="row">

                                    <div class="col-md-4">
                                        <h5 class="premios-autorizados text-center"></h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="premios-asignados text-center"></h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="premios-restantes text-center"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="comentarios_sub_ea" class="titulo-dato"><span class="requeridos">* <b> </span>Instrucciones para áreas </b></label>
                        <textarea class="form-control normalizar-texto" name="comentarios_sub_ea" id="comentarios_sub_ea" required campoNoVacio="true"></textarea>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_continuar_proceso" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        .cantidad {
            width: 10%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const subAreas        = @Json($subAreas);
        const subproceso      = @Json($subproceso);
        const urlTareas       = @Json( route('tareas') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/tareas/ST01_subprocesoDistribucionPremiosSubareas.js?v=1.0') }}"></script>
@endpush
