@extends('layouts.main')

@section('title', 'Editar usuario')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-user",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Usuarios',
				'ruta' => route('usuarios.index'),
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Editar usuario',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.usuarios",
        ]
    ])
@endsection


@section('contenido')
    <form id="form_user" method="POST" action="{{ route("usuarios.update", $usuario) }}" data-type="editar">
        @csrf
        @method("PUT")
        <div class="card card-custom mb-8">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <h3 class="card-label">
                        Datos generales
                    </h3>
                </div>
            </div>
            <div class="card-body">
                @include('administrador.usuarios.partials.form')
            </div>
        </div>
        <div class="card card-custom mb-8">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-house-user"></i>
                    </span>
                    <h3 class="card-label">
                        Área
                    </h3>
                </div>
            </div>
            <div class="card-body">
                @include('administrador.usuarios.partials.area')
            </div>
        </div>
        <div class="card card-custom mb-8">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </span>
                    <h3 class="card-label">
                        Roles
                    </h3>
                </div>
            </div>
            <div class="card-body">
                @include('administrador.usuarios.partials.roles')
            </div>
        </div>
        <div class="card card-custom mb-8">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-user-lock"></i>
                    </span>
                    <h3 class="card-label">
                        Estatus del usuario
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <input id="estatus_empleado" name="activo" type="checkbox" 
                            data-switch="true"    
                            data-on-text="Activo" 
                            data-off-text="Inactivo" 
                            data-on-color="success" 
                            data-off-color="danger" 
                            @if ($usuario->activo) checked @endif 
                            autocomplete="off" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom">
            <div class="card-footer">
                <a type="button" href="{{ route("usuarios.index") }}" class="btn btn-light-danger mr-2">
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
    <script src="{{ asset('js/administrador/usuarios/partials/form.js') }}"></script>
    <script src="{{ asset('js/administrador/usuarios/edit.js') }}"></script>
@endpush