@extends('layouts.main')

@section('title', 'INCIDENCIAS - DESCRIPCIÓN')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Procesos',
                'ruta' => Route('procesos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'INCIDENCIAS - DESCRIPCIÓN'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@section('contenido')
    <form id="form_iniciar_proceso" action="{{ route('tramite.incidencia.iniciar.proceso') }}" method="POST">
        @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Incidencias</h3>
                </div>
            </div>
            <div class="card-body">
                <p class="text-justify">
                    Con este proceso usted puede iniciar una incidencia con fundamento en los derechos que le otorgan las siguientes leyes:
                </p>
                <ul>
                    <li>Condiciones Generales de Trabajo</li>
                    <li>Ley Federal del Trabajo</li>
                    <li>Ley del ISSSTE</li>
                    <li>Normativa DGADP</li>
                </ul>
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"><span class="text-danger">* </span> <b> Tipo trámite: </b> </label>
                        <select class="form-control" name="tipo_tramite" autocomplete="off" required>
                            {{-- <option value=""> Seleccione una opción </option> --}}
                            @foreach ($tiposTramites as $tipoTramite)
                                <option value="{{ $tipoTramite }}" @if (count($tiposTramites) == 1) selected @endif> {{ str_replace("_", " ", $tipoTramite) }}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success text-center"><i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/descripcion.js?v=1.1') }}"> </script>
@endpush
