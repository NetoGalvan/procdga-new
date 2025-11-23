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
                <h3 class="card-label">{{$instanciaTarea->tarea->nombre}}</h3>
            </div>
            <div class="form-group">
                <form action="{{ route('cancelar.proceso.solicitud.expediente', [$solicitud, $instanciaTarea]) }}" method="POST" id="frm_solicitud_cancelar_proceso">
                    @method('post') @csrf
                    <label for="" class="titulo-dato" style="color:white;">a</label>
                    <button type="submit" class="btn btn-danger" id="btn_cancelar_proceso"><i class="fas fa-trash"></i>Cancelar proceso</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="titulo-dato"> Unidad administrativa </label>
                    <span class="valor-dato">  {{ $solicitud->area->identificador }} - {{ $solicitud->area->nombre }} </span>
                </div>
                <div class="col-md-6">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $solicitud->instancia->folio }} </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Instrucciones</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li>1. Seleccione el tipo de préstamo que desea solicitar puede ser:</li>
                            <ul>
                                <li>Solicitud de expediente: Permite realizar una solicitud de préstamo de los documentos que conforman el expediente de un trabajador.</li>
                                <li>Solicitud de recibos timbrados: Permite realizar una solicitud de los recibos timbrados de los empleados o prestadores de servicios correspondiente a los pagos de nóminas extraordinarias.</li>
                            </ul>
                        <li>2. Ingrese los datos de búsqueda de acuerdo al tipo de préstamo que solicito (puede ser número de empleado o RFC o Número de expediente).</li>
                        <li>3. Seleccione los datos del expediente o del recibo que desea solicitar.</li>
                        <li>4. Si no se encuentran datos del expediente que requiere: Describa minuciosamente tanto los datos del empleado como los documentos que requiere en el área de Comentarios</li>
                        <li>5. Complete los datos del solicitante.</li>
                        <li>6. Al terminar presione el botón para continuar...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('solicitud.expediente.solicitud.prestamo.expediente', [$solicitud, $instanciaTarea]) }}"  method="POST" id="frm_solicitud_seleccion_prestamo">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Selección de tipo de préstamo</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Tipo de prestamo</strong></label>
                            <select class="form-control form-control-sm  normalizar-texto" name="tipo_prestamo" id="tipo_prestamo" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipo_prestamo as $k => $v)
                                    <option value="{{ $k }}" @if(old('tipo_prestamo') == $k) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                    <div class="col-md-3 align-middle">
                        <div class="form-group">
                            <label id="label_rfc" class="titulo-dato"><strong><span class="requeridos">* </span>RFC</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="rfc" id="rfc" autocomplete="off" maxlength="13" required RFC="true" value="{{ old('rfc') }}">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label id="a" class="titulo-dato" style="color: white">a</label>
                            <button type="button" id="buscar" class="btn btn-primary"><i class="fas fa-search"></i>Buscar</button>
                            <button type="button" id="limpiar" class="btn btn-warning"><i class="fas fa-brush"></i>Limpiar</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none" id="datos_del_expediente">
                    <div class="col-md-12 form-group">
                        <table class="table table-bordered table-general" id="datos_expediente" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
                            <thead>
                                <th class="text-center" data-field="id" data-visible="false"><label class="titulo-dato"> Id </label></th>
                                <th class="text-center" width="15%" data-field="numero_expediente" data-formatter="expedienteFormatter"><label class="titulo-dato"> Número de expediente </label></th>
                                <th class="text-center" width="15%" data-field="rfc" data-formatter="rfcFormatter"><label class="titulo-dato"> RFC </label></th>
                                <th class="text-center" width="30%" data-field="nombre" data-formatter="nombreCompletoFormatter"><label class="titulo-dato"> Nombre </label></th>
                                <th class="text-center" width="15%" data-field="numero_empleado" data-formatter="empleadoFormatter"><label class="titulo-dato"> Número de empleado </label></th>
                                <th class="text-center" width="5%" data-field="seleccione" data-formatter="accionesFormatter"><label class="titulo-dato"> Seleccione </label></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la solicitud</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Tipo de expediente</strong></label>
                            <select class="form-control form-control-sm  normalizar-texto" name="tipo_expediente" id="tipo_expediente" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipo_expediente as $k => $v)
                                    <option value="{{ $k }}" @if(old('tipo_expediente') == $k) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                    <div class="col-md-9 align-middle">
                        <div class="form-group">
                            <label id="label_comentarios" class="titulo-dato"><strong><span class="requeridos">* </span>Comentarios</strong></label>
                            <textarea rows="4" class="form-control form-control-sm normalizar-texto" autocomplete="off" name="comentarios" id="comentarios" required value="{{ old('comentarios') }}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del solicitante</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Tipo de solicitante</strong></label>
                            <select class="form-control form-control-sm  normalizar-texto" name="tipo_solicitante" id="tipo_solicitante" onChange="mostrar(this.value);" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipo_solicitante as $k => $v)
                                    <option value="{{ $k }}" @if(old('tipo_solicitante') == $k) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 align-middle" id="div_nombre" style="display: none">
                        <div class="form-group">
                            <label id="label_nombre" class="titulo-dato"><strong><span class="requeridos">* </span>Nombre</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="nombre" id="nombre" autocomplete="off" required value="{{ old('nombre') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-middle" id="div_cargo" style="display: none">
                        <div class="form-group">
                            <label id="label_cargo" class="titulo-dato"><strong><span class="requeridos">* </span>Cargo</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="cargo" id="cargo" autocomplete="off" required value="{{ old('cargo') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-middle" id="div_dependencia" style="display: none">
                        <div class="form-group">
                            <label id="label_dependencia" class="titulo-dato"><strong><span class="requeridos">* </span>Dependencia</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="dependencia" id="dependencia" autocomplete="off" required value="{{ old('dependencia') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-middle" id="div_referencia" style="display: none">
                        <div class="form-group">
                            <label id="label_referencia_u_oficio" class="titulo-dato"><strong><span class="requeridos">* </span>Referencia u oficio</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="referencia_u_oficio" id="referencia_u_oficio" autocomplete="off" required value="{{ old('referencia_u_oficio') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-middle" id="div_unidad" style="display: none">
                        <div class="form-group">
                            <label id="label_unidad_administrativa" class="titulo-dato"><strong><span class="requeridos">* </span>Unidad administrativa</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="unidad_administrativa" id="unidad_administrativa" autocomplete="off" required value="{{ old('unidad_administrativa') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-middle" id="div_parentesco" style="display: none">
                        <div class="form-group">
                            <label id="label_parentesco" class="titulo-dato"><strong><span class="requeridos">* </span>Parentesco</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="parentesco" id="parentesco" autocomplete="off" required value="{{ old('parentesco') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-middle" id="div_razon" style="display: none">
                        <div class="form-group">
                            <label id="label_razon_solicitud" class="titulo-dato"><strong><span class="requeridos">* </span>Razón de solicitud</strong></label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="razon_solicitud" id="razon_solicitud" autocomplete="off" required value="{{ old('razon_solicitud') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del funcionario a través del cual se hace la solicitud</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="titulo-dato"> Solicitud iniciada por: </label>
                        <span class="valor-dato">  {{ $solicitud->instancia->folio }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Con cargo: </label>
                        <span class="valor-dato">  {{ $solicitud->instancia->folio }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> En la unidad administrativa: </label>
                        <span class="valor-dato">  {{ $solicitud->instancia->folio }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> En fecha: </label>
                        <span class="valor-dato">  {{ $solicitud->instancia->folio }} </span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_TSOL01" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/p23_solicitud_expediente/tareas/TSOL01_solicitudPrestamoExpediente.js?ver=1.0') }}"></script>
    <script>
        var buscarExpedienteTrabajador = "{{ route('buscar.expediente.trabajador') }}";
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
