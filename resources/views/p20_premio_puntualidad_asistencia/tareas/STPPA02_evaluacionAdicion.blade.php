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
                @if ( $subproceso->area->area_id != $subArea->area_id)
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área </label>
                        <span class="valor-dato">  {{ $subArea->area->identificador }} - {{ $subArea->area->nombre }} </span>
                    </div>
                @else
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área </label>
                        <span class="valor-dato">  {{ $subproceso->area->identificador }} - {{ $subproceso->area->nombre }} </span>
                    </div>
                @endif
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $subproceso->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Quincena de pago </label>
                    <span class="valor-dato"> {{ $subproceso->quincena }} </span>
                </div>
                <div class="col-md-12">
                    <label class="titulo-dato"> Instrucciones </label>
                    <span class="valor-dato"> {!! nl2br(e($subproceso->instrucciones)) !!} </span>
                </div>
            </div>
            @if($instanciaTarea->estatus == 'EN_CORRECCION')
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-danger" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <h3 class="text-center"><b> La tarea ha sido rechazada. </b></h3><br>
                                <h4 class="text-center"><b> Motivo: </b> {{$subArea->motivo_rechazo}} </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row my-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>
                                <ol>
                                    <li>Avise a los empleados que estén interesados en recibir el premio de puntualidad en la quincena de pago indicada. </li><br>
                                    <li>Atienda a las indicaciones del Subdirector de Enlace de su unidad administrativa.</li><br>
                                    <li>No podán participar empleados que no cuentes con digíto sindical.</li><br>
                                    <li>Selecciona el mes que quiera evalar y en el siguiente campo coloque el RFC o Número de empleado, te mostrará las coincidencias de tu busqueda y posteriormente podrás eligir el que quieras.</li><br>
                                    <li>Despúes de elegir el mes de inicio de evaluación y el empleado, da click en el botón "Evaluar" en ese momento se realizará una evaluación del empleado el mes y cinco meses posteriores.</li><br>
                                    <li>Se mostrará una tabla con la evalución del empleado seleccionado por mes: </li><br>
                                        <ol>
                                            <li>Si el resultado es <b>CALIFICA</b> puede agregarlo a la lista</li>
                                            <li>Si el resultado es <b>NO CALIFICA</b> puede seleccionar otro mes de inicio, otro empleado y volver a evaluar.</li>
                                        </ol><br>
                                    <li>En caso de que desee eliminar algun empleado de la lista, seleccione el ícono <b>Eliminar</b>.</li><br>
                                    <li><b>NO CONTINÚE LA TAREA HASTA QUE HAYA TERMINADO DE CAPTURAR A TODOS LOS EMPLEADOS QUE DEBERÁN SER INCLUÍDOS EN ESTE PROCESO.</b> Si avanza la tarea ya no podrá regresar a capturar más empleados.</li><br>
                                    <li>Atienda a los calendarios de captura. Si se atrasa, es posible que el área central o su Enlace cierre el proceso de captura y los empleados que haya acumulado <b>NO SERÁN INCLUÍDOS EN LA NÓMINA.</b></li>
                                </ol>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Búsqueda y evaluación del empleado</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('validar.empleado.premio') }}"  method="POST" id="form_busqueda_empleado">
                @method('post') @csrf
                <input type="hidden" name="evaluacion_empleado" id="evaluacion_empleado">
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato" for=""><strong><span class="requeridos">* </span></strong> Inicio mes de evaluación</label>
                        <select class="form-control select2 normalizar-texto" name="mes_inicio_evaluacion" id="mes_inicio_evaluacion" value="{{old('mes_inicio_evaluacion')}}">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($mesesEvaluacion as $k => $mes)
                            <option value="{{ $mes }}">{{ $mes }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            @include("componentes.busqueda_empleado", [
                                "existeEmpleado" => false,
                            ])
                        </div>
                    </div>
                </div>
                <button type="button" id="btn_evaluar_empleado" name="btn_evaluar_empleado" class="btn btn-primary btn_evaluar_empleado mb-5" ><i class="fas fa-check"></i> Evaluar </button>

                <div class="contenedor_tabla_evaluar_empleado d-none">
                    <table
                        id="tabla_evaluar_empleado"
                        data-unique-id=""
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
                            <th data-field="" data-visible="false">Id</th>
                            <th data-field="mes_anio" data-align="center"><label class="titulo-dato">Mes</label></th>
                            <th data-field="retardoLeve" data-align="center"><label class="titulo-dato">Retardo Leve</label></th>
                            <th data-field="retardoGrave" data-align="center"><label class="titulo-dato">Retardo Grave</label></th>
                            <th data-field="falta" data-align="center"><label class="titulo-dato">Falta</label></th>
                            <th data-field="notaBuenaRetardoLeve" data-align="center"><label class="titulo-dato">NB RL</label></th>
                            <th data-field="notaBuenaRetardoGrave" data-align="center"><label class="titulo-dato">NB RG</label></th>
                            <th data-field="licSinSueldo" data-align="center"><label class="titulo-dato">Lic. Sin Sueldo</label></th>
                            <th data-field="cuidadoMarterno" data-align="center"><label class="titulo-dato">Cuidado Materno</label></th>
                            <th data-field="licMedica" data-align="center"><label class="titulo-dato">Lic. Médica</label></th>
                            <th data-field="comisionSindical" data-align="center"><label class="titulo-dato">Comisión Sindical</label></th>
                            <th data-field="evaluacionFinal" data-formatter="evaluacionFinalFormatter" data-align="center"><label class="titulo-dato">Evaluación</label></th>
                        </thead>
                    </table>
                </div>

                <div class="contenerdor_btn_buscar_empleado d-none">
                    <button type="button" id="btn_buscar_empleado" name="btn_buscar_empleado" class="btn btn-primary btn_buscar_empleado mb-5 " ><i class="fas fa-plus"></i> Agregar </button>
                </div>
            </form>
        </div>
    </div>

    <form action="{{ route('evaluacion.adicion.empleados', [$subproceso, $instanciaTarea]) }}"  method="POST" id="form_datos_solicitudes">
    @method('post') @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de las solicitudes</h3>
                </div>
            </div>
            <div class="card-body">

                <table
                    id="tabla_empleados_agregados"
                    data-unique-id="premio_puntualidad_empleado_id"
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
                        <th data-field="premio_puntualidad_empleado_id" data-visible="false">Id</th>

                        <th data-field="numero_empleado" data-align="center"><label class="titulo-dato">Número de empleado</label></th>
                        <th data-field="nombre" data-formatter="nombreFormatter" data-align="center"><label class="titulo-dato">Nombre</label></th>
                        <th data-field="rfc" data-align="center"><label class="titulo-dato">RFC</label></th>
                        <th data-field="fecha_inicio_evaluacion" class="text-center"><label class="titulo-dato"> Periodo de evaluación </label></th>
                        <th data-field="reporte" class="text-center" data-formatter="descargarReporteFormatter"><label class="titulo-dato"> &nbsp;&nbsp;&nbsp; Reporte &nbsp;&nbsp;&nbsp; </label></th>
                        <th data-field="acciones" data-formatter="eliminarFormatter" class="text-center"><label class="titulo-dato"> Acciones </label></th>
                    </thead>
                </table>

            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/STPPA02_evaluacionAdicion.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script>
        let subproceso = @json($subproceso);
        let subArea = @json($subArea);
        let empleadosRegistrados = @json($empleadosRegistrados);
        let agregarEmpleadoRoute = "{{ route('evaluacion.adicion.empleados.agregar.empleado') }}";
        let evaluarEmpleadoRoute = "{{ route('evaluacion.adicion.empleados.evaluar.empleado') }}";
        var borrarEmpleadoAreaRoute = "{{ route('evaluacion.adicion.borrar.empleado') }}";
        let urlPdfReporteEmpleado = @json( route('descargar.pdf.empleado.agregado') );
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
