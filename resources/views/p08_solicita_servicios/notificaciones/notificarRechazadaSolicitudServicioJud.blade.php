@extends('layouts.main')

@section('title', 'Cancelación Solicitud de Servicio')

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
                'titulo' => 'Cancelación Solicitud de Servicio'
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

    <form method="post" id="form_notificacion" action="{{ route('solicitud.servicio.notificacion.rechazada.jud', [$solicitaServicio, $instanciaTarea]) }}" >
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Notificación - Cancelación Solicitud de Servicio</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Solicitud de Servicio de <b> {{ $solicitaServicio->servicioGeneral->nombre_servicio_general }} </b> no fue autorizada <br>
                        <p class="mt-3">Motivo: <b> {{ $solicitaServicio->comentarios_rechazo ? $solicitaServicio->comentarios_rechazo : 'No especificado' }} </b> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la solicitud de servicio solicitada</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <label class="titulo-dato"> Área que solicitó el servicio: </label>
                        <span class="valor-dato"> <b> {{ $solicitaServicio->area->identificador }} - {{ $solicitaServicio->area->nombre }} </b> </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Folio: </label>
                        <span class="valor-dato"> <b> {{ $solicitaServicio->instancia->folio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Subárea: </label>
                        <span class="valor-dato text-uppercase"> <b> {{ $solicitaServicio->sub_area }} </b> </span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-5">
                        <label class="titulo-dato"> Nombre del contacto: </label>
                        <span class="valor-dato"> <b> {{ $solicitaServicio->contacto_servicio }} </b> </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Teléfono: </label>
                        <span class="valor-dato"> <b> {{ $solicitaServicio->telefono_servicio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Dirección: </label>
                        <span class="valor-dato"> <b> {{ $solicitaServicio->direccion_servicio }} </b> </span>
                    </div>
                </div>
                @if ( $solicitaServicio->cantidad_solicitud )
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <label class="titulo-dato"> Detalle de la Solicitud: </label>
                            <span class="valor-dato"> <b> {!! $solicitaServicio->texto_solicitud !!} </b> </span>
                        </div>
                        <div class="col-md-4">
                            <label class="titulo-dato"> Cantidad: </label>
                            <span class="valor-dato"> <b> <b> {!! $solicitaServicio->cantidad_solicitud !!} </b> </b> </span>
                        </div>
                    </div>
                @else
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="titulo-dato"> Detalle de la Solicitud: </label>
                            <span class="valor-dato"> <b> {!! $solicitaServicio->texto_solicitud !!} </b> </span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar_notificacion" class="btn btn-success"><i class="fas fa-check-square"></i> Enterado, eliminar notificación </button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/p08_solicita_servicios/notificaciones/notificacionesSolicitudServicioGeneral.js?ver=1.0') }}"></script>
@endpush
