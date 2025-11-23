@extends('layouts.main')

@section('title', 'IMPRESIÓN DE CARTA DE INICIO')

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
                'titulo' => 'IMPRESIÓN DE CARTA DE INICIO'
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

    <form method="POST" id="cartaInicio_T05">
    @method('post')
    @csrf

        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Carta de aceptación</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <strong>
                                    <p class="mb-2 ml-6">Instrucciones:</p>
                                    <ul class="mb-0">
                                        <li>
                                            Revise que los datos del prestador sean correctos antes de generar la carta de aceptación.
                                        </li>
                                        <li>
                                            En caso de requerir agregar observaciones hacerlo antes de generar la carta de aceptación.
                                        </li>
                                        <li>
                                            Imprimir y llevar a firma con el Director de recursos humanos la carta de aceptación de servicio social.
                                        </li>
                                    </ul>
                                    @if($instanciaTarea->estatus == 'EN_CORRECCION')
                                        <br>
                                        <p>Nota: Los datos han sido corregidos satisfactoriamente</p>
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto d-flex">
                        <div class="row form-group h-100 d-flex align-items-center">
                            <div class="col-md-3 align-middle">
                                <span class="switch switch-success verificacion-datos">
                                    <label>
                                        <input type="checkbox" class="interruptorCorrectosIncorrectos" name="interruptorCorrectosIncorrectos" checked="checked" />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                            <label class="col-md-auto text-verificacion">Sí, los datos son correctos</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-10 correcto-incorrecto">
                    <h6><strong>OBSERVACIONES PARTICULARES</strong></h6>
                    <div class="row d-flex">
                        <div class="col-9">
                            <label class="titulo-dato">Escriba las observaciones particulares para esta carta de aceptación.</label>
                            <textarea class="form-control normalizar-texto" name="observaciones_carta_inicio" id="observaciones_carta_inicio" rows="4" placeholder="Ingrese las observaciones particulares">{{$servicioSocial->observaciones_carta_inicio ?? ''}}</textarea>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-center">
                            <button type="button" id="agregarObservaciones" class="btn btn-primary"><i class="fas fa-plus"></i>Agregar observaciones</button>
                        </div>
                    </div>
                </div>
                <div class="nota">
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
                        <div class="border border-3 rounded col-md-6 p-8">
                            <h6><strong>DESCARGAR</strong></h6>
                            
                            <a class="btn btn-danger ml-4 mt-4 carta_aceptacion"
                                data-container="body" 
                                data-toggle="popover" 
                                data-html="true" 
                                data-placement="top" 
                                data-content="<strong>Carta de aceptación de servicio social o práctica profesional</strong>" 
                            > 
                                <i class="far fa-file-pdf"></i> Carta de aceptación
                            </a>
                            <a class="btn btn-danger ml-4 mt-4 ficha_prestador">
                                <i class="far fa-file-pdf"></i> Ficha del Prestador
                            </a>
                        </div>
                        <div class="col-auto d-flex">
                            <div class="row form-group h-100 d-flex align-items-center">
                                <div class="col-md-3 align-middle">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" class="carta_firmada" name="carta_firmada" 
                                            {{( !is_null($servicioSocial->fecha_firma_drh_inicio) ? 'checked' : '' )}} />
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                                <label class="col-md-auto text-verificacion">Carta de aceptación firmada</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-homework text-center">
                    <button type="button" id="btnFinalizarCartaInicio" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_cartaInicio = "{{ route('post.servicio.social.impresion.carta.inicio', [$servicioSocial, $instanciaTarea]) }}";
        var URL_correcciones = "{{ route('servicio.social.regresar.correcciones', [$servicioSocial, $instanciaTarea]) }}";
        var URL_fichaPrestadorPDF = "{{ route('servicio.social.imprimir.ficha.prestador', $servicioSocial) }}";
        var URL_cartaInicioPDF = "{{ route('servicio.social.imprimir.carta.aceptacion', $servicioSocial) }}";

        var nombreArchivoCartaAceptacion = `Carta-Aceptacion-{{$servicioSocial->instancia->folio}}.pdf`;
        var nombreArchivoFichaPrestador = `Formato-Prestador-{{$servicioSocial->instancia->folio}}.pdf`;

        //BEGIN::VALIDACIÓN
        var formCartaInicio_T05 = $('#cartaInicio_T05');
        var validator = formCartaInicio_T05.validate({
            onfocusout: false,
            rules: {
                observaciones_carta_inicio: 'campoNoVacio',
                correcciones: 'campoNoVacio'
            },
            messages: {
                observaciones_carta_inicio: "Campo obligatorio",
                correcciones: "Campo obligatorio"
            },
            errorPlacement: function(label, element) {
                element.addClass('error');
                label.insertAfter(element);
            }
        });
        //END::VALIDACIÓN
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T05_configuracionSwitch.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T05_impresionCartaInicio.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T05_regresoCorrecciones.js') }}"></script>
@endpush