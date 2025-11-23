@extends('layouts.main')

@section('title', 'Editar horario')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Horarios',
                'ruta' => Route('asistencia.catalogo.horarios')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Editar horario'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Editar horario</h3>
            </div>
        </div>
        <div class="card-body">
            @include("p15_asistencia.catalogos.horarios.partials.form")
        </div>
    </div>
    <form action="{{ route("asistencia.catalogo.horarios.update", $horario) }}" method="POST" id="form_guardar_horario">
        @csrf
        <div class="card card-custom mt-10">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Estatus</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <label class="titulo-dato"">Estatus</label>
                    <span class="switch switch-outline switch-icon switch-success">
                        <label>
                            <input type="checkbox" name="activo" autocomplete="off" @if ($horario->activo || old("activo")) checked @endif>
                            <span></span>
                        </label>
                    </span>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route("asistencia.catalogo.horarios") }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/p15_asistencia/catalogos/horarios/partials/form.js?v=1.3') }}"></script>
@endpush
