@extends('layouts.main')

@section('title', 'Captura Kardex - Descripción')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Procesos',
                'ruta' => Route('procesos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Historial Kardex - Descripción'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@section('contenido')
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Historial Kardex</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                En este proceso usted puede capturar el historial de incidencias de un empleado.
            </p>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form id="id_form_iniciar_proceso" action="{{ route('historial.kardex.t01') }}" method="POST">
                    @csrf
                    <button id="id_btn_iniciar_proceso" type="submit" class="btn btn-success btn-lg"><i class="fas fa-check-square"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>
@endsection
