@extends('layouts.main')

@section('title', 'VALIDACIÓN DE NÓMINA')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Tareas disponibles',
				'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'VALIDACIÓN DE NÓMINA'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('contenido')

    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Datos de la nómina</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="titulo-dato"> Nombre </label>
                            <span class="valor-dato">  {{ $datosNomina->descripcion }} </span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Tipo </label>
                            <span class="valor-dato">  {{ $datosNomina->tipo_validacion }} </span>
                        </div>
                        <div class="col-md-6">
                            <label class="titulo-dato"> Observaciones </label>
                            <span class="valor-dato">  {{ $datosNomina->observaciones }} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" id="id_finalizar_T02Validacion">
        @csrf
        @method('post')

        <div class="row">
            <div class="col-12">
                <div class="card card-custom mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Prestadores de servicio social registrados</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="alert alert-custom alert-{{(count($servicioSocialPrestadores) == 0 ) ? 'warning' : 'success'}}" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">
                                    @if(count($servicioSocialPrestadores) == 0 )
                                    <p><strong>
                                        Atención: <br>
                                        No cuenta con ningún prestador a considerar, por lo cual tendra que terminar el procedimiento finalizando la tarea, para que el proceso pueda seguir con su flujo. <br><br> Gracias.
                                    </strong></p>
                                    @else
                                    <p class="font-size-lg"><strong>
                                        Instrucciones: <br>
                                        Se muestran los prestadores de servicio social que corresponden al criterio de procesamiento de nómina (parcial o total) que eligió el iniciador de este trámite, para que usted valide la entrega de becas. <br>
                                        Las 3 posibilidades son: <br>
                                        <ul class="font-size-lg">
                                            <li>
                                                ACEPTAR: El prestador SI debe ser considerado para la entrega de becas.
                                            </li>
                                            <li>
                                                RECHAZAR: El prestador NO debe ser considerado para la entrega de becas.
                                            </li>
                                            <li>
                                                RECHAZAR PERMANENTEMENTE: El prestador NO debe ser considerado para la entrega de becas, PERMANENTEMENTE.
                                            </li>
                                        </ul>
                                    </strong></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="prestadores_para_validar" data-toggle="table">
                            <thead>
                                <tr>
                                    <th width="25%"><label class="titulo-dato text-center">Datos del prestador</label></th>
                                    <th width="20%"><label class="titulo-dato text-center">Información de la institución</label></th>
                                    <th width="15%"><label class="titulo-dato text-center">Estado del servicio prestado</label></th>
                                    <th width="12%"><label class="titulo-dato text-center">Meses a pagar</label></th>
                                    <th width="13%"><label class="titulo-dato text-center">Folio</label></th>
                                    <th width="15%"><label class="titulo-dato text-center">Validación</label></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($servicioSocialPrestadores as $key => $SSPrestador)
                                    @if(is_null($SSPrestador->nominaDetalle))
                                    <tr>
                                        <td>
                                            <b>Nombre: </b>{{ $SSPrestador->prestador->nombre_prestador }} {{ $SSPrestador->prestador->primer_apellido }} {{ $SSPrestador->prestador->segundo_apellido }} <br>
                                            <b>Correo: </b>{{ $SSPrestador->prestador->email }} <br>
                                            <b>Carrera: </b> {{ $SSPrestador->prestador->carrera }}
                                        </td>
                                        <td>
                                            <b>Escuela: </b>{{ $SSPrestador->prestador->escuela->nombre_escuela }} ({{ $SSPrestador->prestador->escuela->acronimo_escuela }}) <br>
                                            <b>Dirección: </b> {{ $SSPrestador->prestador->escuela->direccion_escuela }}
                                        </td>
                                        <td>
                                            @if ($SSPrestador->prestador->estatus_prestador == "LIBERADO")
                                            <span class="badge badge-success"><i class="fas fa-user-check icon-nm text-white mr-1"></i>{{ $SSPrestador->prestador->estatus_prestador }}</span><br>
                                            @elseif ($SSPrestador->prestador->estatus_prestador == "EN CURSO")
                                            <span class="badge badge-primary"><i class="fas fa-cog  icon-nm text-white mr-1"></i>EN CURSO</span><br>
                                            @endif
                                            Inició el: {{ $SSPrestador->fecha_inicio }} <br>
                                            Termina el: {{ $SSPrestador->fecha_fin }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $inicio = Carbon\Carbon::parse($SSPrestador->fecha_inicio);
                                                $fin = Carbon\Carbon::parse($SSPrestador->fecha_fin);
                                                # obtenemos la diferencia entre las dos fechas
                                                $diferencia_entre_fechas = $fin->diff($inicio);
                                                # obtenemos la diferencia en meses
                                                $diferencia_de_meses = $diferencia_entre_fechas->format("%m");
                                                # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
                                                $diferencia_de_anios = $diferencia_entre_fechas->format("%y")*12;
                                                # sumamos el numero de meses y el numero de meses por año, en caso de que las fechas sean mayores a un año
                                                $total_de_meses = $diferencia_de_meses + $diferencia_de_anios;
                                                # agregamos el valor de meses_a_pagar a la consulta original de los prestadores
                                                $meses_a_pagar = $total_de_meses;
                                            @endphp
                                            <b>{{$meses_a_pagar}} {{($meses_a_pagar > 1) ? 'meses' : 'mes'}} </b>
                                        </td>
                                        <td>
                                            {{ $SSPrestador->folio }}
                                        </td>
                                        <td>
                                            <select class="form-control normalizar-texto asignar_validacion" name="asignar_validacion_{{$key+1}}" id="asignar_validacion_{{$key+1}}" data-prestador="{{$SSPrestador->servicio_social_id}}">
                                                <option value="" {{(is_null($SSPrestador->payment_estatus)) ? 'selected' : ''}} disabled>Seleccione</option>
                                                    @foreach ($validaciones as $validacion)
                                                    <option class="text-uppercase" value="{{$validacion}},{{$SSPrestador->servicio_social_id}}"
                                                        {{($SSPrestador->payment_estatus == $validacion) ? 'selected' : ''}}
                                                    >
                                                        {{ $validacion }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Sin registros</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 text-right">
                                <span class="titulo-dato">  Para todos los prestadores </span>
                                <button type="button" id="aceptar_todos" name="aceptar_todos" data-validacion="{{$validaciones[0]}}"
                                class="btn btn-primary ml-2 mr-2">
                                    <i class="far fa-check-circle"></i>Aceptar
                                </button>

                                <button type="button" id="rechazar_todos" name="rechazar_todos" data-validacion="{{$validaciones[1]}}"
                                class="btn btn-warning ml-2 mr-2">
                                    <i class="far fa-times-circle"></i>Rechazar
                                </button>

                                <button type="button" id="rechazar_todos_permanentemente" name="rechazar_todos_permanentemente" data-validacion="{{$validaciones[2]}}" class="btn btn-danger ml-2 mr-2">
                                    <i class="far fa-trash-alt"></i>Rechazar Permanentemente
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="text-center">
                            <button id="finalizarT02Validacion" name="finalizarT02Validacion" class="btn btn-success btn-md" type="button"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_validaciones = "{{ route('servicio.social.sub.validacion.nomina', [$nomina_id, $instanciaTarea]) }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/sub_proceso/T02_validacionNomina.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
