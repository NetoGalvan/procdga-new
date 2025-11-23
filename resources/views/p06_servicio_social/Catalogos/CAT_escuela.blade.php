@extends('layouts.main')

@section('title', 'Servicio Social - Catálogo escuela')

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
                'titulo' => 'Servicio Social - Catálogo escuela'
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

<form method="POST" id="formCatalogoEscuela" action="{{ route( 'servicio.social.catalogo.escuelas', $institucion_id) }}">
    @method('post')
    @csrf

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">{{ $datos_institucion->nombre_institucion }}</h3>
            </div>
        </div>
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Catálogo de Escuelas y Programas</h3>
            </div>
            <div class="form-group">
                <label for="" class="titulo-dato" style="color:white;">a</label>
                <button type="button" class="btn btn-primary" onclick="abrirModalEscuela()"><i class="fas fa-plus"></i>Agregar escuela</button>
            </div>
        </div>
        <div class="card-body">
            <div class="mensajeEscuela my-3" id="mensajeEscuela"></div>
            <div id="id_contenedor_tabla_escuelas">
                <div class="table-responsive">
                    <table id="table" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id" class="table table-bordered table-general"
                    data-pagination="true"
                    data-page-size="10"
                    data-search="true">
                        <thead class="text-center">
                            <th data-field="id" data-visible="false"></th>
                            <th data-field="nombre_escuela"><label class="titulo-dato">Nombre de la escuela</label></th>
                            <th data-field="acronimo_escuela"><label class="titulo-dato">Acronimo de la escuela</label></th>
                            <th data-field="direccion_escuela"><label class="titulo-dato">Dirección de la escuela</label></th>
                            <th data-formatter="eliminarFormatter"><label class="titulo-dato text-center">Acciones</label></th>
                        </thead>
                        @foreach ($escuelas as $esc)
                            <tr class="text-center">
                                <td>{{$esc->escuela_id }}</td>
                                <td><span class="valor-dato-tabla-td">{{$esc->nombre_escuela}}</td></span>
                                <td><span class="valor-dato-tabla-td">{{$esc->acronimo_escuela}}</td></span>
                                <td><span class="valor-dato-tabla-td">{{$esc->direccion_escuela}}</td></span>

                                <td class="text-center"></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center my-5">
    </div>

</form>

{{-- Modal para agregar una nueva escuela --}}
<div class="modal fade" id="modalEscuela" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-6">
                    <h3>Agregar Escuela</h3><h6><span class="requeridos">* Campos obligatorios</span></h6>
                </div>
                <div class="col-md-6">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('servicio.social.catalogo.escuelas', $institucion_id) }}" method="POST" id="formModalNuevaEscuela">
                @csrf
                @method('post')
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Nombre escuela</strong></label>
                                <input type="text" autocomplete="off" class="form-control normalizar-texto" name="nombreNuevaEscuela" id="nombreNuevaEscuela">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Acrónimo escuela</strong></label>
                                <input type="text" autocomplete="off" class="form-control normalizar-texto" name="acronimoNuevaEscuela" id="acronimoNuevaEscuela">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Dirección escuela</strong></label>
                                <input type="text" autocomplete="off" class="form-control normalizar-texto" name="direccionNuevaEscuela" id="direccionNuevaEscuela">
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-3">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="guardarNuevaEscuela" >Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Termina el modal para agregar una nueva escuela --}}

{{-- Inicia el modal para editar una escuela --}}
<div class="modal fade" id="modalEditarEscuela" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-6">
                    <h3>Editar Escuela</h3><h6><span class="requeridos">* Campos obligatorios</span></h6>
                </div>
                <div class="col-md-6">
                <button type="button" class="close" id="cerrarModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('servicio.social.editar.escuela', $institucion_id) }}" method="POST" id="formModalEditarEscuela">
                    @csrf
                    @method('post')
                    <div class="col-md-12">
                        <input type="hidden" name="escuela_id" id="escuela_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Nombre escuela</strong></label>
                                    <input type="text" autocomplete="off" class="form-control normalizar-texto" name="nombreEscuelaEditar" id="nombreEscuelaEditar">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Acrónimo escuela</strong></label>
                                    <input type="text" autocomplete="off" class="form-control normalizar-texto" name="acronimoEscuelaEditar" id="acronimoEscuelaEditar">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Dirección escuela</strong></label>
                                    <input type="text" autocomplete="off" class="form-control normalizar-texto" name="direccionEscuelaEditar" id="direccionEscuelaEditar">
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-3">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="actualizarEscuela" >Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Termina el modal para editar una escuela --}}



@endsection

@push('scripts')
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_escuela.js') }}"></script>
    <script>
        var urlEditarEscuela = "{{ route('servicio.social.editar.escuela', $institucion_id) }}";
        var urlEliminarEscuela = "{{ route('servicio.social.eliminar.escuela', $institucion_id) }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/catalogos/CAT_programa.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/p06_servicio_social/servicioSocial.css') }}" type="text/css"> --}}
@endpush
