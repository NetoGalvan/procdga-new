@extends('layouts.main')

@section('title', 'Trámites ISSSTE - T02 Respuesta del ISSSTE')

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
                'titulo' => 'Trámites ISSSTE - T02 Respuesta del ISSSTE'
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
    <form method="POST" id="form_finalizar_tarea" action="{{ route('tramites.issste.respuesta.issste', [$tramiteIssste, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Finalización de los movimientos de personal ante el ISSSTE</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Para cada uno de los folios que se encuentran en proceso, registre la respuesta del ISSSTE
                        <ul class="text-left">
                            <li>Aceptado</li>
                            <li>Rechazado, Registre el motivo de rechazo</li>
                        </ul>
                    </div>
                </div>
                <div class="alert alert-custom alert-outline-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        IMPORTANTE: Complete esta tarea sólo cuando esté seguro de todos los folios
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"> Folio del trámite: </label>
                        <span class="valor-dato"> <b> {{ $tramiteIssste->folio }} </b> </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"> Quincena: </label>
                        <span class="valor-dato"> <b> {{ $tramiteIssste->quincena }} </b> </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Estatus de los movimientos</label>
                        <select class="form-control" id="estatus_movimientos" autocomplete="off">
                            <option value="ACEPTADO">ACEPTADO</option>
                            <option value="RECHAZADO">RECHAZADO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" id="btn_aplicar_estatus" class="btn btn-success">Aplicar a todos los folios</button>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($detallesIssste as $detalle)
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Folio del movimiento: {{$detalle->folio_p01}}</h3>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="movimientos[{{$detalle->detalle_id}}][detalle_id]" value="{{$detalle->detalle_id}}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="titulo-dato">  Tipo de movimiento </label>
                        <span class="valor-dato"> {{ $detalle->tipoMovimientoIssste->nombre }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">  Nombre del empleado </label>
                        <span class="valor-dato">  {{ $detalle->nombre_empleado }} {{ $detalle->apellido_paterno }} {{ $detalle->apellido_materno }}</span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Número de empleado </label>
                        <span class="valor-dato">  {{ $detalle->numero_empleado }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> CURP </label>
                        <span class="valor-dato">  {{ $detalle->curp }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> RFC </label>
                        <span class="valor-dato">  {{ $detalle->rfc }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Nivel Salarial </label>
                        <span class="valor-dato"> {{ $detalle->nivel_salarial }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Calle </label>
                        <span class="valor-dato">  {{ $detalle->calle }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Número exterior </label>
                        <span class="valor-dato">  {{ $detalle->numero_exterior }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Número interior </label>
                        <span class="valor-dato">  {{ $detalle->numero_interior }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Código Postal </label>
                        <span class="valor-dato">  {{ $detalle->cp }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Entidad </label>
                        <span class="valor-dato">  {{ $detalle->entidadFederativaDomicilio->nombre }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Ciudad </label>
                        <span class="valor-dato">  {{ $detalle->ciudad }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Alcaldía o Municipio </label>
                        <span class="valor-dato">  {{ $detalle->municipio_alcaldia }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Colonia </label>
                        <span class="valor-dato">  {{ $detalle->colonia }} </span>
                    </div>
                </div>
                <div class="separator separator-solid my-6"></div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-dark font-weight-bold">Datos salariales</h5>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Pagaduría</label>
                        <span class="valor-dato">  {{ $detalle->pagaduria }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Clave de cobro</label>
                        <span class="valor-dato">  {{ $detalle->clave_cobro }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Clave de ramo</label>
                        <span class="valor-dato">  {{ $detalle->clave_ramo }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Tipo nombramiento</label>
                        <span class="valor-dato">  {{ $detalle->tipoNombramiento->nombre }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Sueldo cotizable</label>
                        <span class="valor-dato">  {{ $detalle->sueldo_cotizable }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Sueldo SAR</label>
                        <span class="valor-dato"> {{ $detalle->sueldo_sar }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Sueldo total</label>
                        <span class="valor-dato"> {{ $detalle->sueldo_total }} </span>
                    </div>
                </div>
                <div class="separator separator-solid my-6"></div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Respuesta ISSSTE</strong></label>
                        <select class="form-control estatusMovimiento" 
                            name="movimientos[{{$detalle->detalle_id}}][estatus_issste]" 
                            autocomplete="off"
                            required>
                            <option value="">Seleccionar una opción</option>
                            <option value="ACEPTADO" @if ( $detalle->estatus_issste == 'COMPLETADO' ) selected @endif> ACEPTADO </option>
                            <option value="RECHAZADO" @if ( $detalle->estatus_issste == 'RECHAZADO' ) selected @endif> RECHAZADO </option>
                        </select>
                    </div>
                    <div class="col-12 form-group contenedor_motivo_rechazo" style="display: none">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Motivo de Rechazo</strong></label>
                        <textarea class="form-control normalizar-texto" 
                            name="movimientos[{{$detalle->detalle_id}}][motivo_rechazo]" 
                            autocomplete="off"
                            required>{{$detalle->motivo_rechazo}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="card card-custom mt-8">
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/p02_tramites_issste/tareas/T02_respuestaIssste.js') }}?v=1.0"></script>
@endpush
