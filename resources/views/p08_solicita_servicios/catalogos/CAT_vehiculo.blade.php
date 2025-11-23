@extends('layouts.main')

@section('title', 'Catálogo Vehículos')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Cátalogos',
                'ruta' => Route('catalogos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Catálogo Vehículos'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@section('contenido')

    <form method="GET" id="form_catalogo_vehiculos" action="{{ route( 'catalogos' ) }}">
        @method('get')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Cátalogo de vehículos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Este catálogo permite administrar los vehículos que estan asignados al JUD de Transporte
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">

            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Vehículos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-12 form-group">
                        {{-- Lanza botón modal --}}
                        @foreach ( $nombreRol as $rol )

                            @if ( $rol->name == 'JUD_TRANSPORTE' || $rol->name == 'SUPER_ADMIN' || $rol->name == 'ADMIN' )
                                <div class="p-2 bd-highlight ">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoVehiculo"> <i class="fas fa-plus"></i> Agregar vehículo</button>
                                </div>
                            @endif

                        @endforeach
                        {{-- Fin botón modal --}}
                        <table id="tabla_vehiculos"
                            data-unique-id="p08_vehiculo_id"
                            data-total-field="total"
                            data-data-field="data"
                            data-pagination="true"
                            data-query-params="queryParams"
                            data-search="true"
                            data-search-align="right"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-cache="false">
                            <thead>
                                <tr>
                                    <th data-field="placa" class="text-center text-uppercase" data-formatter="datosVehiculoPlacaFormatter"><label class="titulo-dato"><b>Placa</b></label></th>
                                    <th data-field="marca" class="text-center text-uppercase" data-formatter="datosVehiculoMarcaFormatter"><label class="titulo-dato"><b>Marca</b></label></th>
                                    <th data-field="modelo" class="text-center text-uppercase" data-formatter="datosVehiculoModeloFormatter"><label class="titulo-dato"><b>Modelo</b></label></th>
                                    <th data-field="numero_motor" class="text-center text-uppercase" data-formatter="datosVehiculoMotorFormatter"><label class="titulo-dato"><b>Motor</b></label></th>
                                    <th data-field="acciones" class="text-center text-uppercase" data-formatter="accionesFormatter" data-align="center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-undo"></i> Regresar </button>
                </div>
            </div>

        </div>

    </form>


    <!-- Inicio Modal -->
    <div class="modal fade" id="modalNuevoVehiculo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tituloVehiculoNuevo">Agregar o editar vehículo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form-modal-edit">

                    <form method="POST" id="form_modal_catalogo_vehiculo" action="{{ route( 'solicitud.servicio.administrar.catalogo.vehiculos') }}">
                        @method('post')
                        @csrf


                        <div class=" px-4 py-2 ">

                            <h4 class="titulo-formulario">Datos del vehículo</h4>
                            <hr>
                            <input type="hidden" id="p08_vehiculo_id" name="p08_vehiculo_id" value="" >

                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="tipo_vehiculo" class="titulo-dato"><span class="requeridos">* </span> <b> Tipo de vehículo: </b> </label>
                                    <select class="form-control text-uppercase" name="tipo_vehiculo" id="tipo_vehiculo" >
                                            <option value=""> Seleccione una opción </option>
                                            <option class="tipoVehiculo" value="A" > A </option>
                                            <option class="tipoVehiculo" value="B" > B </option>
                                            <option class="tipoVehiculo" value="C" > C </option>
                                    </select>
                                    @error('tipo_vehiculo')
                                        <label id="tipo_vehiculo-error" class="error" for="tipo_vehiculo">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="placa" class="titulo-dato"><span class="requeridos">* </span> <b> Placa: </b> </label>
                                    <input type="text" id="placa" name="placa"
                                        class="form-control normalizar-texto @error('placa') error @enderror"
                                        placeholder=""
                                        value="" >
                                    @error('placa')
                                        <label id="placa-error" class="error" for="placa">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="marca" class="titulo-dato"><span class="requeridos">* </span> <b> Marca: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="marca" id="marca"
                                        placeholder="" value="">
                                    @error('marca')
                                        <label id="marca-error" class="error" for="marca">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="submarca" class="titulo-dato"><span class="requeridos">* </span> <b> Submarca: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="submarca" id="submarca"
                                        placeholder="" value="">
                                    @error('submarca')
                                        <label id="submarca-error" class="error" for="submarca">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="modelo" class="titulo-dato"><span class="requeridos">* </span> <b> Modelo: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="modelo" id="modelo"
                                        placeholder="" value="" maxlength="4"
                                    @error('modelo')
                                        <label id="modelo-error" class="error" for="modelo">{{ $message }}</label>
                                    @enderror
                                </div>

                                </div>

                            </div>


                            <h4 class="titulo-formulario mt-3">Datos del motor</h4>
                            <hr>
                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="numero_motor" class="titulo-dato"><span class="requeridos">* </span> <b> No. de motor: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="numero_motor" id="numero_motor"
                                        placeholder="" value="">
                                    @error('numero_motor')
                                        <label id="numero_motor-error" class="error" for="numero_motor">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="numero_serie" class="titulo-dato"><span class="requeridos">* </span> <b> No. de serie: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="numero_serie" id="numero_serie"
                                        placeholder="" value="">
                                    @error('numero_serie')
                                        <label id="numero_serie-error" class="error" for="numero_serie">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="numero_economico" class="titulo-dato"><span class="requeridos"> </span> <b> No. Económico: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="numero_economico" id="numero_economico"
                                        placeholder="" value="">
                                    @error('numero_economico')
                                        <label id="numero_economico-error" class="error" for="numero_economico">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="color" class="titulo-dato"><span class="requeridos">* </span> <b> Color: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="color" id="color"
                                        placeholder="" value="">
                                    @error('color')
                                        <label id="color-error" class="error" for="color">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="cilindros" class="titulo-dato"><span class="requeridos">* </span> <b> Cilindros: </b> </label>
                                    <select class="form-control text-uppercase" name="cilindros" id="cilindros" >
                                            <option value=""> Seleccione una opción </option>
                                            <option class="cilindros" value="2" > 2 </option>
                                            <option class="cilindros" value="3" > 3 </option>
                                            <option class="cilindros" value="4" > 4 </option>
                                            <option class="cilindros" value="5" > 5 </option>
                                            <option class="cilindros" value="6" > 6 </option>
                                            <option class="cilindros" value="8" > 8 </option>
                                            <option class="cilindros" value="10" > 10 </option>
                                            <option class="cilindros" value="12" > 12 </option>
                                            <option class="cilindros" value="14" > 14 </option>
                                            <option class="cilindros" value="16" > 16 </option>
                                    </select>
                                    @error('cilindros')
                                        <label id="cilindros-error" class="error" for="cilindros">{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>

                            {{-- SE COMENTA LA ASIGANCIÓN POR EL MOMENTO --}}
                            {{-- <h4 class="titulo-formulario mt-3">Datos de asignación </h4>
                            <hr>
                            <div class="row interruptor">

                                <div class="col-md-12 mt-3 form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="interruptorAsignacion" name="interruptorAsignacion" >
                                        <label class="custom-control-label" id="interruptorLabel" for="interruptorAsignacion"></label>
                                    </div>
                                </div>

                                <div class="row px-3 py-1 camposAsignacion">
                                    <div class="col-md-4 form-group">
                                        <label for="area_id" class="titulo-dato"><span class="requeridos">* </span> <b> Área de adscripción: </b> </label>
                                        <select class="form-control text-uppercase" name="area_id" id="area_id" >
                                                <option value=""> Seleccione una opción </option>
                                            @if ( !$areas )
                                                <label id="area_id-error" class="error" for="area_id">No hay registros</label>
                                            @else
                                                @foreach ( $areas as $area )
                                                    <option class="text-uppercase" value="{{ $area->area_id }}" > {{ $area->identificador }} - {{ $area->nombre }} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('area_id')
                                            <label id="area_id-error" class="error" for="area_id">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="numero_tarjeta_combustible" class="titulo-dato"><span class="requeridos">* </span> <b> No. tarjeta de combustible: </b> </label>
                                        <input type="text" class="form-control normalizar-texto" name="numero_tarjeta_combustible" id="numero_tarjeta_combustible"
                                            placeholder="" value="">
                                        @error('numero_tarjeta_combustible')
                                            <label id="numero_tarjeta_combustible-error" class="error" for="numero_tarjeta_combustible">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="nombre_conductor" class="titulo-dato"><span class="requeridos">* </span> <b> Nombre del conductor: </b> </label>
                                        <input type="text" class="form-control normalizar-texto" name="nombre_conductor" id="nombre_conductor"
                                            placeholder="" value="">
                                        @error('nombre_conductor')
                                            <label id="nombre_conductor-error" class="error" for="nombre_conductor">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                            </div> --}}


                            <h4 class="titulo-formulario mt-3">Documentación disponible</h4>
                            <hr>
                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="copia_factura" class="titulo-dato"><span class="requeridos">* </span> <b> No. Factura: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="copia_factura" id="copia_factura"
                                        placeholder="" value="">
                                    @error('copia_factura')
                                        <label id="copia_factura-error" class="error" for="copia_factura">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="copia_tarjeta_circulacion" class="titulo-dato"><span class="requeridos">* </span> <b> No. tarjeta circulación: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="copia_tarjeta_circulacion" id="copia_tarjeta_circulacion"
                                        placeholder="" value="">
                                    @error('copia_tarjeta_circulacion')
                                        <label id="copia_tarjeta_circulacion-error" class="error" for="copia_tarjeta_circulacion">{{ $message }}</label>
                                    @enderror
                                </div>


                            </div>

                        </div>

                        <div class="mensajeErrorVehiculo my-3"></div>

                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" id="btn_modal_cancelar_vehiculo" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_modal_guarda_vehiculo" name="btn_modal_guarda_vehiculo" class="btn btn-success">Guardar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Fin Modal -->

@endsection

@push('styles')
<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <link id="estilos" rel="stylesheet" type="text/css" href="{{ asset('css/p08_solicitud_servicios/catalogos/CAT_vehiculo.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/catalogos/CAT_vehiculo.js?ver=1.0') }}"></script>
    <script>
        const vehiculos = @Json($vehiculos);
        var urlEliminar = @json( route('solicitud.servicio.eliminar.vehiculo') );
        var urlEditar = @json( route('solicitud.servicio.editar.vehiculo') );
        var urlBitacora = @json( route('solicitud.servicio.administrar.catalogo.vehiculo.bitacora.ruta.gas') );
    </script>
@endpush
