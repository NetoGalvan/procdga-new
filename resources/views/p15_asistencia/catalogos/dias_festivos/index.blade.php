@extends('layouts.main')

@section('title', 'Asistencias - Catálogos - Fechas días festivos')

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
                'titulo' => 'Fechas días festivos'
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
    <form id="form_agregar_fecha" action="{{ route("asistencia.catalogo.dias.festivos.store") }}">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Guardar fecha</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Descripción </strong></label>
                        <select name="descripcion" class="form-control select2 normalizar-texto" autocomplete="off" required>
                            <option value=""> Selecciona una opción </option>
                            @foreach ($diasFestivos as $diaFestivo)
                                <option value="{{ $diaFestivo->nombre }}"> {{ $diaFestivo->nombre }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha" class="titulo-dato"><strong><span class="requeridos">* </span>Fecha</strong></label>
                        <input type="text" name="fecha" class="form-control input-date" autocomplete="off" readonly required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar fecha
                </button>
            </div>
        </div>
    </form>
    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Fechas días festivos
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_fechas"
                    data-toggle="table"
                    class="table"
                    data-unique-id="dia_festivo_fecha_id">
                    <thead>
                        <tr>
                            <th data-field="dia_festivo_fecha_id" class="text-center" data-visible="false"><label class="titulo-dato">ID</label></th>
                            <th data-field="fecha" class="text-center" data-formatter="fechaFormatter"><label class="titulo-dato">Fecha</label></th>
                            <th data-field="descripcion" class="text-center"><label class="titulo-dato">Descripción</label></th>
                            <th data-field="acciones" class="text-center" data-formatter="accionesFormatter" data-events="operateEventsAcciones"><label class="titulo-dato">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <form id="form_editar_fecha" action="{{ route("asistencia.catalogo.dias.festivos.update") }}">
        <div class="modal fade" id="modal_editar_fecha">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="dia_festivo_fecha_id">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="titulo-dato"><strong><span class="text-danger">*</span> Descripción </strong></label>
                                <select name="descripcion" class="form-control select2 normalizar-texto" autocomplete="off" required>
                                    <option value=""> Selecciona una opción </option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label for="fecha" class="titulo-dato"><strong><span class="requeridos">* </span>Fecha</strong></label>
                                <input type="text" name="fecha" class="form-control input-date" autocomplete="off" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const diasFestivos = @json($diasFestivos);
        const fechas = @json($fechas);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p15_asistencia/catalogos/dias_festivos/index.js') }}"></script>
@endpush
