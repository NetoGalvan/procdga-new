@extends('layouts.main')

@section('title', 'Listado final de ganadores')

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
                'titulo' => 'Listado final de ganadores'
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

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Listado final de ganadores</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área creadora </label>
                    <span class="valor-dato">  {{ $premioAdministracion->areacreadora->identificador }} - {{ $premioAdministracion->areacreadora->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $premioAdministracion->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Para la área </label>
                    <span class="valor-dato">  {{ $premioAdministracion->area->identificador }} - {{ $premioAdministracion->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Convocatoria correspondiente a: </label>
                    <span class="valor-dato">  {{ $premioAdministracion->anio_convocatoria }} </span>
                </div>

                <div class="col-md-4">
                    <label class="titulo-dato"> Periodo de evaluación </label>
                    <span class="valor-dato">  {{ $premioAdministracion->fecha_inicio_evaluacion_pa }} <b> a </b> {{ $premioAdministracion->fecha_fin_evaluacion_pa }} </span>
                </div>

                <div class="col-md-4">
                    <label class="titulo-dato"> Comentarios del convocante </label>
                    <span class="valor-dato">  {{ $premioAdministracion->comentarios_admin_pa_21 }} </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <i style="font-size: 2.5rem" data-toggle="kt-tooltip" data-placement="top" title="Listado de candidatos"><a type="button" id="listado_candidatos" role="link" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a></i>&nbsp;
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('premio.administracion.notificacion.inicio.proceso', [$premioAdministracion, $instanciaTarea] ) }}" method="post" id="form_eliminar_notificacion2">
                    @method('post') @csrf
                    <button id="btn_eliminar_notificacion2" type="button" class="btn btn-success btn-md"> <i class="fas fa-trash"></i> Eliminar notificación</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/notificaciones/notificaciones.js') }}"></script>
    <script>
        var premio_id = @json($premioAdministracion->p21_premio_id);
        var urlDescargarListadoCandidatos = "{{ route('descargar.pdf.listado.candidatos.finales') }}";
    </script>
@endpush
