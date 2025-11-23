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

@section('contenido')
    @if ($instanciaTarea->estatus == 'EN_CORRECCION')
        <div class="alert alert-custom alert-success mb-8" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">
                <h4 class="alert-heading">SOLICITUD CORREGIDA</h4>
                <p> La solicitud fue corregida, descargue y vuelva a enviar el archivo para el SUN con los datos actualizados.</p>
            </div>
        </div>
    @endif        
    <form id="formFinalizarReanudaciones" action="{{ route('movimiento.personal.reanudaciones.procesamiento.sun', [$movimientoPersonal, $instanciaTarea]) }}" method="POST">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general_reanudaciones", [
                    "secciones" => [
                        "general" => ["datos_generales", "tipo_movimiento", "fecha_solicitud", "firmas"],
                        "plaza" => [],
                        "candidato" => [],
                    ]
                ])
            </div>
        </div> 
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Respuesta del SUN</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success mb-10" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Antes de continuar, debe haber generado y enviado el archivo excel al SUN. 
                        Acuda a la sección de archivos para sistemas externos en el rubro de archivos para el SUN y genere el excel con los movimientos acumulados.
                    </div>
                </div>
                <div class="row" id="id_contenedor_respuesta">
                    <div class="col-xl-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Respuesta:</strong></label>
                        <select class="form-control" id="estatus" name="estatus" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>                                          
                            <option value="COMPLETADO">Terminar con éxito</option>
                            <option value="RECHAZADO">Rechazado</option>
                        </select>
                    </div>
                    <div id="id_contenedor_motivo_rechazo" class="col-xl-12 d-none">
                        <div class="row">
                            <div class="col-xl-10 form-group">
                                <label class="titulo-dato"><strong><span class="text-danger">* </span>Motivo de rechazo:</strong></label>
                                <textarea class="form-control normalizar-texto" placeholder="Escriba el motivo" id="motivo_rechazo" name="motivo_rechazo" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="id_contenedor_procesamiento" class="col-xl-12 d-none">
                        <div class="row">
                            <div class="col-xl-12"> 
                                <h2 class="titulo-formulario">Procesamiento</h2>
                                <hr>
                            </div>
                            <div class="col-xl-4 form-group">
                                <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de elaboración</strong></label>
                                <input type="text" id="fecha_elaboracion" name="fecha_elaboracion" class="form-control input-date-current" autocomplete="off" readonly required>
                            </div>
                            <div class="col-xl-4 form-group">
                                <label class="titulo-dato"><strong><span class="text-danger">* </span>Año de procesado</strong></label>
                                <input type="text" id="anio_procesado" name="anio_procesado" class="form-control input-year-current" autocomplete="off" readonly required>
                            </div>
                            <div class="col-xl-4 form-group">
                                <label class="titulo-dato"><strong><span class="text-danger">* </span>Quincena de procesado</strong></label>
                                <select name="qna_procesado" class="form-control" required>
                                    <option value="">Seleccione una quincena</option>
                                    @php 
                                        use Carbon\Carbon;
                                    @endphp
                                    @foreach (traerQuincenasActual(Carbon::now(), Carbon::now()) as $quincena)   
                                        <option value="{{ $quincena }}">{{ $quincena }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button id="btn_enviar_form" type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')	
    <script src="{{ asset('js/p01_movimientos_personal/tareas/TR03_finalizacionMovimientoReanudaciones.js?v=1.0')}}"></script> 
@endpush

