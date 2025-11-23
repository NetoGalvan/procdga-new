@extends('layouts.pdf')

@php 
    use Carbon\Carbon;                            
@endphp 

@section('contenido')
    <div class="mb-6">
        <h4 class="text-center font-size-14 mt-0 mb-6"> TARJETA ELECTRÓNICA CALENDARIO PERIODO {{ Carbon::parse($fechaInicio)->format("d/m/Y") }} - {{ Carbon::parse($fechaFinal)->format("d/m/Y") }} </h4>
        <p class="font-size-14 mt-0 mb-0"> 
            <strong> NOMBRE: </strong> {{ $empleado->nombre_completo }} <br>
            <strong> RFC: </strong> {{ $empleado->rfc }} <br>
            <strong> NÚMERO DE EMPLEADO: </strong> {{ $empleado->numero_empleado }} <br>
            <strong> UNIDAD ADMINISTRATIVA: </strong> {{ $empleado->unidad_administrativa }} - {{ $empleado->unidad_administrativa_nombre }}
        </p>
    </div>
    <div>
        @php 
            $i = 0;
            $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        @endphp
        @foreach ($contenedores as $indice => $contenedor)
            <h2 class="text-center font-size-14 mt-0 mb-6"> {{ $meses[Carbon::parse($indice)->month - 1] }} {{ Carbon::parse($indice)->year }} </h2>
            <div class="table-responsive font-size-8">
                <table class="table table-sm table-bordered text-uppercase text-center">
                    <thead class="thead-light">
                        <tr>
                            <th width="14%">DOMINGO</th>
                            <th width="14%">LUNES</th>
                            <th width="14%">MARTES</th>
                            <th width="14%">MIÉRCOLES</th>
                            <th width="14%">JUEVES</th>
                            <th width="14%">VIERNES</th>
                            <th width="14%">SÁBADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (collect($contenedor)->chunk(7) as $semana)
                            <tr>
                                @foreach ($semana as $dia)
                                    <td style="height:100px;"> 
                                        @if (isset($dia["fecha"]))
                                            <!-- Día -->
                                            <p class="text-right m-0"><strong> {{ $dia["fecha"]->day }} </strong></p>
                                            @if ($dia["data"])
                                                @if (in_array($dia["data"]["evaluacion_final"], ["ASISTENCIA", "RETARDO_LEVE", "RETARDO_GRAVE", "FALTA"]))
                                                    <!-- Horario -->
                                                    <p class="m-0 mt-1"> 
                                                        @if ($dia["data"]["horario"]["salida"])
                                                            <strong>H:</strong> {{ $dia["data"]["horario"]["entrada"] }} : {{ $dia["data"]["horario"]["salida"] }}  
                                                        @else
                                                            <strong>H:</strong> {{ $dia["data"]["horario"]["entrada"] }}  
                                                        @endif
                                                    </p>
                                                    <!-- Eventos de evaluación -->
                                                    <table class="table table-sm table-bordered table-striped text-uppercase text-center font-size-6 m-0 mt-1">
                                                        <thead>
                                                            <tr>
                                                                <td width="25%" class="p-0"><strong>E</strong></td>
                                                                <td width="25%" class="p-0"><strong>RL</strong></td>
                                                                <td width="25%" class="p-0"><strong>RG</strong></td>
                                                                <td width="25%" class="p-0"><strong>S</strong></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                @php 
                                                                    $eventoEntrada = $dia["data"]["eventos_validos"]["ENTRADA"]["fecha"] ?? null;
                                                                    $eventoRetardoLeve = $dia["data"]["eventos_validos"]["RETARDO_LEVE"]["fecha"] ?? null;
                                                                    $eventoRetardoGrave = $dia["data"]["eventos_validos"]["RETARDO_GRAVE"]["fecha"]?? null;
                                                                    $eventoSalida = $dia["data"]["eventos_validos"]["SALIDA"]["fecha"] ?? null;
                                                                @endphp
                                                                <td>@if ($eventoEntrada) {{ Carbon::parse($eventoEntrada)->format("H:i") }} @else &nbsp; @endif</td>
                                                                <td>@if ($eventoRetardoLeve) {{ Carbon::parse($eventoRetardoLeve)->format("H:i") }} @else &nbsp; @endif</td>
                                                                <td>@if ($eventoRetardoGrave) {{ Carbon::parse($eventoRetardoGrave)->format("H:i") }} @else &nbsp; @endif</td>
                                                                <td>@if ($eventoSalida) {{ Carbon::parse($eventoSalida)->format("H:i") }} @else &nbsp; @endif</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                                <!-- Evaluación -->
                                                <p class="my-2"><strong>{{ str_replace("_", " ", $dia["data"]["evaluacion_final"]) }}</strong></p>
                                                <!-- Incidencias -->
                                                @if (count($dia["data"]["incidencias"]) > 0 && in_array($dia["data"]["evaluacion_final"], ["ASISTENCIA", "RETARDO_LEVE", "RETARDO_GRAVE", "FALTA"]))
                                                    <p class="m-0 font-size-6"> 
                                                        @foreach ($dia["data"]["incidencias"] as $incidenciaEmpleado)
                                                            <strong>
                                                                {{ $incidenciaEmpleado["folio_autorizacion"] }} <br> 
                                                                {{ $incidenciaEmpleado["tipo_incidencia"]["tipo_justificacion"]["nombre"] }} <br> 
                                                                {{ str_replace("_", " ", $incidenciaEmpleado["tipo_incidencia"]["intervalo_evaluacion"]) }} <br>
                                                            </strong>
                                                        @endforeach
                                                    </p>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($i < count($contenedores) - 1)
                <div class="page-break"></div>
            @endif
            @php
                $i++;
            @endphp
        @endforeach
    </div>
@endsection