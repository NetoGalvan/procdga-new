@extends('layouts.main')

@section('title', 'Empleados')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-user",
        "breadcrumbs" => [
            1 => [
                'activo' => true,
				'titulo' => 'Empleados',
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

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-file-import"></i>
                </span>
                <h3 class="card-label">
                    Alfabético
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('alfabetico.iniciar.proceso') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar alfabético
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_alfabetico"
                    class="text-center"
                    data-toggle="table"
                    data-data-field="data"
                    data-total-field="total"
                    data-pagination="true"
                    data-page-size="5"
                    data-search="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
                    <thead>
                        <th data-field="quincena" data-formatter="quincenaFormatter" data-align="center"><label class="titulo-dato">Quincena</label></th>
                        {{-- <th data-field="folio" data-align="center"><label class="titulo-dato">Folio</label></th> --}}
                        <th data-field="estatus" data-formatter="estatusFormatter" data-align="center"><label class="titulo-dato">Estatus</label></th>
                        <th data-field="archivo_sin_json.nombre_archivo" data-formatter="archivoCargadoFormatter" data-align="center"><label class="titulo-dato">Archivo cargado</label></th>
                        <th data-field="archivo_sin_json.fecha_carga" data-formatter="fechaFormatter" data-align="center"><label class="titulo-dato">Fecha de carga</label></th>
                        <th data-field="archivo_sin_json.cantidad_empleados" data-formatter="cantidadEmpleadosFormatter" data-align="center"><label class="titulo-dato">Cantidad empleados</label></th>
                        <th data-field="archivo_sin_json.cargado_por_usuario.nombre" data-formatter="cargadoPorFormatter" data-align="center"><label class="titulo-dato">Cargado por</label></th>
                        <th data-field="acciones" data-formatter="accionesFormatter" data-align="center"><label class="titulo-dato">Acciones</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-custom mt-5">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-user-tie"></i>
                </span>
                <h3 class="card-label">
                    Empleados
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_empleados"
                    class="text-center"
                    data-toggle="table"
                    data-data-field="data"
                    data-total-field="total"
                    data-pagination="true"
                    data-page-size="100"
                    data-search="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
                    <thead>
                        <th data-field="numero_empleado" data-align="center"><label class="titulo-dato">No. empleado</label></th>
                        <th data-field="nombre_completo" data-formatter="nombreEmpleadoFormatter" data-align="center"><label class="titulo-dato">Nombre</label></th>
                        <th data-field="rfc" data-align="center"><label class="titulo-dato">RFC</label></th>
                        <th data-field="curp" data-align="center"><label class="titulo-dato">CURP</label></th>
                        <th data-field="puesto" data-align="center"><label class="titulo-dato">Puesto</label></th>
                        <th data-field="numero_plaza" data-align="center"><label class="titulo-dato">No. Plaza</label></th>
                        <th data-field="unidad_administrativa" data-align="center" data-formatter="unidadAdministrativaFormatter"><label class="titulo-dato">Unidad administrativa</label></th>
                        <th data-field="area.nombre_completo" data-align="center" data-formatter="areaFormatter"><label class="titulo-dato">Área</label></th>
                        <th data-field="activo" data-formatter="estatusEmpleadoFormatter" data-align="center"><label class="titulo-dato">Estatus</label></th>
                        <th data-field="acciones" data-formatter="accionesEmpleadoFormatter" data-align="center"><label class="titulo-dato">Acciones</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const alfabeticos = @json( $alfabeticos );
        const empleados = @json( $empleados );
        let ruta = "{{ route('alfabetico.carga.alfabetico', ['alfabetico' => ':alfabetico']) }}";
        ruta = ruta.replace(':alfabetico', ':alfabetico_js');
        let rutaEmpleado = "{{ route('alfabetico.editar.empleado', ['empleado' => ':empleado']) }}";
        rutaEmpleado = rutaEmpleado.replace(':empleado', ':empleado_js');
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/empleados/index.js?v=1.1') }}"></script>
@endpush
