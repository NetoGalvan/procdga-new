@extends('layouts.main')

@section('title', 'Crear usuario')

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
				'titulo' => 'Crear usuario',
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
    <form id="form_user" method="POST" action="{{ route("usuarios.store") }}" data-type="agregar">
        @csrf
        <input type="hidden" id="tipo_registro" name="tipo_registro" value="{{ old("tipo_registro") ?? 'EXISTENTE' }}">
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
                @if ($errors->any())
                <div class="alert alert-custom alert-light-danger fade show mb-8" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        @foreach ($errors->all() as $error)
                            • {{ $error }} <br>
                        @endforeach
                    </div>
                </div>
                @endif
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link @if(is_null(old("tipo_registro")) || old("tipo_registro") == "EXISTENTE") active @endif" data-toggle="tab" href="#registro_existente">
                        <span class="nav-icon"><i class="fas fa-user-tie"></i></span>
                        <span class="nav-text">Existente</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(old("tipo_registro") == "MANUAL") active @endif" data-toggle="tab" href="#registro_manual">
                        <span class="nav-icon"><i class="fas fa-user"></i></span>
                        <span class="nav-text">Manual</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade pt-8 @if(is_null(old("tipo_registro")) || old("tipo_registro") == "EXISTENTE") show active @endif" id="registro_existente" role="tabpanel" aria-labelledby="registro_existente">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @include("componentes.busqueda_empleado")
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="titulo-dato"><strong><span class="text-danger">* </span>Correo electrónico:</strong></label>
                                <input type="text" class="form-control" name="email_creden" id="email_creden" autocomplete="off" email="true" required/>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade pt-8 @if(old("tipo_registro") == "MANUAL") show active @endif" id="registro_manual" role="tabpanel" aria-labelledby="registro_manual">
                        @include('administrador.usuarios.partials.form')
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom mb-8">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
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
                        <i class="fas fa-user-tag"></i>
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
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
@endpush
