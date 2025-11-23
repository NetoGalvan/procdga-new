@extends('layouts.main')

@section('title', 'Listado de trámites')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Trámites',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Listado de trámites'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tramites",
        ]
    ])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Trámites</h3>
            </div>
        </div>
        <div class="card-body" >
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table id="table_tramites" class="text-center" data-toggle="table" data-toolbar="#toolbar">
                            <thead>
                                <tr>
                                    <th data-field="tramite_kardex_id" ><label class="titulo-dato">Id</label></th>
                                    <th data-field="tipo_tramite_kardex_id" data-formatter="tipoTramiteFormatter"><label class="titulo-dato">Trámite</label></th>
                                    <th data-field="folio"><label class="titulo-dato">Folio</label></th>
                                    <th data-field="nombre_completo"><label class="titulo-dato">Empleado</label></th>
                                    <th data-field="estatus" data-formatter="estatusFormatter"><label class="titulo-dato">Estatus</label></th>
                                    <th data-field="asignado_a_usuario" data-formatter="asignadoAUsuarioFormatter"><label class="titulo-dato">Asignado a </label></th>
                                    <th data-formatter="accionesFormatter"><label class="titulo-dato">Acciones</label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p32_tramites_kardex/tramites/listadoTramites.js?ver=1.0') }}"></script>
    <script>
        const tramitesKardex = @json($tramitesKardex);
        const urlVerTramite = @json(route('tramites.kardex.ver.detalles.proceso', ['tramiteKardex' => 'idTramiteKardex']));
    </script>
@endpush
