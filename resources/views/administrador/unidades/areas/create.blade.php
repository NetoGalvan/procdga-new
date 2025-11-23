@extends('layouts.main')

@section('title', 'Crear área')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-chalkboard-teacher",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Areas',
				'ruta' => route('unidades.areas.index', $unidad),
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Crear',
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
    <form id="form_guardar" method="POST" action="{{ route("unidades.areas.store", $unidad) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include('administrador.unidades.areas.partials.form')
            </div>
            <div class="card-footer">
                <a type="button" href="{{ route("unidades.areas.index", $unidad) }}" class="btn btn-light-danger mr-2">
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
    <script>
        const unidad = @json( $unidad );
    </script>
    <script src="{{ asset('js/administrador/unidades/areas/partials/form.js?ver=1.0') }}"></script>
@endpush
