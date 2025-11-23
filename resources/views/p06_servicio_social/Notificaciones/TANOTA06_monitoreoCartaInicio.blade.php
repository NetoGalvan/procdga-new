@extends('layouts.main')

@section('title', 'TIEMPO RESTANTE PARA CARTA DE INICIO')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Notificaciones disponibles',
				'ruta' => Route('notificaciones')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'TIEMPO RESTANTE PARA CARTA DE INICIO'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "notificaciones",
        ]
    ])
@endsection

@section('contenido')
    @include('p06_servicio_social.partials.detalles_proceso_notificaciones', [ 
        "secciones" => [
            "general", 
            "datos_candidato" => [],
            "datos_escolares" => ["genaral"],
            "prestacion_servicio" => ["horario"]
        ] 
    ])

    <form action="{{ route('servicio.social.notificacion.monitoreo.carta.inicio', [$servicioSocial, $instanciaTarea]) }}" method="post">
    @method('post')
    @csrf
                <div class="card card-custom mt-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Monitoreo para la generación de la carta de inicio</h3>

                        </div>
                    </div>
                    <div class="card-body">

                            @if ($servicioSocial->fecha_carta_inicio == null)

                                @if ($dentroDelTiempo)
                                    <div class="col-md-12">
                                        <div class="alert alert-custom alert-success" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning text-dark"></i></div>
                                            <div class="alert-text text-dark">
                                                <strong>
                                                Importante. <br>
                                                Recuerda que tienes hasta el <b> {{ $cadenaFecha }} </b> para generar la carta de inicio del prestador. <p></p>
                                                Tiempo restante:
                                                <div class="text-dark">
                                                    <span id="days"></span> Días / <span id="hours"></span> Horas / <span id="minutes"></span> Minutos / <span id="seconds"></span> Segundos
                                                </div>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div class="alert alert-custom alert-danger" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">
                                                Atención !! <p></p>
                                                La fecha limite para generar la carta de inicio para el prestador ha vencido, te pedimos la generes lo más pronto posible por favor. <br>

                                                Tenías hasta el <b> {{ $cadenaFecha }} </b> para generar la carta. <br>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @else

                                <div class="col-md-12">
                                    <div class="alert alert-custom alert-success" role="alert">
                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                        <div class="alert-text">
                                            <strong>
                                            La carta ha sido generada en tiempo y forma para el prestador, si lo deseas, ya puedes borrar esta notificación.
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                            @endif
                    </div>
                

    
{{--
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos generales</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"> Unidad administrativa </label>
                        <span class="valor-dato">  {{ $servicioSocial->area->identificador }} - {{ $servicioSocial->area->nombre }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Folio </label>
                        <span class="valor-dato">  {{ $servicioSocial->instancia->folio }} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del candidato</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="titulo-dato"> Nombre </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->primer_apellido }} {{ $servicioSocial->prestador->segundo_apellido }} {{ $servicioSocial->prestador->nombre_prestador }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Carrera </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->carrera }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Matrícula </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->matricula }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Horario </label>
                        <span class="valor-dato">  {{ $servicioSocial->horario }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Institución </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->escuela->institucion->nombre_institucion }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Escuela </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->escuela->nombre_escuela }} </span>
                    </div>
                </div>
            </div>
            @if ( $servicioSocial->fecha_carta_inicio != null )
                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-sl">Eliminar notificación <i class="fas fa-trash"></i></button>
                    </div>
                </div>
            @else

            @endif

        </div>
--}}
            @if ( $servicioSocial->fecha_carta_inicio != null )
                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-sl">Eliminar notificación <i class="fas fa-trash"></i></button>
                    </div>
                </div>
            @endif
        </div>
    </form>
@endsection


@push('scripts')
    <script src="{{ asset('js/p06_servicio_social/notificaciones/TANOTA06.js') }}"></script>

    <script>
        var fechaInicio = @json($fecha_para_contador);
    </script>
@endpush
