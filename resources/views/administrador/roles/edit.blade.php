@extends('layouts.main')

@section('title', 'Editar rol')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-user",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Roles',
                'ruta' => route('roles.index')
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Editar roles',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.roles",
        ]
    ])
@endsection

@section('contenido')
    <form method="POST" id="form_guardar" action="{{ route("roles.update", $role) }}">
        @method("put")
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name">Nombre del rol</label>
                        <input type="text" class="form-control" value="{{$role->name}}" disabled />
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descripcion">Descripción</label>
                        <textarea type="text" class="form-control" disabled>{{ $role->descripcion }}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descripcion">Label</label>
                        <input type="text" name="label" class="form-control normalizar-texto" value="{{ $role->label }}" required />
                    </div>
                </div>
            </div>     
            <div class="card-footer">
                <a type="button" href="{{ route("roles.index") }}" class="btn btn-light-danger mr-2">
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
    <script src="{{ asset('js/administrador/roles/edit.js') }}"></script>
@endpush