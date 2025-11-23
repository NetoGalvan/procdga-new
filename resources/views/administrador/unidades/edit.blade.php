@extends('layouts.main')

@section('title', 'Editar unidad')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-chalkboard-teacher",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Unidades',
				'ruta' => route('unidades.index'),
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Editar',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.unidades",
        ]
    ])
@endsection

@section('contenido')
    <form id="form_guardar" method="POST" action="{{ route("unidades.update", $unidad) }}" data-type="editar">
        @csrf
        @method("PUT")
        <div class="card card-custom">
            <div class="card-body">
                @include('administrador.unidades.partials.form')
            </div>
            <div class="card-footer">
                <a type="button" href="{{ route("unidades.index") }}" class="btn btn-light-danger mr-2">
                    <i class="fas fa-window-close"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/unidades/partials/form.js?v=1.0') }}"></script>
@endpush
