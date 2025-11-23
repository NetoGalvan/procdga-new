@extends('layouts.main')

@section('title', 'LISTADO DE SOLICITANTES PARA EL PREMIO DE PUNTUALIDAD Y ASISTENCIA')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Notificaciones',
				'ruta' => Route('notificaciones')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'LISTADO DE SOLICITANTES PARA EL PREMIO DE PUNTUALIDAD Y ASISTENCIA'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "notificaciones",
        ]
    ])
@endsection

@section('contenido')

    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">LISTADO DE SOLICITANTES PARA EL PREMIO DE PUNTUALIDAD Y ASISTENCIA</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="titulo-dato"> Área </label>
                            <span class="valor-dato">  {{ $inscripcion->area->identificador }} - {{ $inscripcion->area->nombre }} </span>
                        </div>
                        <div class="col-md-6">
                            <label class="titulo-dato"> Folio </label>
                            <span class="valor-dato">  {{ $inscripcion->folio }} </span>
                        </div>
                        <div class="col-md-6">
                            <label class="titulo-dato"> Quincena de pago </label>
                            <span class="valor-dato"> {{ $inscripcion->quincena }} </span>
                        </div>
                        <div class="col-md-6">
                            <label class="titulo-dato"> Instrucciones </label>
                            <span class="valor-dato">  {{ $inscripcion->instrucciones }} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('notificacion.listado.solicitantes', [$premioPuntualidad, $instanciaTarea] ) }}" method="post">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de los empleados</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-general" id="tabla_empleados_agregados" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center"><label class="titulo-dato"> Número de empleado </label></th>
                                    <th class="text-center"><label class="titulo-dato"> Nombre del empleado </label></th>
                                    <th class="text-center"><label class="titulo-dato"> Sección sindical </label></th>
                                    <th class="text-center"><label class="titulo-dato"> Nivel salarial </label></th>
                                    <th class="text-center"><label class="titulo-dato"> Periodo de evaluación </label></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empleadosRegistrados as $empleado)
                                    <tr class="text-center">
                                        <td>{{ $empleado->numero_empleado }}</td>
                                        <td>{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                                        <td>{{ $empleado->seccion_sindical }}</td>
                                        <td>{{ $empleado->nivel_salarial }}</td>
                                        <td>{{ $empleado->fecha_inicio_evaluacion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-trash"></i>Enterado, eliminar notificación</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
