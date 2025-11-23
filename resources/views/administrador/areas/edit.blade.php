@extends('layouts.main')

@section('title', 'Editar area')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-chalkboard-teacher",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Áreas',
				'ruta' => route('areas.index'),
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Editar área',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.areas",
        ]
    ])
@endsection

@section('contenido')
    <form id="form_guardar" method="POST" action="{{ route("areas.update", $area) }}" data-type="editar">
        @csrf
        @method("PUT")
        <div class="card card-custom">
            <div class="card-body">
                @include('administrador.areas.partials.form')
            </div>
            <div class="card-footer text-center">
                <a type="button" href="{{ route("areas.index") }}" class="btn btn-light-danger mr-2">
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
    <script src="{{ asset('js/administrador/areas/partials/form.js') }}"></script>
@endpush