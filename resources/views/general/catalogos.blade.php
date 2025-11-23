@extends('layouts.main')

@section('title', 'Catálogos')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Catálogos",
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
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@section('contenido')
    
        @if (count($catalogosPorProceso) == 0)
        <div class="row">
            <div class="col-md-6 col-xl-4 mb-8">
                <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                    <div class="card-body">
                        <div class="row" style="height: 100%;">
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="fas fa-clipboard-list icon-4x icon-finanzas"></i>
                            </div>
                            <div class="col-9 d-flex align-items-center">
                                <h5 class="text-dark font-weight-bold font-size-h6"> No tiene catálogos asignados. </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            @foreach ($catalogosPorProceso as $catalogoPorProceso)
                <div class="row">
                @foreach ($catalogoPorProceso as $indice => $catalogo)
                    @if ($indice == 0)
                    <div class="col-12">
                        <h4 class="text-dark font-weight-bold mb-5">{{ $catalogo->proceso->nombre }}</h4>
                    </div>
                    @endif 
                    <div class="col-md-6 col-xl-4 mb-8">
                        <a href="{{ route($catalogo->ruta) }}">
                            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                                <div class="card-body">
                                    <div class="row" style="height: 100%;">
                                        <div class="col-3 d-flex justify-content-center align-items-center">
                                            <i class="fas fa-clipboard-list icon-4x icon-finanzas"></i>
                                        </div>
                                        <div class="col-9 d-flex align-items-center">
                                            <div>
                                                <div class="text-dark font-weight-bold font-size-h6 mb-3"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical">
                                                    {{ $catalogo->nombre }}
                                                </div>
                                                <div class="text-dark-75" 
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical">
                                                    {{ $catalogo->proceso->nombre }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                </div>
            @endforeach
        @endif
@endsection