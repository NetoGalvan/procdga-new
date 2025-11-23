@extends('layouts.main')

@section('title', 'Procesos')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Procesos",
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
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@section('contenido')
	<div class="row">
		@if (count($procesos) == 0)
		<div class="col-md-6 col-xl-4 mb-8">
			<div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
				<div class="card-body">
					<div class="row" style="height: 100%;">
						<div class="col-3 d-flex justify-content-center align-items-center">
							<i class="fas fa-cog icon-4x icon-finanzas"></i>
						</div>
						<div class="col-9 d-flex align-items-center">
							<h5 class="text-dark font-weight-bold font-size-h6"> No tiene procesos asignados. </h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		@else
			@foreach ($procesos as $proceso)
                @if ($proceso->nombre == 'SOLICITUD DE SERVICIO')
                    @foreach ($servicios as $servicio)
                    <div class="col-md-6 col-xl-4 mb-8">
                        <a href="{{ route($proceso->ruta_descripcion, $servicio->clave) }}" >
                            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                                <div class="card-body">
                                    <div class="row" style="height: 100%;">
                                        <div class="col-3 d-flex justify-content-center align-items-center">
                                            @if ($proceso->icono)
                                            <i class="{{ $proceso->icono }} icon-4x icon-finanzas"></i>
                                            @else
                                            <i class="fas fa-file-alt icon-4x icon-finanzas"></i>
                                            @endif
                                        </div>
                                        <div class="col-9 d-flex align-items-center">
                                            <div>
                                                <div
                                                    class="text-dark text-uppercase font-weight-bold font-size-h6 mb-3"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical">
                                                    {{ $servicio->nombre_servicio_general }}
                                                </div>
                                                <div class="text-dark-75"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical">
                                                    Proceso optimizado que permite administrar los requerimientos de los servicios de {{ $servicio->nombre_servicio_general }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="col-md-6 col-xl-4 mb-8">
                        <a href="{{ route($proceso->ruta_descripcion) }}" >
                            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 160px;">
                                <div class="card-body">
                                    <div class="row" style="height: 100%;">
                                        <div class="col-3 d-flex justify-content-center align-items-center">
                                            @if ($proceso->icono)
                                            <i class="{{ $proceso->icono }} icon-4x icon-finanzas"></i>
                                            @else
                                            <i class="fas fa-file-alt icon-4x icon-finanzas"></i>
                                            @endif
                                        </div>
                                        <div class="col-9 d-flex align-items-center">
                                            <div>
                                                <div
                                                    class="text-dark font-weight-bold font-size-h6 mb-3"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical">
                                                    {{ $proceso->nombre }}
                                                </div>
                                                <div class="text-dark-75"
                                                    style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical">
                                                    {{ $proceso->descripcion }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
			@endforeach
		@endif
	</div>
@endsection
