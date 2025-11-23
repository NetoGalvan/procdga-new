@extends('layouts.main')

@section('title', 'Asistencias - Catálogos - Horarios')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Horarios',
                'ruta' => Route('asistencia.catalogo.horarios')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Detalle horario'
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
    <form action="{{ route("asistencia.catalogo.horarios.update", $horario) }}" method="POST" id="form_guardar_horario">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Detalle horario</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Entrada</strong></label>
                        <input type="text" class="form-control" value="{{ $horario->entrada }}" disabled autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Salida</strong></label>
                        <input type="text" class="form-control" value="{{ $horario->salida }}" disabled autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo</strong></label>
                        <select class="form-control" name="tipo" autocomplete="off" disabled>
                            <option value="">Selecciona una opción</option>
                            <option value="SINDICALIZADOS" @if (isset($horario) && $horario->tipo == "SINDICALIZADOS") selected @endif>SINDICALIZADOS</option>
                            <option value="NO_SINDICALIZADOS" @if (isset($horario) && $horario->tipo == "NO_SINDICALIZADOS") selected @endif>NO SINDICALIZADOS</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        @php
                            $diasSemana = [ 
                                "domingo" => "Domingo", 
                                "lunes" => "Lunes", 
                                "martes" => "Martes", 
                                "miercoles" => "Miércoles", 
                                "jueves" => "Jueves", 
                                "viernes" => "Viernes", 
                                "sabado" => "Sábado"
                            ]    
                        @endphp
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Días laborales</strong></label>
                        <div class="checkbox-inline">
                            @php
                                $diasSeleccionados = isset($horario) ? str_split($horario->dias) : null;
                                $i = 0;
                            @endphp
                            @foreach ($diasSemana as $indice => $dia)
                                <label class="checkbox">
                                    <input type="checkbox" name="dias_laborales[]" value="{{ $indice }}" autocomplete="off" @if (!is_null($diasSeleccionados) && $diasSeleccionados[$i]) checked @endif disabled/>
                                    <span></span>
                                    {{ $dia }}
                                </label>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="separator separator-solid my-10"></div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-weight-bold mb-6">Intervalos</h4>
                    </div>
                    @php
                        $tiposIntervalos = [ 
                            "ENTRADA" => "Entrada", 
                            "RETARDO_LEVE" => "Retardo leve", 
                            "RETARDO_GRAVE" => "Retardo grave", 
                            "SALIDA" => "Salida", 
                        ]    
                    @endphp
                    @foreach ($tiposIntervalos as $indice => $tipo)
                        <div class="col-md-12">
                            <strong class="text-uppercase">{{ $tipo }}</strong>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="titulo-dato"><strong><span class="text-danger">*</span> Inicio</strong></label>
                            <input type="text" class="form-control" value="{{ isset($horario) ? $horario->intervalos()->where("tipo", $indice)->first()->inicio : "" }}" disabled>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="titulo-dato"><strong><span class="text-danger">*</span> Final</strong></label>
                            <input type="text" class="form-control" value="{{ isset($horario) ? $horario->intervalos()->where("tipo", $indice)->first()->final : "" }}" disabled>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection