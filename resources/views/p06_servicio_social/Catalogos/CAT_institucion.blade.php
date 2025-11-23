@extends('layouts.main')

@section('title', 'Servicio Social - Catálogo institución')

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
                'titulo' => 'Servicio Social - Catálogo institución'
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
    @include('p06_servicio_social.Catalogos.modals.modal_cat_institucion')
    @include('p06_servicio_social.Catalogos.modals.modal_cat_programa')
    @include('p06_servicio_social.Catalogos.modals.modal_cat_escuela')
    
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title w-100">
                <h3 class="card-label">Catálogo de instituciones</h3>
                <button type="button" class="btn btn-primary btn-sm ml-auto institucion" data-toggle="modal" data-target="#modalInstitucion">
                    <i class="fas fa-plus"></i>Agregar institución
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tablaInstituciones" width="100%" 
                data-ajax="showInstituciones"
                data-toggle="table" 
                data-toolbar="#toolbar"
                data-pagination="true"
                data-page-size="6"
                data-search="true"
                data-page-list="[6, 15, 25, 50, 100]"
            >
                <thead class="text-center">
                    <th data-field="nombre_institucion">
                        <label class="titulo-dato"> Nombre de la institución </label>
                    </th>
                    <th data-field="acronimo_institucion" class="text-center">
                        <label class="titulo-dato"> acronimo </label>
                    </th>
                    <th data-field="clave_institucion" class="text-center">
                        <label class="titulo-dato"> clave </label>
                    </th>
                    <th data-formatter="accionesFormatter" class="text-center w-25">
                        <label class="titulo-dato"> acciones </label>
                    </th>
                </thead>
            </table>
        </div>
    </div>
    {{-- BEGIN::Modal principal CAT PROGRAMAS --}}
    <div id="modalCatalogoProgramas" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h4 class="modal-title">Catálogo de programas de la institución</h4>
                    <button type="button" class="btn btn-primary btn-sm ml-auto programa" data-toggle="modal" data-target="#modalPrograma">
                        <i class="fas fa-plus"></i>Agregar programa
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 text-center pb-3">
                        <h6 class="nombre-institucion"></h6>
                    </div>
                    <table class="table table-bordered table-general" id="tablaProgramas"
                        data-toggle="table" 
                        data-toolbar="#toolbar"
                        data-pagination="true"
                        data-page-size="5"
                        data-search="true"
                        data-page-list="[5, 15, 25, 50, 100]"
                    >
                        <thead>
                            <th data-field="nombre_programa" class="w-50">
                                <label class="titulo-dato text-center"> Nombre del programa </label>
                            </th>
                            <th data-field="clave_programa" class="text-center w-25">
                                <label class="titulo-dato"> Clave del programa </label>
                            </th>
                            <th data-formatter="accionesProgramasFormatter" class="text-center w-25">
                                <label class="titulo-dato"> Acciones </label>
                            </th>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer py-2">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary w-25" data-dismiss="modal">
                            <i class="fas fa-window-close"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END::Modal principal CAT PROGRAMAS --}}
    {{-- BEGIN::Modal principal CAT ESCUELAS --}}
    <div id="modalCatalogoEscuelas" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h4 class="modal-title">Catálogo de escuelas</h4>
                    <button type="button" class="btn btn-primary btn-sm ml-auto escuela" data-toggle="modal" data-target="#modalEscuela">
                        <i class="fas fa-plus"></i>Agregar escuela
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 text-center pb-3">
                        <h6 class="nombre-institucion"></h6>
                    </div>
                    <table class="table table-bordered table-general" id="tablaEscuelas"
                        data-toggle="table" 
                        data-toolbar="#toolbar"
                        data-pagination="true"
                        data-page-size="5"
                        data-search="true"
                        data-page-list="[5, 15, 25, 50, 100]"
                    >
                        <thead>
                            <th data-field="nombre_escuela">
                                <label class="titulo-dato text-center"> Nombre de la escuela </label>
                            </th>
                            <th data-field="acronimo_escuela" class="text-center">
                                <label class="titulo-dato"> acronimo </label>
                            </th>
                            <th data-field="direccion_escuela">
                                <label class="titulo-dato text-center"> dirección </label>
                            </th>
                            <th data-formatter="accionesEscuelasFormatter" class="text-center">
                                <label class="titulo-dato"> Acciones </label>
                            </th>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer py-2">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary w-25" data-dismiss="modal">
                            <i class="fas fa-window-close"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END::Modal principal CAT ESCUELAS --}}
@endsection

@push('scripts')
    <script type="text/javascript">
        URL_showInstituciones = "{{ route('servicio.social.catalogo.instituciones') }}";
        URL_datosInstitucion = "{{ route('ss.modal.datos.institucion') }}";
        URL_guardar_modificar_institucion = "{{ route('ss.guardar.editar.institucion')}}";
        URL_eliminar_institucion = "{{ route('ss.eliminar.institucion')}}";
        
        URL_showProgramas = "{{ route('ss.modal_principal.catalogo_programas') }}";
        URL_datosPrograma = "{{ route('ss.modal.datos.programa.institucion') }}";
        URL_guardar_modificar_programa = "{{ route('ss.guardar.editar.programa.institucion')}}";
        URL_eliminar_programa = "{{ route('ss.eliminar.programa.institucion')}}";

        URL_showEscuelas = "{{ route('ss.modal_principal.catalogo_escuelas') }}";
        URL_datosEscuela = "{{ route('ss.modal.datos.escuela') }}";
        URL_guardar_modificar_escuela = "{{ route('ss.guardar.editar.escuela')}}";
        URL_eliminar_escuela = "{{ route('ss.eliminar.escuela')}}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_institucion.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_programa.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_escuela.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush