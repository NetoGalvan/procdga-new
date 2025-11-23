@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

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
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
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
    <form action="{{ route('movimiento.personal.altas.cita.psicometrico', [$movimientoPersonal, $instanciaTarea]) }}" method="POST" id="id_form_cita_psicometrico">
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
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Agende una cita para examinar al siguiente candidato <br>
                        Favor de confirmar con el enlace las características del puesto
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de cita:</strong></label>
                        <input type="text" class="form-control input-date-current" name="fecha_cita" autocomplete="off" readonly required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Hora:</strong></label>
                        <input type="time" class="form-control" name="hora_cita" autocomplete="off" required>
                        <small class="text-muted"> Formato de 24 Horas </small> 
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Lugar: </label>
                        @php
                            use App\Models\p01_movimientos_personal\LugarCitaPsicometrico;
                            $dependenciaId = $movimientoPersonal->area->unidadAdministrativa->dependencia->dependencia_id;
                            $lugarCita = LugarCitaPsicometrico::where("dependencia_id", $dependenciaId)->first();   
                        @endphp
                        <span class="font-size-h6"> {{ $lugarCita->nombre }} </span>
                        <input type="hidden" name="lugar_cita" value="{{ $lugarCita->nombre }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')	
	<script src="{{ asset('js/p01_movimientos_personal/tareas/TA03_citaPsicometrico.js?v=1.0')}}"></script>
@endpush