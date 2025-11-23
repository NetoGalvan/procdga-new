@extends('layouts.main')

@section('title', 'Tabulador de sueldos')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Catálogos',
                'ruta' => Route('catalogos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Tabulador de sueldos'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>[
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet" />
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Tabulador de sueldos para el tiempo extra</h3>
            </div>
            <div class="card-toolbar">
                <button type="button" data-toggle="modal" data-target="#createSueldoModal" class="btn btn-success">
                    <i class="fas fa-plus"></i> Agregar tabulador
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive  px-5">
                <div class="toolbar">
                    <label for="folio" class="titulo-dato"><strong>Año</strong></label>
                    <input type="text" class="form-control" name="anio" id="anio" readonly value="{{ date("Y") }}" autocomplete="off" >
                </div>
                <table
                    id="table-sueldos"
                    name="table-sueldos"
                    class="table mb-2"
                    data-toggle="table"
                    data-search="true"
                    data-pagination="true"
                    data-url="{{ route('tiempo.extraordinario.excedente.catalogo.tabuladores.data') }}"
                    data-sort-name="nivel_salarial"
                    data-sort-order="asc"
                    data-toolbar=".toolbar"
                    data-buttons-align="left">
                    <thead>
                        <tr>
                            <th data-field="tipo" class="text-center" data-sortable="true" data-formatter="tipoFormatter">Tipo</th>
                            <th data-field="nivel_salarial" class="text-center" data-sortable="true">Nivel Salarial</th>
                            <th data-field="tabulador_autorizado_bruto" class="text-center">Tabulador autorizado bruto</th>
                            <th data-field="reconocimiento_mensual_bruto" class="text-center">Reconocimiento mensual bruto</th>
                            <th data-field="cantidad_adicional_bruto" class="text-center">Cantidad adicional bruto</th>
                            <th data-field="asignacion_adicional_bruto" class="text-center">Asignción adicional bruto</th>
                            <th data-field="total_mensual_bruto" class="text-center">Total mensual bruto</th>
                            <th data-field="acciones" data-formatter="accionesFormatter" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('p16_pago_tiempo_extraordinario_excedente.catalogos.tabulador_sueldos.modals.create')
    <div class="modal fade" id="editSueldoModal" name="editSueldoModal" tabindex="-1" role="dialog" aria-labelledby="editSueldoModal" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script>
        var editCatalogoRoute = "{{ route('tiempo.extraordinario.excedente.catalogo.tabuladores.modal.edit') }}";
        var reloadCatalogoRoute = "{{ route('tiempo.extraordinario.excedente.catalogo.tabuladores.data') }}";
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
        var urlEliminar = "{{ route('tiempo.extraordinario.excedente.eliminar.tabulador') }}";
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/catalogos/tabulador_sueldos/index.js?v=1.0.5') }}"></script>
@endpush
