@extends('layouts.main')

@section('title', 'CIERRE DE NÓMINA')

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
                'titulo' => 'CIERRE DE NÓMINA'
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
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Prestadores de servicio social susceptibles de recibir beca</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table  id="prestadores_que_ya_pasaron_validacion"
                    class="table table-bordered font-size-lg" data-toggle="table">
                        <thead>
                            <tr>
                                <th><label class="titulo-dato text-center">Datos del prestador</label></th>
                                <th><label class="titulo-dato text-center">Información de la institución</label></th>
                                <th><label class="titulo-dato text-center">Estado del servicio prestado</label></th>
                                <th><label class="titulo-dato text-center">Meses a pagar</label></th>
                                <th><label class="titulo-dato text-center">Folio</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prestadoresYaValidados as $key => $SSPrestador)
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Estado de validación de tipo: <b>{{ $datosNomina->tipo_validacion }}</b> </h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered font-size-lg" id="estado_de_validacion_subEA" data-toggle="table">
                        <thead>
                            <tr>
                                <th><label class="titulo-dato text-center">Nombre de tarea</label></th>
                                <th><label class="titulo-dato text-center">Asignado a rol</label></th>
                                <th><label class="titulo-dato text-center">Unidad administrativa</label></th>
                                <th><label class="titulo-dato text-center">Estado</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos_sub_ea as $datos)
                                <tr class="text-center">
                                    <td>
                                        {{$datos->tarea->nombre}}
                                    </td>
                                    <td>
                                        <b>SUB_EA</b>
                                    </td>
                                    <td>
                                        {{$datos->perteneceAlArea->nombre}}
                                    </td>
                                    <td>
                                        @if ( $datos->estatus == "COMPLETADO")
                                            <span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i>{{ $datos->estatus }}</span>
                                        @else
                                            <span class="badge badge-primary"><i class="far fa-star icon-nm text-white mr-1"></i>{{ $datos->estatus }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" id="id_finalizar_T03Cierre">
        @csrf
        @method('post')
        <div class="row">
            <div class="col-12">
                <div class="card card-custom mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Importante</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <strong>
                                Nota: <br>
                                Antes de tomar alguna decisión ya sea finalizar o cancelar todas las tareas de validación deben de tener el estatus de "COMPLETADO".
                                <br>
                                <ul>
                                    <li>
                                        Para finzalizar la tarea debe haber prestadores susceptibles para la beca
                                    </li>
                                    <li>
                                        Para cancelar no debe haber ningún prestador susceptible a beca.
                                    </li>
                                </ul>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button id="finalizarT03Cierre" name="finalizarT03Cierre" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>

                        <button id="finalizarSubProceso" name="finalizarSubProceso" class="btn btn-danger"><i class="fas fa-trash"></i>Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@push('scripts')
    <script type="text/javascript">
        var URL_finalizarTarea = "{{ route('servicio.social.sub.cierre.nomina', [$nomina_id, $instanciaTarea] ) }}";
        var URL_finalizarProceso = "{{ route('finalizar.proceso.desde.T03', [$nomina_id, $instanciaTarea]) }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/sub_proceso/T03_cierreNomina.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
