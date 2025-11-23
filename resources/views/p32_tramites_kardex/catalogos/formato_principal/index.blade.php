@extends('layouts.main')

@section('title', "Biométricos")

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
                'titulo' => $catalogo->nombre
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
    <link href="{{ asset('metronic/plugins/custom/cropper/cropper.bundle.css') }}" rel="stylesheet">
    <style>
        .tox-tinymce {
            height: 150px !important;
        }
    </style>
@endpush

@section('contenido')
    <div class="row">
        <div class="col-md-5">
            <div class="card card-custom mb-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="tipo_imagen" class="titulo-dato">Posición Imagen</label>
                            <select class="form-control text-uppercase" name="tipo_imagen" id="tipo_imagen" >
                                    <option value=""> Seleccione una opción </option>
                                    <option value="PRINCIPAL_HEADER" > PRINCIPAL - HEADER </option>
                                    <option value="SECUNDARIO_HEADER" > SECUNDARIO - HEADER </option>
                                    <option value="FOOTER" > FOOTER </option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="titulo-dato">Imagen</label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo_primario" />
                                <label class="custom-file-label mb-0" for="logo_primario">ELEGIR ARCHIVO</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="titulo-dato">Nombre dependencia</label>
                            <textarea id="formato_header" class="form-control" style="height: 50px !important;"/>{{ $formato->texto_encabezado }}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="titulo-dato">Pie de página</label>
                            <textarea id="formato_footer" class="form-control"/>{{ $formato->texto_pie }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button
                        data-url="{{ route("tramite.kardex.catalogo.formato_principal.guardar") }}"
                        id="guardar_atributos_formato"
                        class="btn btn-primary">Actualizar formato</button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-custom">
                <div class="card-body">
                    <iframe id="formato_base" src="data:application/pdf;base64,{{$pdf}}" width="100%" height="1150">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/cropper/cropper.bundle.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/tinymce/tinymce.bundle.js?v=7.0.4') }}"></script>
	<script src="{{ asset('metronic/js/pages/crud/forms/editors/tinymce.js?v=7.0.4') }}"></script>
    <script src="{{ asset('js/p32_tramites_kardex/catalogos/formato_principal/index.js') }}"></script>
@endpush
