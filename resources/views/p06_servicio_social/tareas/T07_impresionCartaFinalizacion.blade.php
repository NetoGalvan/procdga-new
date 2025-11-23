@extends('layouts.main')

@section('title', 'IMPRESIÓN DE CARTA DE FIN')

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
                'titulo' => 'IMPRESIÓN DE CARTA DE FIN'
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
    @include('p06_servicio_social.partials.detalles_proceso', [ 
        "secciones" => [
            "general", 
            "datos_candidato" => ["observaciones"],
            "datos_escolares",
            "prestacion_servicio"
        ] 
    ])

    <form method="POST" id="responsable_funcionario_fin">
        <div class="card card-custom mt-5 mb-5" id="responsableEscuela">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Responsable de la escuela</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <p><b>NOTA: Asegúrese de que el nombre del funcionario en la escuela a quien va dirigida la carta de terminación sea el correcto.
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><p></p>
                        <h6><strong>Funcionario de la carta de inicio</strong></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 ">
                        <p><label class="titulo-dato">Nombre</label>{{ $servicioSocial->prestador->nombre_funcionario }}</p>
                    </div>
                    <div class="col-md-4 ">
                        <p><label class="titulo-dato">Puesto</label>{{ $servicioSocial->prestador->puesto_funcionario }}</p>
                    </div>
                    <div class="col-md-4 ">
                        <p><label class="titulo-dato">Télefono</label>{{ $servicioSocial->prestador->telefono_funcionario }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h6><strong>Funcionario de la carta de terminación</strong></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre Funcionario</label></strong></b>
                            <input type="text" class="form-control normalizar-texto solo-texto" name="nombre_funcionario" id="nombre_funcionario"
                            value="{{ $servicioSocial->prestador->nombre_funcionario }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">* </span>Puesto Funcionario</strong></label>
                            <input type="text" class="form-control normalizar-texto solo-texto" name="puesto_funcionario" id="puesto_funcionario"
                            value="{{ $servicioSocial->prestador->puesto_funcionario }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">* </span>Teléfono Funcionario</strong></label>
                            <input type="text" class="form-control inputmk-10" name="telefono_funcionario" id="telefono_funcionario" placeholder="10 Digitos" maxlength="10"
                            value="{{ $servicioSocial->prestador->telefono_funcionario }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato"></label>
                            <button type="button" class="btn btn-primary mt-7" id="guardar_funcionario_fin"><i class="fas fa-save"></i>Actualizar funcionario</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <form method="POST" id="carta_fin_T07">
    @method('post')
    @csrf
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Carta de terminación</h3>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <strong>
                                <p class="mb-2 ml-6">Instrucciones:</p>
                                <ul class="mb-0">
                                    <li>
                                        En caso de requerir agregar observaciones hacerlo antes de generar la carta de terminación.
                                    </li>
                                    <li>
                                        Imprimir y llevar a firma con el Director de recursos humanos la carta de terminación de servicio social.
                                    </li>
                                </ul>
                            </strong>
                        </div>
                    </div>
                    <h6><strong>OBSERVACIONES PARTICULARES</strong></h6>
                    <div class="row d-flex">
                        <div class="col-9">
                            <label class="titulo-dato">Escriba las observaciones para la carta de terminación.</label>
                            <textarea class="form-control normalizar-texto" name="observaciones_carta_fin" id="observaciones_carta_fin" rows="4" placeholder="Ingrese las observaciones">{{$servicioSocial->observaciones_carta_fin ?? ''}}</textarea>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-center">
                            <button type="button" id="observacionesCartaFin" class="btn btn-primary"><i class="fas fa-plus"></i>Agregar observaciones</button>
                        </div>
                    </div>
                </div>
                <div>
                    <hr class="mb-10 mt-10">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-custom alert-success" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">
                                    <strong>
                                        Nota: Si cuenta con la carta firmada puede continuar con el proceso para que el sistema dé aviso a los interesados y el prestador acuda a la SOM por su carta.
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="border border-3 rounded col-md-3 p-8">
                            <h6><strong>DESCARGAR</strong></h6>
                            
                            <a class="btn btn-danger ml-4 mt-4 carta_termino"
                                data-container="body" 
                                data-toggle="popover" 
                                data-html="true" 
                                data-placement="top" 
                                data-content="<strong>Carta de terminación de servicio social o práctica profesional</strong>" 
                            > 
                                <i class="far fa-file-pdf"></i> Carta de terminación
                            </a>
                        </div>
                        <div class="col-auto d-flex">
                            <div class="row form-group h-100 d-flex align-items-center">
                                <div class="col-md-3 align-middle">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" class="carta_firmada" name="carta_firmada" 
                                            {{( !is_null($servicioSocial->fecha_firma_drh_fin) ? 'checked' : '' )}} />
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                                <label class="col-md-auto text-verificacion">Carta de terminación firmada</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btnFinalizarCartaTerminacion" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_postCartaFin = "{{ route('servicio.social.impresion.carta.fin.1', [$servicioSocial, $instanciaTarea]) }}";
        var URL_cartaFinPDF = "{{ route('servicio.social.imprimir.carta.finalizacion', $servicioSocial) }}";

        var nombreArchivoCartaTermino = `Carta-Finalizacion-{{$servicioSocial->instancia->folio}}.pdf`;
    </script>
    <script src="{{ asset('js/p06_servicio_social/js_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T07_impresionCartaFinalizacion.js') }}"></script>
@endpush
