@extends('layouts.main')

@section('title', 'Manuales de usuario')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Manuales de usuario",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => true,
                "titulo" => 'Inicio'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "manuales",
        ]
    ])
@endsection

@section('contenido')
    <div class="row">
        @if (count($manuales) == 0)
        <div class="col-md-6 col-xl-4 mb-8">
            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                <div class="card-body">
                    <div class="row" style="height: 100%;">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <i class="fas fa-clipboard-list icon-4x icon-finanzas"></i>
                        </div>
                        <div class="col-9 d-flex align-items-center">
                            <h5 class="text-dark font-weight-bold font-size-h6"> No hay manuales. </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            @foreach ($manuales as $manual)
            <div class="col-md-6 col-xl-4 mb-8">
                <a href="javascript:void(0)" data-url="{{ asset($manual->ruta) }}" data-titulo="{{ $manual->nombre }}" class="card-manual">
                    <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                        <div class="card-body">
                            <div class="row" style="height: 100%;">
                                <div class="col-3 d-flex justify-content-center align-items-center">
                                    <i class="fas fa-book icon-4x icon-finanzas"></i>
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <div>
                                        <div
                                            class="text-dark font-weight-bold font-size-h6 mb-3"
                                            style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical">
                                            {{ $manual->nombre }}
                                        </div>
                                        <div class="text-dark-75"
                                            style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical">
                                            {{ $manual->proceso->nombre }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        @endif
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_manual_usuario">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_manual"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <embed id="visualizador_pdf" type="application/pdf" width="100%" height="700px">
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-sm btn-success" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>    
@endsection

@push('scripts')
	<script src="{{ asset('js/general/manuales.js?v=1.1') }}"></script>
@endpush
