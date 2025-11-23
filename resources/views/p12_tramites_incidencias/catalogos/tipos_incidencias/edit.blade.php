@extends('layouts.main')

@section('title', 'CATÁLOGOS - TIPOS DE INCIDENCAS - EDITAR')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tipos de incidencias',
                'ruta' => Route('tramite.incidencia.catalogo.tipos.incidencias')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Editar'
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
    <form action="{{ route("tramite.incidencia.catalogo.tipos.incidencias.update", $tipoIncidencia) }}" method="POST" id="form_guardar">
        @csrf
        @method("PUT")
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Editar tipo de incidencia</h3>
                </div>
            </div>
            <div class="card-body">
                @include("p12_tramites_incidencias.catalogos.tipos_incidencias.partials.form")
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/p12_tramites_incidencias/catalogos/tipos_incidencias/partials/form.js') }}"></script>
@endpush