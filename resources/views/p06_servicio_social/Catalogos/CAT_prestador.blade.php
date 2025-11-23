@extends('layouts.main')

@section('title', 'Catálogo prestador')

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
                'titulo' => 'Catálogo prestador'
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
    @include('p06_servicio_social.Catalogos.modals.modal_cat_prestador', 
    [
        'instituciones' => $instituciones,
        'entidades' => $entidades
    ])
    
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title w-100">
                <h3 class="card-label">Catálogo de Prestadores</h3>
                <button type="button" class="btn btn-primary btn-sm ml-auto prestador" data-toggle="modal" data-target="#modalPrestador">
                    <i class="fas fa-user-plus"></i>Agregar prestador
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tablaPrestadores" width="100%" 
                data-ajax="showPrestadores"
                data-toggle="table" 
                data-toolbar="#toolbar"
                data-pagination="true"
                data-page-size="5"
                data-search="true"
                data-page-list="[5, 10, 25, 50]"
            >
                <thead class="text-center">
                    <th data-field="nombre_prestador_completo">
                        <label class="titulo-dato"> Nombre </label>
                    </th>
                    <th data-formatter="datosFormatter">
                        <label class="titulo-dato"> Datos </label>
                    </th>
                    <th data-formatter="tipoPrestadorFormatter" class="text-center">
                        <label class="titulo-dato"> Tipo </label>
                    </th>
                    <th data-formatter="datosAcademicosFormatter" class="w-25">
                        <label class="titulo-dato">Datos académicos</label>
                    </th>
                    <th data-formatter="domicilioFormatter" class="w-25">
                        <label class="titulo-dato">Domicilio</label>
                    </th>
                    <th data-formatter="accionesFormatter" class="text-center">
                        <label class="titulo-dato">Acciones</label>
                    </th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        URL_showPrestadores = "{{ route('servicio.social.catalogo.prestadores') }}";
        URL_datosPrestador = "{{ route('ss.modal.prestador') }}";
        URL_prestador = "{{ route('ss.guardar.editar.prestador') }}";
        URL_eliminarPrestador = "{{ route('ss.eliminar.prestador') }}";
        URL_getEscuelasProgramas = "{{ route('obtener.escuelas.programas') }}";
        URL_getAlcaldiasMunicipios = "{{ route('obtener.alcaldias_municipios') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_prestador.js') }}"></script>

    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush