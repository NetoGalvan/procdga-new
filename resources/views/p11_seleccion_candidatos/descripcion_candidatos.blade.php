@extends('layouts.main')

@section('title', 'Solicitud de Servicio - Descripción')

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
                'titulo' => 'Selección de Candidatos de Personal de Estructura - Descripción'
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

<div class="card card-custom mb-5">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Selección de candidatos de personal de estructura</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-custom alert-outline-info" role="alert">
            <div class="alert-text">
                Este proceso permite:
                <ul>
                    <li>Proponer hasta 2 candidatos a ocupar una plaza de estructura.</li>
                    <li>Registrar la evaluación psicométrica de los candidatos.</li>
                    <li>Seleccionar al candidato a ocupar la plaza.</li>
                    <li>Generar el folio de aceptación para iniciar el proceso de
                        Movimientos de Personal.</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="{{ route('seleccion.candidatos.guardar.seleccion') }}"
            id="formCandidatosDescripcion" method="POST">
            <div class="text-center">
                <button type="button" class="btn btn-success btn-sl float-center"
                    id="btnAceptarDescripcion">Aceptar</button>
                <a href="{{ route('procesos') }}" class="btn btn-danger btn-sl">Cancelar</a>
            </div>
            {{ csrf_field()}}
        </form>
    </div>
</div>

@endsection @push('scripts')
<script
	src="{{ asset('js/p11_seleccion_candidatos/descripcion_seleccion.js') }}"></script>
@endpush
