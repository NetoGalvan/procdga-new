@extends('layouts.main')

@section('title', 'ASIGNAR DATOS DE ENTREVISTA')

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
                'titulo' => 'ASIGNAR DATOS DE ENTREVISTA'
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
            "datos_candidato" => ["horas", "observaciones"],
            "datos_escolares"
        ] 
    ])
    <form method="POST" id="formDatosEntrevista">
        @method('post')
        @csrf
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la cita</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Fecha de cita</strong></label>
                        <input type="text" class="form-control cursor-pointer date-picker fecha-cita" name="fecha_cita" placeholder="SELECCIONE FECHA PARA CITA" readonly>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">* </span>Hora</strong></label>
                            <input type="text" class="form-control cursor-pointer time-picker" name="hora_cita" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <p><label class="titulo-dato" for="">Lugar</label>{{ $servicioSocial->area->nombre }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btnDatosEntrevista" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                    <button id="finalizar" name="finalizar" class="btn btn-danger" type="button"><i class="fas fa-times"></i>Cancelar proceso</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script type="text/javascript">
        URL_asignarEntrevista = "{{route('servicio.social.asignar.datos.entrevista', [$servicioSocial, $instanciaTarea] )}}";
        URL_finalizarProceso = "{{route('servicio.social.finalizar.proceso', [$servicioSocial, $instanciaTarea])}}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/js_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T02_asignarDatosEntrevista.js') }}"></script>
@endpush
