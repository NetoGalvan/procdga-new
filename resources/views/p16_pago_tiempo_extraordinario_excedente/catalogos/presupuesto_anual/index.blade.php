@extends('layouts.main')

@section('title', 'P. ANUAL EXTRA/EXCEDENTE')

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
                'titulo' => 'Presupuesto Anual'
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
                <h3 class="card-label">Presupuesto Anual de Tiempo Extraordinario/Excedente</h3>
            </div>
            <div class="card-toolbar">
                <button type="button" data-toggle="modal" data-target="#createPresupuestoModal" class="btn btn-success">
                    <i class="fas fa-plus"></i> Asignar Presupuesto
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-bordered px-5">
                <div class="toolbar">
                    <select class="form-control custom-select" onchange="anioReload()" id="anioSelect" name="anioSelect">
                        @for ($i = 2021; $i <= 2050; $i++)
                            @if ($i==now()->year)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <table
                    id="table-presupuesto"
                    name="table-presupuesto"
                    class="table"
                    data-toggle="table"
                    data-search="true"
                    data-pagination="true"
                    data-url="{{ route('tiempo.extraordinario.excedente.catalogo.anual.data') }}"
                    data-sort-name="unidad_administrativa.nombre"
                    data-sort-order="asc"
                    data-toolbar=".toolbar"
                    data-buttons-align="left">
                    <thead>
                        <tr>
                            <th data-field="unidad_administrativa.nombre" class="text-center" data-sortable="true">Unidad Administrativa</th>
                            <th data-field="anio_presupuesto" class="text-center">Año</th>
                            <th data-field="presupuesto_asignado" class="text-center">$ Asignado</th>
                            <th data-field="presupuesto_utilizado" class="text-center">$ Pagado</th>
                            <th data-field="restante" data-formatter="restanteFormatter" class="text-center">$ Restante</th>
                            <th data-field="acciones" data-formatter="accionesFormatter" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('p16_pago_tiempo_extraordinario_excedente.catalogos.presupuesto_anual.modals.create')
    <div class="modal fade" id="editPresupuestoModal" tabindex="-1" role="dialog" aria-labelledby="editPresupuestoModal" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script>
        var editCatalogoRoute = "{{ route('tiempo.extraordinario.excedente.catalogo.anual.modal.edit') }}";
        var reloadCatalogoRoute = "{{ route('tiempo.extraordinario.excedente.catalogo.anual.data') }}";
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/catalogos/presupuesto_anual/index.js?v=1.0.11') }}"></script>
@endpush
