@extends('layouts.pdf')

@php 
    use Carbon\Carbon;                            
@endphp 

@section('contenido')
    <div class="mb-6">
        <h4 class="text-center font-size-14 mt-0 mb-6"> EVENTOS DE ASISTENCIA PERIODO {{ Carbon::parse($fechaInicio)->format("d/m/Y") }} - {{ Carbon::parse($fechaFinal)->format("d/m/Y") }} </h4>
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
                    <th>HORARIO</th>
                    <th>EVENTOS</th>
                    <th>FOLIO <br> INCIDENCIA</strong></th>
                    <th>TIPO <br> INCIDENCIA</strong></th>
                    <th>EVALUACIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluaciones as $evaluacion)
                    <tr>
                        <td>
                            {{ Carbon::parse($evaluacion["fecha"])->format("d-m-Y") }} 
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
                            @foreach ($evaluacion["eventos"] as $evento)
                                {{ Carbon::parse($evento["fecha"])->format("H:i:s") }} <br>
                            @endforeach
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
                        <td>
                            {{ str_replace("_", " ", $evaluacion["evaluacion_final"]) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection