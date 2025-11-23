@extends('layouts.main')

@section('title',  "Agregar biométrico")

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Biométricos',
                'ruta' => Route('asistencia.catalogo.biometricos')
            ],
            2 => [
                'activo' => true,
                'titulo' => "Agregar biométrico"
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
    <form action="{{ route("asistencia.catalogo.biometricos.store") }}" method="POST" id="form_guardar">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Agregar biométrico</h3>
                </div>
            </div>
            <div class="card-body">
                @include("p15_asistencia.catalogos.biometricos.partials.form")
            </div>
            <div class="card-footer">
                <a href="{{ route("asistencia.catalogo.biometricos") }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Guardar
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/p15_asistencia/catalogos/biometricos/partials/form.js?v=1.3') }}"></script>
@endpush
