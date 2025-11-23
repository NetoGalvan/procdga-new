@extends('layouts.main')

@section('title', 'Archivos externos')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Archivos externos",
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
            "item_seleccionado" => "archivos-externos",
        ]
    ])
@endsection

@section('contenido')
    <div class="row">
        @if (!Auth::user()->hasRole(["SUPER_ADMIN", "JUD_PRES", "JUD_MP"]))
        <div class="col-md-6 col-xl-4 mb-8">
            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                <div class="card-body">
                    <div class="row" style="height: 100%;">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <i class="fas fa-file-download icon-4x icon-finanzas"></i>
                        </div>
                        <div class="col-9 d-flex align-items-center">
                            <h5 class="text-dark font-weight-bold font-size-h6"> No tiene archivos externos asignados. </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (Auth::user()->hasRole(["SUPER_ADMIN", "JUD_MP"]))
        <div class="col-md-6 col-xl-4 mb-8">
            <a href="{{ route("movimiento.personal.archivos.sun") }}">
                <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                    <div class="card-body">
                        <div class="row" style="height: 100%;">
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="fas fa-file-download icon-4x icon-finanzas"></i>
                            </div>
                            <div class="col-9 d-flex align-items-center">
                                <div>
                                    <div class="text-dark text-hover-primary font-weight-bold font-size-h6 mb-3"
                                        style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical">
                                        ARCHIVOS PARA EL SUN
                                    </div>
                                    <div class="text-dark-75" 
                                        style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical">
                                        MOVIMIENTOS DE PERSONAL
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
    </div>
@endsection