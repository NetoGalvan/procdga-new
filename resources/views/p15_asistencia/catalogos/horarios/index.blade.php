@extends('layouts.main')

@section('title', 'Horarios')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Cátalogos',
                'ruta' => Route('catalogos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Horarios'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-clock"></i>
                </span>
                <h3 class="card-label">
                    Horarios
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route("asistencia.catalogo.horarios.create") }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar horario
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="table_horarios"
                    data-toggle="table"
                    data-unique-id="horario_id"
                    class="table text-center">
                    <thead>
                        <tr class="text-center">
                            <th data-field="horario_id" data-visible="false"><label class="titulo-dato">ID</label></th>
                            <th data-formatter="horarioFormatter"><label class="titulo-dato">Horario</label></th>
                            <th data-field="intervalosAux.ENTRADA" data-formatter="intervaloFormatter"><label class="titulo-dato">Intervalo <br> Entrada</label></th>
                            <th data-field="intervalosAux.SALIDA" data-formatter="intervaloFormatter"><label class="titulo-dato">Intervalo <br> Salida</label></th>
                            <th data-field="intervalosAux.RETARDO_LEVE" data-formatter="intervaloFormatter"><label class="titulo-dato">Intervalo <br> Retardo leve</label></th>
                            <th data-field="intervalosAux.RETARDO_GRAVE" data-formatter="intervaloFormatter"><label class="titulo-dato">Intervalo <br> Retardo grave</label></th>
                            <th data-field="dias" data-formatter="diasFormatter"><label class="titulo-dato">Días <br> laborales</label></th>
                            <th data-field="dias_festivos_son_laborales" data-formatter="aplicaDiasFestivosFormatter"><label class="titulo-dato">Aplica <br> dias festivos</label></th>
                            <th data-field="tipo_empleado" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo <br> empleado</label></th>
                            <th data-field="es_horario_base" data-formatter="tipoHorarioFormatter"><label class="titulo-dato">Tipo</label></th>
                            <th data-field="activo" data-formatter="activoFormatter"><label class="titulo-dato">Estatus</label></th>
                            <th data-formatter="accionesFormatter"><label class="titulo-dato text-center">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var horarios = @json($horarios);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p15_asistencia/catalogos/horarios/index.js?v=1.0') }}"></script>
@endpush
