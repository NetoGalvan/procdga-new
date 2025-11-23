@extends('layouts.main')

@section('title', 'Editar área')

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
    <form id="form_guardar" method="POST" action="{{ route("unidades.areas.update", [$unidad, $area]) }}" data-type="editar">
        @csrf
        @method("PUT")
        <div class="card card-custom">
            <div class="card-body">
                @include('administrador.unidades.areas.partials.formEdit')
            </div>
            <div class="card-footer">
                <a type="button" href="{{ route("unidades.areas.index", $area->unidadAdministrativa) }}" class="btn btn-light-danger mr-2">
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
        const area = @json( $area );
    </script>
    <script src="{{ asset('js/administrador/unidades/areas/partials/formEditar.js?ver=1.0') }}"></script>
@endpush
