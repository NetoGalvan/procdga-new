@extends('layouts.main')

@section('title', 'Administración | Editar empleado')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-user",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Empleados',
				'ruta' => route('alfabetico.index'),
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Editar empleado',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.alfabetico",
        ]
    ])
@endsection


@section('contenido')
    <form id="form_editar_empleado" method="POST" action="{{ route("alfabetico.editar.empleado", $empleado) }}" data-type="editar">
        @csrf
        @method("POST")
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-user-tie"></i>
                    </span>
                    <h3 class="card-label">
                        Datos generales
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="titulo-dato"> Nombre: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($empleado->apellido_paterno) }} {{  mb_strtoupper($empleado->apellido_materno) }} {{ mb_strtoupper($empleado->nombre) }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> No. Empleado: </label>
                        <span class="valor-dato"> <b> {{ $empleado->numero_empleado }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Unidad Administrativa: </label>
                        <span class="valor-dato"> <b> {{ $empleado->unidad_administrativa }} - {{ mb_strtoupper($empleado->unidad_administrativa_nombre) }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> RFC: </label>
                        <span class="valor-dato"> <b> {{ $empleado->rfc }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> CURP: </label>
                        <span class="valor-dato"> <b> {{ $empleado->curp }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Fecha nacimiento: </label>
                        <span class="valor-dato"> <b> {{ $empleado->fecha_nacimiento }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Género: </label>
                        @if ( $empleado->sexo === 'M' )
                        <span class="valor-dato"> <b> MASCULINO </b> </span>
                        @else
                        <span class="valor-dato"> <b> FEMENINO </b> </span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Fecha alta de empleado: </label>
                        <span class="valor-dato"> <b> {{ $empleado->fecha_alta_empleado }} </b> </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-house-user"></i>
                    </span>
                    <h3 class="card-label">
                        Plaza
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <label class="titulo-dato"> No. Plaza: </label>
                        <span class="valor-dato"> <b> {{ $empleado->numero_plaza }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Puesto: </label>
                        <span class="valor-dato"> <b> {{ $empleado->puesto }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Código de puesto: </label>
                        <span class="valor-dato"> <b> {{ $empleado->codigo_puesto }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Nivel Salarial: </label>
                        <span class="valor-dato"> <b> {{ $empleado->nivel_salarial }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Codigo universo: </label>
                        <span class="valor-dato"> <b> {{ $empleado->codigo_universo }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Seccción sindical: </label>
                        <span class="valor-dato"> <b> {{ $empleado->seccion_sindical }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Código situación empleado: </label>
                        <span class="valor-dato"> <b> {{ $empleado->codigo_situacion_empleado }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Código turno: </label>
                        <span class="valor-dato"> <b> {{ $empleado->codigo_turno }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Zona pagadora: </label>
                        <span class="valor-dato"> <b> {{ $empleado->zona_pagadora }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> SSN: </label>
                        <span class="valor-dato"> <b> {{ $empleado->ssn }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Días trabajados: </label>
                        <span class="valor-dato"> <b> {{ $empleado->dias_trabajados }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Código regimen issste: </label>
                        <span class="valor-dato"> <b> {{ $empleado->codigo_regimen_issste }} </b> </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom mb-5">
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
                @include('administrador.empleados.partials.area')
            </div>
        </div>
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fas fa-user-edit"></i>
                    </span>
                    <h3 class="card-label">
                        Estatus
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="activo" class="titulo-dato">Estatus</label>
                        <input data-switch="true" id="activo" name="activo" type="checkbox" data-on-text="Activar" data-off-text="Desactivar" data-on-color="success" data-off-color="danger" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom">
            <div class="card-footer text-center">
                <a type="button" href="{{ route("alfabetico.index") }}" class="btn btn-light-danger mr-2">
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
    <script src="{{ asset('js/administrador/empleados/editarEmpleado.js?ver=1.0') }}"></script>
    <script>
        const empleado = @json($empleado);
    </script>
@endpush
