@extends('layouts.main')

@section('title', 'CITA DEL CANDIDATO PARA EXAMEN PSICOMÉTRICO')

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
                'titulo' => 'CITA DEL CANDIDATO PARA EXAMEN PSICOMÉTRICO'
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
            "datos_candidato" => ["horas","observaciones"],
            "datos_escolares" => ["genaral"],
        ] 
    ])
{{--
    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Cita de entrevista para {{ strtolower($servicioSocial->prestador->tipo_prestador) }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Por favor, avise al interesado.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('servicio.social.notificacion.cita.examen.candidato', [$servicioSocial, $instanciaTarea]) }}" method="post">
        @method('post')
        @csrf
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
                        <label class="titulo-dato"> Horario tentativo </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->horario_tentativo }} </span>
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
        </div>
--}}
    <form action="{{ route('servicio.social.notificacion.cita.examen.candidato', [$servicioSocial, $instanciaTarea]) }}" method="post">
    @method('post')
    @csrf
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Cita para entrevista para servicio social</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="titulo-dato">Fecha de cita</label>
                        <span class="valor-dato">  {{  $servicioSocial->fecha_cita }} </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato">Hora de cita</label>
                        <span class="valor-dato">  {{  $servicioSocial->hora_cita }} </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato">Lugar de cita</label>
                        <span class="valor-dato">  {{  $servicioSocial->lugar_cita }} </span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-sl"><i class="fas fa-trash"></i>Enterado, eliminar notificación</button>
                </div>
            </div>
        </div>
    </form>
@endsection
