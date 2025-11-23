@extends('layouts.main')

@section('title', 'CAPTURA RESULTADO DE ENTREVISTA')

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
                'titulo' => 'CAPTURA RESULTADO DE ENTREVISTA'
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
    <form action="{{ route('servicio.social.captura.resultado.entrevista', [$servicioSocial, $instanciaTarea]) }}" method="POST" id="formDatosAceptacion">
        @method('post')
        @csrf
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Aceptación del candidato</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                    <strong>
                                    NOTA: El candidato se encuentra en espera de que sea "ACEPTADO o RECHAZADO", por lo que no podrá ser seleccionado por otros enlaces administrativos.
                                    </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Estatus</strong></label>
                        <select class="form-control selectpicker" name="EstatusCandidato" id="EstatusCandidato" value="{{old('EstatusCandidato')}}" required>
                            <option value=" " selected disabled>Seleccione una opción</option>
                            <option value="ACEPTADO">ACEPTADO</option>
                            <option value="RECHAZADO">RECHAZADO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btnDatosEntrevista" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/p06_servicio_social/js_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T03_aceptacionCandidato.js') }}"></script>
@endpush
