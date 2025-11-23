@extends('layouts.main')

@section('title', 'Selección trámite kardex')

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
                'titulo' => 'Selección trámite kardex'
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

        <form
            method="POST"
            id="form_selecciona_tipo_tramite_kardex"
            action="{{ route('tramites.kardex.solicitud.tramites', [$tramiteKardex, $instanciaTarea]) }}"
            enctype="multipart/form-data"
        >
            @method('post')
            @csrf

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Selección trámite kardex</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Debes describir el trámite que necesitas y llenar la información requerida
                        </div>
                    </div>
                    <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                </div>
            </div>

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Selección y llenado de información</h3>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label for="tipo_tramite_kardex_id" class="titulo-dato"><span class="requeridos">* </span> <b> Tipos de trámites </b></label>
                            <select class="form-control text-uppercase" name="tipo_tramite_kardex_id" id="tipo_tramite_kardex_id" required>
                                <option value="" > SELECCIONA UN TRÁMITE </option>
                                @foreach ( $tiposTramitesKardex as $tipoTramiteKardex )
                                    <option value="{{ $tipoTramiteKardex->tipo_tramite_kardex_id }}"  @if(old('tipo_tramite_kardex_id') == $tipoTramiteKardex->tipo_tramite_kardex_id) selected @endif > {{ $tipoTramiteKardex->nombre }} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    @include("componentes.busqueda_empleado", [
                                "existeEmpleado" => false,
                            ])
                    <div class="row contenedor-direccion">
                        <div class="col-md-4 form-group">
                            <label for="curp" class="titulo-dato"><span class="requeridos">* </span> <b> CURP </b> </label>
                            <input type="text" id="curp" name="curp" required CURP="true"
                                class="form-control normalizar-texto @error('curp') error @enderror"
                                placeholder="INGRESAR CURP"
                                value="{{ isset($tramiteKardex->curp) ? $tramiteKardex->curp : '' }}" >
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="cp" class="titulo-dato"><span class="requeridos">* </span> <b> Código Postal </b> </label>
                            <input type="text"  class="form-control cp" autocomplete="off" id="cp" name="cp"  maxlength="5" required
                                placeholder="INGRESAR CP"
                                data-url="{{ route('catalogo.codigo.postal.v2') }}"
                                value="{{ old('cp') }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="colonia" class="titulo-dato"><span class="requeridos">* </span> <b> Colonia </b> </label>
                            <div id="id_contenedor_colonia">
                                <select class="form-control select2 colonia" name="colonia" id="colonia" required>
                                    <option value=""> Seleccione una colonia </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="entidad_id" class="titulo-dato"><strong><span class="requeridos">* </span>Entidad</strong></label>
                            <select name="entidad_id" id="entidad_id" class="form-control entidad-federativa select2" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($entidades as $entidad)
                                    <option value="{{ $entidad->entidad_federativa_id }}" @if(old('entidad_id') == $entidad->entidad_federativa_id) selected @endif >{{ $entidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="ciudad" class="titulo-dato"><span class="requeridos">* </span> <b> Ciudad </b> </label>
                            <input type="text" class="form-control ciudad normalizar-texto" name="ciudad" id="ciudad" value="{{ old('ciudad') }}" placeholder="INGRESAR CIUDAD" required soloLetras="true">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="municipio_alcaldia" class="titulo-dato"><span class="requeridos">* </span> <b> Alcaldía o Municipio </b> </label>
                            <input type="text" class="form-control municipio-alcaldia normalizar-texto" name="municipio_alcaldia" id="municipio_alcaldia" value="{{ old('municipio_alcaldia') }}" placeholder="INGRESAR MUNICIPIO Ó ALCALDIA" required soloLetras="true">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="calle" class="titulo-dato"><span class="requeridos">* </span> <b> Calle </b> </label>
                            <input type="text" class="form-control normalizar-texto" name="calle" id="calle" value="{{ old('calle') }}" placeholder="INGRESAR CALLE" required campoNoVacio="true">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="numero_exterior" class="titulo-dato"><span class="requeridos">* </span> <b> Número exterior </b> </label>
                            <input type="text" class="form-control normalizar-texto" name="numero_exterior" id="numero_exterior" value="{{ old('numero_exterior') }}" placeholder="INGRESAR NÚMERO EXTERIOR" required campoNoVacio="true">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="numero_interior" class="titulo-dato">Número interior</label>
                            <input type="text" class="form-control normalizar-texto" name="numero_interior" id="numero_interior" value="{{ old('numero_interior') }}" placeholder="INGRESAR NÚMERO INTERIOR">
                        </div>
                    </div>
                </div>

            </div>

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Verificación de documentación</h3>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="row">
                        <div class="form-group col-md-4 text-center">
                            <label for="identificacion_oficial" class="titulo-dato">Identificación oficial</label>
                            <input data-switch="true" id="identificacion_oficial" name="identificacion_oficial" type="checkbox" data-on-text="SI" data-off-text="NO" data-on-color="success" data-off-color="danger" @if(old('identificacion_oficial')) checked @endif />
                        </div>
                        <div class="form-group col-md-4 text-center">
                            <label for="recibo_nomina" class="titulo-dato">Último recibo de nómina</label>
                            <input data-switch="true" id="recibo_nomina" name="recibo_nomina" type="checkbox" data-on-text="SI" data-off-text="NO" data-on-color="success" data-off-color="danger" @if(old('recibo_nomina')) checked @endif />
                        </div>
                        <div class="form-group col-md-4 text-center">
                            <label for="comprobante_domicilio" class="titulo-dato">Comprobante de domicilio actualizado</label>
                            <input data-switch="true" id="comprobante_domicilio" name="comprobante_domicilio" type="checkbox" data-on-text="SI" data-off-text="NO" data-on-color="success" data-off-color="danger" @if(old('comprobante_domicilio')) checked @endif />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" id="btn_finalizar_seleccion_servicio" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                    </div>
                </div>
            </div>
        </form>

@endsection

@push('styles')
@endpush

@push('scripts')
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/componentes/codigo_postalv2.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p32_tramites_kardex/tareas/T01_seleccionarSolicitudTramiteKardex.js?ver=1.0') }}"></script>
    <script>
        let oldColonia = "{{ old('colonia') }}";
        if (oldColonia) {
            const newOption = new Option("{{old('colonia')}}", "{{old('colonia')}}", false, false);
            $("#colonia").append(newOption).trigger('change');
            $("#colonia").val("{{old('colonia')}}").trigger('change');
        }
        let identificacionOficial = "{{old('identificacion_oficial')}}" ? true : false;
        let reciboNomina = "{{old('recibo_nomina')}}" ? true : false;
        let comprobanteDomicilio = "{{old('comprobante_domicilio')}}" ? true : false;
        let mensajeTramite = @json($errors->has('mensaje_tramite') ? $errors->first('mensaje_tramite') : false);
    </script>
@endpush
