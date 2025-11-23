@extends('layouts.pdf')

@php 
    use Carbon\Carbon;                            
@endphp 

@section('contenido')
    <div class="mb-6">
        <h4 class="text-center font-size-14 mt-0 mb-6"> TARJETA ELECTRÓNICA PERIODO {{ Carbon::parse($fechaInicio)->format("d/m/Y") }} - {{ Carbon::parse($fechaFinal)->format("d/m/Y") }} </h4>
        <p class="font-size-14 mt-0 mb-0"> 
            <strong> NOMBRE: </strong> {{ $empleado->nombre_completo }} <br>
            <strong> RFC: </strong> {{ $empleado->rfc }} <br>
            <strong> NÚMERO DE EMPLEADO: </strong> {{ $empleado->numero_empleado }} <br>
            <strong> UNIDAD ADMINISTRATIVA: </strong> {{ $empleado->unidad_administrativa }} - {{ $empleado->unidad_administrativa_nombre }}
        </p>
    </div>
    <div class="table-responsive font-size-8">
        <table class="table table-sm table-bordered table-custom text-uppercase text-center">
            <thead class="thead-light">
                <tr>
                    <th>FECHA</th>
                    <th>ENTRADA</th>
                    <th>RETARDO <br> LEVE</th>
                    <th>RETARDO <br> GRAVE</th>
                    <th>SALIDA</th>
                    <th>HORARIO DE <br> EVALUACIÓN</th>
                    <th>EVALUACIÓN</th>
                    <th>FOLIO <br> INCIDENCIA</strong></th>
                    <th>TIPO <br> INCIDENCIA</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluaciones as $evaluacion)
                    <tr>
                        <td>
                            {{ Carbon::parse($evaluacion["fecha"])->format("d-m-Y") }} 
                        </td>
                        <td>
                            {{ $evaluacion["eventos_validos"]["ENTRADA"] ? 
                                Carbon::parse($evaluacion["eventos_validos"]["ENTRADA"]["fecha"])->format("H:i:s") : "" }}
                        </td>
                        <td>
                            {{ $evaluacion["eventos_validos"]["RETARDO_LEVE"] ? 
                                Carbon::parse($evaluacion["eventos_validos"]["RETARDO_LEVE"]["fecha"])->format("H:i:s") : "" }}
                        </td>
                        <td>
                            {{ $evaluacion["eventos_validos"]["RETARDO_GRAVE"] ? 
                                Carbon::parse($evaluacion["eventos_validos"]["RETARDO_GRAVE"]["fecha"])->format("H:i:s") : "" }}
                        </td>
                        <td>
                            {{ $evaluacion["eventos_validos"]["SALIDA"] ? 
                                Carbon::parse($evaluacion["eventos_validos"]["SALIDA"]["fecha"])->format("H:i:s") : "" }}
                        </td>
                        <td>
                            @if ($evaluacion["horario"]) 
                                @if ($evaluacion["horario"]["salida"])
                                    {{ $evaluacion["horario"]["entrada"] }} - {{ $evaluacion["horario"]["salida"] }} 
                                @else 
                                    {{ $evaluacion["horario"]["entrada"] }} 
                                @endif
                            @endif
                        </td>
                        <td>
                            {{ str_replace("_", " ", $evaluacion["evaluacion_final"]) }}
                        </td>
                        <td>
                            @foreach ($evaluacion["incidencias"] as $incidencia)
                                {{ $incidencia["folio_autorizacion"] }} <br> 
                            @endforeach
                        </td>
                        <td>
                            @foreach ($evaluacion["incidencias"] as $incidencia)
                                {{ $incidencia["tipo_incidencia"]["tipo_justificacion"]["nombre"] }} <br> {{ $incidencia["tipo_incidencia"]["articulo"] }} <br>   
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection