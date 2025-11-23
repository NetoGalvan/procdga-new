@extends('layouts.main')

@section('title', 'Generación de documento')

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
                'titulo' => 'Generación de documento'
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

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Generación de documento</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-outline-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    Es importante que capture la información relacionada al trámite kardex en curso
                </div>
            </div>
            <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
        </div>
    </div>

    <div class="card card-custom mb-5">
        <div class="card-header card-header-tabs-line">
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_tab_datos_tramite">
                        <span class="nav-icon"><i class="flaticon2-list-1"></i></span>
                        <span class="nav-text">Datos del trámite</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_empleado">
                        <span class="nav-icon"><i class="flaticon2-map"></i></span>
                        <span class="nav-text">Dirección del empleado</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_documentos_verificados">
                        <span class="nav-icon"><i class="flaticon-doc"></i></span>
                        <span class="nav-text">Documentos verifcados</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_usuarios">
                        <span class="nav-icon"><i class="flaticon2-group"></i></span>
                        <span class="nav-text">Usuarios</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="kt_tab_datos_tramite" role="tabpanel" aria-labelledby="kt_tab_datos_tramite">
                    <div class="row">
                        <div class="col-md-4 d-flex flex-column mb-3">
                            <label class="titulo-dato"> Tipo de trámite: </label>
                            <span class="badge badge-primary"> {{ mb_strtoupper($tramiteKardex->tipoTramiteKardex->nombre) }} </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Folio: </label>
                            <span class="valor-dato"> <b> {{ $tramiteKardex->folio }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Fecha elaboración: </label>
                            <span class="valor-dato"> <b>{{ date('d-m-Y', strtotime($tramiteKardex->fecha_elaboracion_tramite))}} </b> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="titulo-dato"> Nombre del empleado: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->nombre_completo) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> No. empleado: </label>
                            <span class="valor-dato"> <b> {{ $tramiteKardex->numero_empleado }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> RFC: </label>
                            <span class="valor-dato"> <b> {{ $tramiteKardex->rfc }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> CURP: </label>
                            <span class="valor-dato"> <b> {{ $tramiteKardex->curp }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Área: </label>
                            <span class="valor-dato"> <b> {{ isset($tramiteKardex->unidad_administrativa_nombre) ? mb_strtoupper($tramiteKardex->unidad_administrativa_nombre) : '' }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Puesto: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->puesto) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Código: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->codigo_puesto) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Nivel salarial: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->nivel_salarial) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Fecha alta empleado: </label>
                            <span class="valor-dato"> <b> {{ date('d-m-Y', strtotime($tramiteKardex->fecha_alta_empleado))}} </b> </span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_datos_empleado" role="tabpanel" aria-labelledby="kt_tab_datos_empleado">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="titulo-dato"> Calle: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->calle) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Número exterior: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->numero_exterior) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Número interior: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->numero_interior) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Colonia: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->colonia) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Municipio o Alcaldia: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->municipio_alcaldia) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Ciudad: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->ciudad) }} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Entidad: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->entidad->nombre) }} </b> </span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_datos_documentos_verificados" role="tabpanel" aria-labelledby="kt_tab_datos_documentos_verificados">
                    <div class="row">
                        @foreach ($documentosVerificados as $key => $documentoVerificado)
                            <div class="col-md-4 d-flex flex-column mb-3">
                                <label class="titulo-dato"> {{ mb_strtoupper(str_replace('_', ' ', $key)) }}: </label>
                                @if ( $documentoVerificado )
                                    <span class="badge badge-success"> <i class="flaticon2-check-mark text-white"></i> VERIFICADO</span>
                                @else
                                    <span class="badge badge-danger"> <i class="flaticon2-cross text-white"></i> SIN VERIFICAR</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_datos_usuarios" role="tabpanel" aria-labelledby="kt_tab_datos_usuarios">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="titulo-dato"> Capturado por: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->apellido_materno) }} </b> </span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Asignado por: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->autorizadoPorUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->autorizadoPorUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->autorizadoPorUsuario->apellido_materno) }} </b> </span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Asignado a: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->asignadoAUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->asignadoAUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->asignadoAUsuario->apellido_materno) }} </b> </span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Solicitado por: </label>
                            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->solicitante) }} </b> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Inicio Form Seguimientos --}}
    <form method="POST" id="id_form_generacion_documento_kardex_seguimientos" >
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Añadir seguimientos</h3>
                </div>
            </div>
            <div class="card-body" >
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="table-responsive">
                            <table id="table_seguimientos" class="text-center" data-toggle="table" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="seguimiento_id" data-width="50"><label class="titulo-dato">Id</label></th>
                                        <th data-field="fecha_seguimiento" data-width="200"><label class="titulo-dato">Fecha</label></th>
                                        <th data-field="comentario_seguimiento"><label class="titulo-dato">Comentario</label></th>
                                        <th data-formatter="eliminarSeguimientoFormatter"><label class="titulo-dato">Acciones</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control normalizar-texto" id="textarea_seguimiento" rows="3" required></textarea>
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-success" id="btn_agregar_seguimiento"> <i class="fas fa-plus"></i> Agregar seguimiento </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    {{-- Fin Form Seguimientos --}}

    {{-- Inicio Form Detalles --}}
    <form method="POST" id="id_form_generacion_documento_kardex_detalles" >
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Añadir detalles</h3>
                </div>
            </div>
            <div class="card-body" >
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="table-responsive">
                            <table id="table_detalles" class="text-center" data-toggle="table" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="detalle_id"><label class="titulo-dato">Id</label></th>
                                        <th data-field="tipo_detalle"><label class="titulo-dato">Tipo de movimiento</label></th>
                                        <th data-field="motivo_baja"><label class="titulo-dato">Motivo</label></th>
                                        <th data-field="periodo" data-formatter="periodoFormatter"><label class="titulo-dato">Periodo</label></th>
                                        <th data-field="puesto" data-formatter="puestoFormatter"><label class="titulo-dato">Información</label></th>
                                        <th data-field="pagaduria"><label class="titulo-dato">Pagaduría</label></th>
                                        <th data-field="sueldo_cotizable"><label class="titulo-dato">Sueldo cotizable</label></th>
                                        <th data-field="quinquenios"><label class="titulo-dato">Quinquenios</label></th>
                                        <th data-field="otras_percepciones"><label class="titulo-dato">Otras percepciones</label></th>
                                        <th data-field="total"><label class="titulo-dato">Total</label></th>
                                        <th data-formatter="eliminarDetalleFormatter"><label class="titulo-dato">Acciones</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label></label>
                            <div class="radio-inline">
                                <label class="radio radio-rounded">
                                    <input type="radio" checked="checked" name="detalle_aportacion" id="detalle_aportacion" value="aportacion"/>
                                    <span></span>
                                    <b>APORTACIÓN</b>
                                </label>
                                <label class="radio radio-rounded">
                                    <input type="radio" name="detalle_aportacion" id="detalle_baja" value="baja"/>
                                    <span></span>
                                    <b>BAJA</b>
                                </label>
                            </div>
                            <span class="form-text text-muted">Tipo de movimiento</span>
                        </div>
                    </div>
                    <div class="col-md-8 form-group" id="grupo_motivo_baja">
                        <label for="motivo_baja" class="titulo-dato">Motivo de Baja</label>
                        <textarea rows="2" class="form-control normalizar-texto" name="motivo_baja" id="motivo_baja"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fecha_desde" class="titulo-dato"><span class="requeridos">* </span> <b> Periodo fecha desde </b> </label>
                        <input type="text" class="form-control date-general-anterior" name="fecha_desde" id="fecha_desde" autocomplete="off" placeholder="(dd-mm-yyyy)" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fecha_hasta" class="titulo-dato"><span class="requeridos">* </span> <b> Peridodo fecha hasta </b> </label>
                        <input type="text" class="form-control date-general-anterior" name="fecha_hasta" id="fecha_hasta" autocomplete="off" placeholder="(dd-mm-yyyy)" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="puesto" class="titulo-dato"><span class="requeridos">* </span> <b> Nombre puesto </b> </label>
                        <input type="text" class="form-control normalizar-texto" id="puesto" name="puesto" value="{{ $tramiteKardex->puesto }}" placeholder="Ingresa puesto" required campoNoVacio="true" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="codigo_puesto" class="titulo-dato"><span class="requeridos">* </span> <b> Código </b> </label>
                        <input type="text" class="form-control normalizar-texto" id="codigo_puesto" name="codigo_puesto" value="{{ $tramiteKardex->codigo_puesto }}" placeholder="Ingresa código de puesto" required campoNoVacio="true" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="nivel_salarial" class="titulo-dato"><span class="requeridos">* </span> <b> Nivel </b> </label>
                        <input type="text" class="form-control normalizar-texto" name="nivel_salarial" id="nivel_salarial" value="{{ $tramiteKardex->nivel_salarial }}" placeholder="Ingresa nivel salarial" required campoNoVacio="true" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="pagaduria" class="titulo-dato"><span class="requeridos">* </span> <b> Pagaduría registrada ante el ISSSTE </b> </label>
                        <input type="text" class="form-control normalizar-texto"  name="pagaduria" id="pagaduria" placeholder="Ingresa pagaduría" required campoNoVacio="true" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="sueldo_cotizable" class="titulo-dato"><span class="requeridos">* </span> <b> Sueldo cotizable </b> </label>
                        <input type="text" class="form-control" name="sueldo_cotizable" id="sueldo_cotizable" placeholder="$" required number="true" campoNoVacio="true" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="quinquenios" class="titulo-dato"><span class="requeridos">* </span> <b> Quinquenios </b> </label>
                        <input type="text" class="form-control" name="quinquenios" id="quinquenios" placeholder="$" required number="true" campoNoVacio="true" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="otras_percepciones" class="titulo-dato"><span class="requeridos">* </span> <b> Otras percepciones </b> </label>
                        <input type="text" class="form-control" name="otras_percepciones" id="otras_percepciones" placeholder="$" required number="true" campoNoVacio="true" />
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-12 text-center mt-5">
                        <button type="button" class="btn btn-success" id="btn_agregar_detalle"> <i class="fas fa-plus"></i> Agregar detalle </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    {{-- Fin Form Detalles --}}

    {{-- Inicio Form Final --}}
    <form method="POST" id="id_form_generacion_documento_kardex" action="{{ route('tramites.kardex.generacion.documento.hojas.servicio', [$tramiteKardex, $instanciaTarea]) }}">
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Observaciones</h3>
                </div>
            </div>
            <div class="card-body" >
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control normalizar-texto" name="observaciones" id="observaciones" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_generacion_documento_kardex" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                </div>
            </div>
        </div>

    </form>
    {{-- Fin Form Final --}}

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p32_tramites_kardex/tareas/T03_generacionDocumentoTramiteKardexHojasServicio.js?ver=1.0') }}"></script>
    <script>
        const tramiteKardex = @json($tramiteKardex);
        const seguimientos = @json($seguimientos);
        const urlGuardarSeguimientos = @json(route('tramites.kardex.guardar.seguimientos'));
        const urlEliminarSeguimientos = @json(route('tramites.kardex.eliminar.seguimientos'));
        const detalles = @json($detalles);
        const urlGuardarDetalles = @json(route('tramites.kardex.guardar.detalles'));
        const urlEliminarDetalles = @json(route('tramites.kardex.eliminar.detalles'));
    </script>
@endpush
