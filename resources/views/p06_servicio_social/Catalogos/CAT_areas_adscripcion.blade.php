@extends('layouts.main')

@section('title', 'Catálogo áreas de adscripción')

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
                'titulo' => 'Catálogo áreas de adscripción'
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
    @include('p06_servicio_social.Catalogos.modals.modal_cat_area_adscripcion')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title w-100">
                <h3 class="card-label">Catálogo de áreas de adscripción</h3>
                <button type="button" class="btn btn-primary btn-sm ml-auto area-adscripcion" data-toggle="modal" data-target="#modalAreaAdscripcion">
                    <i class="fas fa-plus"></i>Agregar área de adscripción
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tablaAreasAdscripcion" width="100%" 
                data-ajax="showAreasAdscripcion"
                data-toggle="table" 
                data-toolbar="#toolbar"
                data-pagination="true"
                data-page-size="5"
                data-search="true"
                data-page-list="[5, 10, 25, 50]"
            >
                <thead>
                    <tr class="text-center">
                        <th data-field="nombre_area_adscripcion">
                            <label class="titulo-dato">Nombre del área</label>
                        </th>
                        <th data-field="direccion_area_adscripcion">
                            <label class="titulo-dato">Dirección</label>
                        </th>
                        <th data-formatter="accionesFormatter">
                            <label class="titulo-dato">Acciones</label>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

{{--
<form method="POST" id="formCatalogoAreasAds" action="{{ route( 'servicio.social.catalogo.areas.adscripcion') }}">
    @method('post')
    @csrf

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Catálogo de áreas de adscripción</h3>
            </div>
            <div class="form-group">
                <label for="" class="titulo-dato" style="color:white;">a</label>
                <button type="button" class="btn btn-primary" onclick="abrirModalArea()"><i class="fas fa-plus"></i>Agregar área</button>
            </div>
        </div>
        <div class="card-body">
            <div id="id_contenedor_tabla_areas">
                <div class="table-responsive">
                    <table id="table" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id" class="table table-bordered table-general"
                        data-pagination="true"
                        data-page-size="10"
                        data-search="true">
                        <thead>
                            <tr class="text-center">
                                <th data-field="id" data-visible="false">Id</th>
                                <th data-field="ruta" data-visible="false">Ruta</th>
                                <th data-field="nombre_area_adscripcion" class="text-uppercase"><label class="titulo-dato">Nombre del área</label></th>
                                <th data-field="direccion_area_adscripcion"><label class="titulo-dato">Dirección</label></th>
                                <th data-formatter="eliminarFormatter"><label class="titulo-dato">Acciones</label></th>
                            </tr>
                        </thead>
                            @foreach ($areasAds as $area)
                                <tr class="text-center">
                                    <td>{{$area->area_adscripcion_id }}</td>
                                    <td>{{$area->ruta }}</td>
                                    <td>{{$area->nombre_area_adscripcion}}</td>
                                    <td>{{$area->direccion_area_adscripcion}}</td>
                                    <td class="text-center"></td>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
--}}
{{-- Modal para Agregar una Institucioon --}}
{{--
<div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-6">
                    <h3>Agregar área</h3><h6><span class="requeridos">* Campos obligatorios</span></h6>
                </div>
                <div class="col-md-6">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('servicio.social.catalogo.areas.adscripcion') }}" method="POST" id="modalNuevaArea">
                    @csrf
                    @method('post')
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre área adscripción</strong></label>
                                    <input type="text" class="form-control normalizar-texto" name="nombreArea"
                                    autocomplete="off" id="nombreArea">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato"><strong><span class="requeridos">* </span>Dirección</strong></label>
                                    <input type="text" class="form-control normalizar-texto" name="direccionArea"
                                    autocomplete="off" id="direccionArea">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-3">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="guardarArea" >Guardar</button>
                        <button type="button" class="btn btn-primary" id="actualizarArea" style="display: none">Actualizar</button>
                    </div>
                    <div id="newRow"></div>
                </form>
            </div>
        </div>
    </div>
</div>
--}}
@endsection

@push('scripts')
    <script type="text/javascript">
        URL_showAreasAdscripcion = "{{ route('servicio.social.catalogo.areas.adscripcion') }}";
        URL_datosAreaAdscripcion = "{{ route('ss.modal.datos.area_adscripcion') }}";
        URL_guardar_modificar_areaAdscripcion = "{{ route('ss.guardar.editar.area_adscripcion') }}";
        URL_eliminar_areaAdscripcion = "{{ route('ss.eliminar.area_adscripcion') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_areas_adscripcion.js') }}"></script>
{{-- 
    <script>
        var urlEliminar = "{{ route('servicio.social.eliminar.area.adscripcion') }}";
        var urlEditar = "{{ route('servicio.social.editar.area.adscripcion') }}";
    </script>
--}}
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush
