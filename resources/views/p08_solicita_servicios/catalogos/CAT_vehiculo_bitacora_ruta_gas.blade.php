@extends('layouts.main')

@section('title', 'Catálogo Bitácora Rutas Gas')

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
                'titulo' => 'Catálogo Bitácora Rutas Gas'
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

    {{-- Inicia Form --}}
    <form method="GET" id="form_catalogo_vehiculo_bitacora_ruta_gas" action="{{ route('solicitud.servicio.administrar.catalogo.vehiculos') }}">
        @method('get')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Catálogo bitácora de rutas y gas del vehículo</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Registra los datos generados por el uso del vehículo
                    </div>
                </div>
            </div>
        </div>

        {{-- Inicia datos del vehículo --}}
        <div class="row">
            <div class="col-md-4 mb-5">
                <div class="card card-custom mb-5">

                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Datos del área asignada</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            @if ( $vehiculo->area_id )
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Unidad: </label>
                                <span class="valor-dato text-uppercase"> {{ $vehiculo->nombre }} </span>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Asignado al área: </label>
                                <span class="valor-dato text-uppercase"> {{ $vehiculo->identificador }} - {{ $vehiculo->nombre }} </span>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Conductor: </label>
                                <span class="valor-dato">  {{ $vehiculo->nombre_conductor }} </span>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> No. Tarjeta combustible: </label>
                                <span class="valor-dato">  {{ $vehiculo->numero_tarjeta_combustible }} </span>
                            </div>

                            @else
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <label class="titulo-dato text-center"> Asignado al área: </label>
                                <span class="valor-dato badge badge-danger"> SIN ASIGNAR </span>
                            </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 mb-5">
                <div class="card card-custom mb-5">

                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Datos del vehículo</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Placa: </label>
                                <span class="valor-dato"> <b> {{ $vehiculo->placa }} </b> </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Marca: </label>
                                <span class="valor-dato">  {{ $vehiculo->marca }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Submarca: </label>
                                <span class="valor-dato">  {{ $vehiculo->submarca }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Modelo: </label>
                                <span class="valor-dato">  {{ $vehiculo->modelo }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Color: </label>
                                <span class="valor-dato">  {{ $vehiculo->color }} </span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 mb-5">
                <div class="card card-custom mb-5">

                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Datos del motor</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Tipo: </label>
                                <span class="valor-dato">  {{ $vehiculo->tipo_vehiculo }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> No. serie: </label>
                                <span class="valor-dato">  {{ $vehiculo->numero_serie }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> No. motor: </label>
                                <span class="valor-dato">  {{ $vehiculo->numero_motor }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> No. económico: </label>
                                <span class="valor-dato">  {{ $vehiculo->numero_economico }} </span>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label class="titulo-dato"> Cilindros: </label>
                                <span class="valor-dato">  {{ $vehiculo->cilindros }} </span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- Finializa datos del vehículo --}}

        {{-- Inicia tabla --}}
        <div class="card card-custom mb-5">

            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Bitácora de las rutas hechas por del vehículo</h3>
                </div>
            </div>
            <div class="card-body">
                {{-- Lanza botón modal --}}
                <div class="d-flex flex-row-reverse bd-highlight py-3">
                    <div class="p-2 bd-highlight">
                            <button type="button" id="btn-modal-nueva-bitacora" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevaBitacora"> <i class="fas fa-plus"></i> Agregar registro</button>
                    </div>
                </div>
                {{-- Fin botón modal --}}

                <div class="mensajeBitacora col-md-12"></div>

                <div id="contenedorTablaBitacora" class="mt-3">
                    <div class="table-responsive">
                            <table class="table table-bordered table-striped" >
                                <thead>
                                    <th width="10%"><label for="" class="titulo-dato">Fecha de la ruta</label></th>
                                    <th width="20%"><label for="" class="titulo-dato">Unidad administrativa</label></th>
                                    <th width="20%"><label for="" class="titulo-dato">Datos generales</label></th>
                                    <th width="20%"><label for="" class="titulo-dato">Datos Kilometraje</label></th>
                                    <th width="10%"><label for="" class="titulo-dato">Observaciones</label></th>
                                    <th width="10%"><label for="" class="titulo-dato">Datos Combustible</label></th>
                                    <th width="10%"><label for="" class="titulo-dato">Datos Lubricante</label></th>
                                </thead>
                                <tbody>
                                    @if ($bitacoras->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center"> No se encontró ningún vehículo. </td>
                                        </tr>
                                    @endif
                                    @foreach ($bitacoras as $bitacora)
                                        <tr>

                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto">Fecha ruta: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->fecha_ruta) ? $bitacora->fecha_ruta : '' }} </span> </p>
                                            </td>
                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Área: </label><span class="valor-dato-tabla-td  text-uppercase"> {{ ($bitacora->nombre) ? $bitacora->nombre : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Identificador área: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->identificador) ? $bitacora->identificador : '' }}</span> </p>
                                            </td>
                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Elaboró: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->nombre_elabora) ? $bitacora->nombre_elabora : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Revisó: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->nombre_revisa) ? $bitacora->nombre_revisa : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Año: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->anio_bitacora) ? $bitacora->anio_bitacora : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Mes: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->mes_bitacora) ? $bitacora->mes_bitacora : '' }}</span> </p>
                                            </td>
                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Kilometraje inicial: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->kilometros_inicial) ? $bitacora->kilometros_inicial : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Kilometraje final: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->kilometros_final) ? $bitacora->kilometros_final : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Kilometraje total: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->kilometros_total) ? $bitacora->kilometros_total : '' }}</span> </p>
                                            </td>
                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Observaciones: </label><span class="valor-dato-tabla-td"> {!! ($bitacora->observaciones_ruta) ? $bitacora->observaciones_ruta : '' !!}</span> </p>
                                            </td>
                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Ticket: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->ticket) ? $bitacora->ticket : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Fecha de carga: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->fecha_carga) ? $bitacora->fecha_carga : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Litros: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->litros_combustible) ? $bitacora->litros_combustible : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Importe: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->importe_combustible) ? $bitacora->importe_combustible : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Tipo: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->tipo_combustible) ? $bitacora->tipo_combustible : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Rendimiento: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->rendimiento) ? $bitacora->rendimiento : '' }}</span> </p>
                                            </td>
                                            <td>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Litros: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->litros_lubricante) ? $bitacora->litros_lubricante : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Importe: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->importe_lubricante) ? $bitacora->importe_lubricante : '' }}</span> </p>
                                                <p> <label for="" class="titulo-td normalizar-texto"> Partida: </label><span class="valor-dato-tabla-td"> {{ ($bitacora->partida) ? $bitacora->partida : '' }}</span> </p>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            {!! $bitacoras->render() !!}
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-undo"></i> Regresar </button>
                </div>
            </div>

        </div>
        {{-- Finaliza tabla --}}

    </form>
    {{-- Finaliza Form --}}


    <!-- Inicio Modal -->
    <div class="modal fade" id="modalNuevaBitacora" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloBitacoraVehiculoNuevo">Agregar bitácora de rutas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form-modal-edit">

                    <form method="POST" id="form_modal_bitacora_vehiculo" action="{{ route( 'solicitud.servicio.administrar.catalogo.vehiculo.bitacora.ruta.gas', ['vehiculo' => $vehiculo->p08_vehiculo_id] ) }}">
                        @method('post')
                        @csrf


                        <div class="px-4 py-2 ">

                            <h4 class="titulo-formulario">Datos generales</h4>
                            <hr>

                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="fecha_ruta" class="titulo-dato"><span class="requeridos">* </span> <b> Fecha en que se hizo la ruta: </b> </label>
                                    <input type="text" id="fecha_ruta" name="fecha_ruta"
                                        class="form-control date-general-bitacora @error('fecha_ruta') error @enderror"
                                        placeholder=""
                                        value="" >
                                    @error('fecha_ruta')
                                        <label id="fecha_ruta-error" class="error" for="fecha_ruta">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="nombre_elabora" class="titulo-dato"><span class="requeridos">* </span> <b> Nombre de quien elabora: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="nombre_elabora" id="nombre_elabora"
                                        placeholder="" value="">
                                    @error('nombre_elabora')
                                        <label id="nombre_elabora-error" class="error" for="nombre_elabora">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="nombre_revisa" class="titulo-dato"><span class="requeridos">* </span> <b> Nombre de quien revisa: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="nombre_revisa" id="nombre_revisa"
                                        placeholder="" value="">
                                    @error('nombre_revisa')
                                        <label id="nombre_revisa-error" class="error" for="nombre_revisa">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="observaciones_ruta" class="titulo-dato"><span class="requeridos">* </span> <b> Observaciones </b> </label>
                                    <textarea class="form-control" id="observaciones_ruta" name="observaciones_ruta" ></textarea>
                                    @error('observaciones_ruta')
                                    <label id="observaciones_ruta-error" class="error" for="observaciones_ruta">{{ $message }}</label>
                                    @enderror
                                    <small id="emailHelp" class="form-text text-muted">Describe detalles de la ruta realizada.</small>
                                </div>

                            </div>


                            <h4 class="titulo-formulario mt-3">Kilometraje</h4>
                            <hr>
                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="kilometros_inicial" class="titulo-dato"><span class="requeridos">* </span> <b> Kilometraje inicial: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="kilometros_inicial" id="kilometros_inicial"
                                        placeholder="" value="">
                                    @error('kilometros_inicial')
                                        <label id="kilometros_inicial-error" class="error" for="kilometros_inicial">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="kilometros_final" class="titulo-dato"><span class="requeridos">* </span> <b> Kilometraje final: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="kilometros_final" id="kilometros_final"
                                        placeholder="" value="">
                                    @error('kilometros_final')
                                        <label id="kilometros_final-error" class="error" for="kilometros_final">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="kilometros_total" class="titulo-dato"><span class="requeridos">* </span> <b> Kilometraje total: </b> </label>
                                    <input type="text" class="form-control normalizar-texto" name="kilometros_total" id="kilometros_total"
                                        placeholder="" value="">
                                    @error('kilometros_total')
                                        <label id="kilometros_total-error" class="error" for="kilometros_total">{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>


                            <h4 class="titulo-formulario mt-3">Combustible</h4>
                            <hr>
                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="ticket" class="titulo-dato">No. de ticket:</label>
                                    <input type="text" class="form-control normalizar-texto" name="ticket" id="ticket"
                                        placeholder="" value="">
                                    @error('ticket')
                                        <label id="ticket-error" class="error" for="ticket">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="fecha_carga" class="titulo-dato">Fecha de carga:</label>
                                    <input type="text" id="fecha_carga" name="fecha_carga"
                                        class="form-control date-general-bitacora @error('fecha_carga') error @enderror"
                                        placeholder=""
                                        value="" >
                                    @error('fecha_carga')
                                        <label id="fecha_carga-error" class="error" for="fecha_carga">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="litros_combustible" class="titulo-dato">Litros de combustible:</label>
                                    <input type="text" class="form-control normalizar-texto" name="litros_combustible" id="litros_combustible"
                                        placeholder="" value="">
                                    @error('litros_combustible')
                                        <label id="litros_combustible-error" class="error" for="litros_combustible">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="tipo_combustible" class="titulo-dato">Tipo de combustible:</label>
                                    <input type="text" class="form-control normalizar-texto" name="tipo_combustible" id="tipo_combustible"
                                        placeholder="" value="">
                                    @error('tipo_combustible')
                                        <label id="tipo_combustible-error" class="error" for="tipo_combustible">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="importe_combustible" class="titulo-dato">Importe del combustible:</label>
                                    <input type="text" class="form-control normalizar-texto" name="importe_combustible" id="importe_combustible"
                                        placeholder="" value="">
                                    @error('importe_combustible')
                                        <label id="importe_combustible-error" class="error" for="importe_combustible">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="rendimiento" class="titulo-dato">Rendimiento:</label>
                                    <input type="text" class="form-control normalizar-texto" name="rendimiento" id="rendimiento"
                                        placeholder="" value="">
                                    @error('rendimiento')
                                        <label id="rendimiento-error" class="error" for="rendimiento">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>


                            <h4 class="titulo-formulario mt-3">Lubricante</h4>
                            <hr>
                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="litros_lubricante" class="titulo-dato">Litros de lubricante:</label>
                                    <input type="text" class="form-control normalizar-texto" name="litros_lubricante" id="litros_lubricante"
                                        placeholder="" value="">
                                    @error('litros_lubricante')
                                        <label id="litros_lubricante-error" class="error" for="litros_lubricante">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="importe_lubricante" class="titulo-dato">Importe del lubricante:</label>
                                    <input type="text" class="form-control normalizar-texto" name="importe_lubricante" id="importe_lubricante"
                                        placeholder="" value="">
                                    @error('importe_lubricante')
                                        <label id="importe_lubricante-error" class="error" for="importe_lubricante">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="partida" class="titulo-dato">Partida:</label>
                                    <input type="text" class="form-control normalizar-texto" name="partida" id="partida"
                                        placeholder="" value="">
                                    @error('partida')
                                        <label id="partida-error" class="error" for="partida">{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer mt-4">
                    <button type="button" id="btn_modal_cancelar_bitacora_vehiculo" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_modal_guarda_bitacora_vehiculo" name="btn_modal_guarda_bitacora_vehiculo" class="btn btn-success">Guardar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Fin Modal -->

@endsection

@push('styles')
    <link id="estilos" rel="stylesheet" type="text/css" href="{{ asset('css/p08_solicitud_servicios/catalogos/CAT_bitacora_vehiculo.css') }}" />
@endpush


@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/catalogos/CAT_bitacora_vehiculo.js') }}"></script>
    <script>
        var usuario = @json($usuario);
        var ultimoKilomatraje = @json($ultimoKilomatraje);
    </script>
@endpush
