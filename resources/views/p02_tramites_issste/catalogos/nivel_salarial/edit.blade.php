@extends('layouts.main')

@section('title', 'Niveles Salariales - Editar')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Niveles Salariales",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => true,
                "titulo" => 'Editar'
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
                <h3 class="card-label">
                    Editar nivel salarial
                </h3>
            </div>
        </div>
        <form method="POST" action="{{ route('niveles-salariales.update', $nivelSalarial) }}" id="form_guardar_nivel_salarial">
            @csrf
            @method("PUT")
            <div class="card-body">
                @include('p02_tramites_issste.catalogos.nivel_salarial.partials.form')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-secondary mr-4 btn-submit" data-type="agregar">
                    <i class="fas fa-plus"></i>
                    Guardar
                </button>
                <a href="{{ route("niveles-salariales.index") }}" class="btn btn-danger"">
                    Regresar
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p02_tramites_issste/catalogos/nivel_salarial/partials/form.js') }}"></script>
@endpush