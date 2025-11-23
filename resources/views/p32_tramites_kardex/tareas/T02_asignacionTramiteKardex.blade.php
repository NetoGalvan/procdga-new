@extends('layouts.main')

@section('title', 'Asignación trámite kardex')

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
                'titulo' => 'Asignación trámite kardex'
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

    <form method="POST" id="form_asigancion_tramite_kardex" action="{{ route('tramites.kardex.asigancion.tramites', [$tramiteKardex, $instanciaTarea]) }}">
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Asignación de trámite kardex</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Debes definir y asignar al usuario que llevar a cabo la captura de datos del trámite kardex en curso
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
                            <span class="nav-text">Documentos verificados</span>
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
                            <div class="col-md-4">
                                <label class="titulo-dato"> Capturado por: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->apellido_materno) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Solicitado por: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->solicitante) }} </b> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Asignación de usuario</h3>
                </div>
            </div>
            <div class="card-body" >
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-text">
                        Selecciona al usuario que se encargara de este trámite
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="tecnico_operativo_kardex" class="titulo-dato"><strong><span class="requeridos">* </span>Técnico operativo kardex</strong></label>
                        <select name="tecnico_operativo_kardex" id="tecnico_operativo_kardex" class="form-control" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($tecnicosOperativosKardex as $tecnicoOperativoKardex)
                                <option value="{{ $tecnicoOperativoKardex->id }}">{{ $tecnicoOperativoKardex->nombre }} {{ $tecnicoOperativoKardex->apellido_paterno }} {{ $tecnicoOperativoKardex->apellido_materno }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_asigancion_tramite_kardex" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('styles')

@endpush

@push('scripts')
    <script src="{{ asset('js/p32_tramites_kardex/tareas/T02_asignacionTramiteKardex.js?ver=1.0') }}"></script>
@endpush
