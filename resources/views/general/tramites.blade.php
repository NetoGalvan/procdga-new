@extends('layouts.main')

@section('title', 'Trámites')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Trámites",
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
            "item_seleccionado" => "tramites",
        ]
    ])
@endsection

@section('contenido')

        @if (count($tramites) == 0)
        <div class="row">
            <div class="col-md-6 col-xl-4 mb-8">
                <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                    <div class="card-body">
                        <div class="row" style="height: 100%;">
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <i class="fas fa-clipboard-list icon-4x icon-finanzas"></i>
                            </div>
                            <div class="col-9 d-flex align-items-center">
                                <h5 class="text-dark font-weight-bold font-size-h6"> No tiene trámites asignados. </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            @foreach ($tramites as $tramite)
                <div class="row">
                @foreach ($tramite as $indice => $detalleTramite)
                    <div class="col-md-6 col-xl-4 mb-8">
                        <a href="{{ route($detalleTramite->ruta) }}">
                            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                                <div class="card-body">
                                    <div class="row" style="height: 100%;">
                                        <div class="col-3 d-flex justify-content-center align-items-center">
                                            @if ($detalleTramite->icono)
                                            <i class="{{ $detalleTramite->icono }} icon-4x icon-finanzas"></i>
                                            @else
                                            <i class="fas fa-file-alt icon-4x icon-finanzas"></i>
                                            @endif
                                        </div>
                                        <div class="col-9 d-flex align-items-center">
                                            <div>
                                                <div class="text-dark font-weight-bold font-size-h6 mb-3"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical">
                                                    {{ $detalleTramite->nombre }}
                                                </div>
                                                <div class="text-dark-75"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical">
                                                    {{ $detalleTramite->descripcion }}
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
