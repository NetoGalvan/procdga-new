@extends('layouts.main')

@section('title', 'Búsqueda de Historial')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Búsqueda de Historial'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('contenido')
<div class="card card-custom mb-5">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Búsqueda de Historial Kardex - Folio: {{ $folio }}</h3>
        </div>
    </div>
    <div class="card-body">
        <p class="text-justify">
            Unidad Administrativa: {{ Auth::user()->area->identificador_unidad }} - {{ Auth::user()->area->nombre }}
        </p>
        <form class="form" id="form_buscar_historial" action="{{ route('historial.kardex.busqueda') }}" method="POST">
            <h3 class="font-size-lg text-dark font-weight-bold mb-6">1. Ingrese el número de empleado para buscar su historial:</h3>
            <div class="mb-15">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Número de Empleado:</label>
                    <div class="col-lg-6">
                        <input type="email" class="form-control" placeholder="1234567" />
                        <span class="form-text text-muted">Número completo sin comas.</span>
                    </div>
                </div>
                <div class="form-group row text-right">
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <button type="reset" class="btn btn-secondary">Borrar</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="card-footer">
        <div class="row text-right">
            <div class="col-lg-12">
                <button type="button" class="btn btn-danger btn-lg font-weight-bold" id="cancelarProceso">Cancelar Proceso</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p14_historial_kardex/historial.js') }}"> </script>
@endpush
