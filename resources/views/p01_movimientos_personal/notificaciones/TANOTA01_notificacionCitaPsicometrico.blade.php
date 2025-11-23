@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

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
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
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
    <form action="" method="post">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["tipo_movimiento", "fecha_Solicitud"],
                        "plaza" => [],
                        "candidato" => []
                    ]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la cita</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Fecha de cita: </label>
                        <span class="valor-dato">  {{  convertirFechaFormatoMX($movimientoPersonal->calificacionPsicometrico->fecha) }} </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Hora de cita: </label>
                        <span class="valor-dato">  {{  $movimientoPersonal->calificacionPsicometrico->hora }} </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Lugar de cita: </label>
                        <span class="valor-dato">  {{  $movimientoPersonal->calificacionPsicometrico->lugar }} </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Presentarse con: </label>
                        <span class="valor-dato"> 
                            {{ $usuarioEvaluador->nombre }} {{ $usuarioEvaluador->apellido_paterno }} {{ $usuarioEvaluador->apellido_materno }} <br>
                            {{ $usuarioEvaluador->puesto }} <br>
                            {{ $usuarioEvaluador->area->unidadAdministrativa->nombre_unidad }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Enterado, eliminar notificación</button>
                </div>
            </div>
        </div>
    </form>
@endsection