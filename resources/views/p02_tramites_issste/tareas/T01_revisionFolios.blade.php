@extends('layouts.main')

@section('title', "TRÁMITES ISSSTE - {$instanciaTarea->tarea->nombre}")

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
                'titulo' => "TRÁMITES ISSSTE - {$instanciaTarea->tarea->nombre}"
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
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Movimientos de personal acumulados</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-outline-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    Revise y en su caso, corrija los datos que corresponden a cada uno de los folios que serán enviados al ISSSTE. </br>
                    Identifique en cada folio, qué tipo de movimiento corresponde para el ISSSTE: ALTAS, BAJAS, MODIFICACIONES.
                </div>
            </div>
            <div class="alert alert-custom alert-outline-danger" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    IMPORTANTE: Complete esta tarea sólo cuando esté seguro de todos los folios.
                </div>
            </div>
        </div>
    </div>
    <form method="POST" id="form_finalizar_tarea" action="{{ route('tramites.issste.revision.folios', [$tramiteIssste, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom mt-8">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="titulo-dato"> Folio del trámite: </label>
                        <span class="valor-dato"> <b> {{ $tramiteIssste->folio }} </b> </span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Quincena</strong></label>
                        <select class="form-control" name="qna_issste" autocomplete="off" required>
                            <option value="">Seleccione una quincena</option>
                            @php 
                                use Carbon\Carbon;
                            @endphp
                            @foreach (traerQuincenasActual(Carbon::now(), Carbon::now()) as $quincena)   
                            @if ($tramiteIssste->quincena == $quincena) 
                                <option value="{{ $quincena }}" selected>{{ $quincena }}</option>
                            @else
                                <option value="{{ $quincena }}">{{ $quincena }}</option>
                            @endif
                            @endforeach
                        </select>
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
                <div class="row contenedor-direccion">
                    <input type="hidden" name="movimientos[{{$detalle->detalle_id}}][detalle_id]" value="{{$detalle->detalle_id}}">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo de movimiento</strong></label>
                        <select
                            class="form-control"
                            name="movimientos[{{$detalle->detalle_id}}][tipo_movimiento_issste_id]"
                            autocomplete="off"
                            required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($tiposMovimientosIssste as $tipoMovimientoIssste)
                                @if ( $detalle->tipo_movimiento_issste_id )
                                    <option value="{{ $tipoMovimientoIssste->tipo_movimiento_issste_id }}"
                                        @if ( $tipoMovimientoIssste->tipo_movimiento_issste_id == $detalle->tipo_movimiento_issste_id ) selected @endif >
                                        {{$tipoMovimientoIssste->nombre}}
                                    </option>
                                @else
                                    <option value="{{ $tipoMovimientoIssste->tipo_movimiento_issste_id }}"
                                        @if ($tipoMovimientoIssste->identificador == $detalle->tipoMovimiento->tipo) selected @endif>
                                        {{ $tipoMovimientoIssste->nombre }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
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
                        <span class="valor-dato">  {!! $detalle->curp ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> RFC </label>
                        <span class="valor-dato">  {{ $detalle->rfc }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Nivel Salarial </label>
                        <span class="valor-dato">  {{ $detalle->nivel_salarial }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Calle</strong></label>
                        <input type="text" 
                            class="form-control normalizar-texto" 
                            name="movimientos[{{$detalle->detalle_id}}][calle]"
                            value="{{ $detalle->calle }}"
                            autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Número exterior</label>
                        <input type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][numero_exterior]" 
                            value="{{ $detalle->numero_exterior }}"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Número interior</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][numero_interior]" 
                            value="{{ $detalle->numero_interior }}"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Código Postal</strong></label>
                        <input type="text" 
                            class="form-control cp" 
                            name="movimientos[{{$detalle->detalle_id}}][cp]" 
                            maxlength="5" 
                            value="{{ $detalle->cp }}" 
                            data-url="{{ route('catalogo.codigo.postal.v2') }}" 
                            autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Entidad</strong></label>
                        <select
                            class="form-control entidad-federativa select2"
                            name="movimientos[{{$detalle->detalle_id}}][entidad_federativa_domicilio_id]"
                            autocomplete="off"
                            required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($entidades as $entidad)
                                <option
                                    class="normalizar-texto"
                                    value="{{ $entidad->entidad_federativa_id }}"
                                    @if (isset($detalle->entidadFederativaDomicilio) && $detalle->entidadFederativaDomicilio->entidad_federativa_id == $entidad->entidad_federativa_id) selected @endif>
                                    {{ $entidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Ciudad</strong></label>
                        <input 
                            type="text" 
                            class="form-control ciudad normalizar-texto" 
                            name="movimientos[{{$detalle->detalle_id}}][ciudad]" 
                            value="{{ $detalle->ciudad }}"
                            autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Alcaldía o Municipio</strong></label>
                        <input 
                            type="text" 
                            class="form-control municipio-alcaldia normalizar-texto" 
                            name="movimientos[{{$detalle->detalle_id}}][municipio_alcaldia]" 
                            value="{{ $detalle->municipio_alcaldia }}"
                            autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Colonia</strong></label>
                        <div id="id_contenedor_colonia">
                            <select 
                                class="form-control select2 colonia" 
                                name="movimientos[{{$detalle->detalle_id}}][colonia]" 
                                autocomplete="off" 
                                required>
                                <option value=""> Seleccione una colonia </option>
                                @if ($detalle->colonia)
                                    <option value="{{ $detalle->colonia }}" selected> {{ $detalle->colonia }} </option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="separator separator-solid my-6"></div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-dark font-weight-bold">Datos salariales</h5>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Pagaduría</label>
                        <span class="valor-dato">  {{ $detalle->pagaduria }} </span>
                        {{-- <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][pagaduria]" value="{{ $detalle->pagaduria }}"
                            autocomplete="off"> --}}
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Clave de cobro</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][clave_cobro]" 
                            value="{{ $detalle->clave_cobro }}"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Clave de ramo</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][clave_ramo]" 
                            value="{{ $detalle->clave_ramo }}"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo nombramiento</strong></label>
                        <select
                            class="form-control"
                            name="movimientos[{{$detalle->detalle_id}}][tipo_nombramiento_id]"
                            autocomplete="off"
                            required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($tiposNombramientos as $tipoNombramiento)
                                <option
                                    value="{{ $tipoNombramiento->tipo_nombramiento_id }}"
                                    @if (isset($detalle->tipoNombramiento) && $tipoNombramiento->tipo_nombramiento_id == $detalle->tipoNombramiento->tipo_nombramiento_id)) selected @endif>
                                    {{ $tipoNombramiento->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Sueldo cotizable</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][sueldo_cotizable]" 
                            value="{{$detalle->sueldo_cotizable}}"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Sueldo SAR</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][sueldo_sar]" 
                            value="{{$detalle->sueldo_sar}}"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Sueldo total</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="movimientos[{{$detalle->detalle_id}}][sueldo_total]" 
                            value="{{$detalle->sueldo_total}}"
                            autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="card card-custom mt-8">
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-primary mr-2" id="btn_guardar_avances"><i class="fas fa-save"></i> Guardar avances</button>
                    <button type="submit" class="btn btn-success" id="btn_finalizar_tarea_p02_t01"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        var urlGuardarAvanceRevisionDeFolios = @json(route('tramites.issste.guardar.avance.en.revision.folios', $tramiteIssste));
    </script>
    <script src="{{ asset('js/componentes/codigo_postalv2.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p02_tramites_issste/tareas/T01_revisionFolios.js') }}?v=1.0"></script>
@endpush
