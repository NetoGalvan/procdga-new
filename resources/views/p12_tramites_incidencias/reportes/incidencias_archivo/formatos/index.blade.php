@extends('layouts.pdf')

@php
    use Carbon\Carbon;
@endphp

@section("contenido")
    <div>
        <h4 class="text-center font-size-14 mt-0 mb-6"> INCIDENCIAS PARA ARCHIVO PERIODO {{ $fechaInicio->format("d/m/Y") }} A {{ $fechaFinal->format("d/m/Y") }} </h4>
        <p class="font-size-14 mt-0 mb-0"> 
            <strong> ÁREA: </strong> {{ $area->identificador }} - {{ $area->nombre }}
        </p>
    </div>
    <div class="table-responsive font-size-8 mt-8">
        <table class="table table-bordered text-center text-uppercase">
            <thead class="thead-light">
                <tr>
                    <th>N° PROG</th>
                    <th>FOLIO AUTORIZACIÓN</th>
                    <th>NOMBRE</th>
                    <th>NÚMERO EMPLEADO</th>
                    <th>TIPO JUSTIFICACIÓN</th>
                    <th>FECHAS</th>
                    <th>FOLIO CANCELACIÓN</th>
                    <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidencias as $indice => $incidencia)
                    <tr>
                        <td>{{ $indice + 1 }}</td>
                        <td>{{ $incidencia->folio_autorizacion }}</td>
                        <td>{{ $incidencia->nombre_completo }}</td>
                        <td>{{ $incidencia->numero_empleado }}</td>
                        <td>{{ $incidencia->tipoIncidencia->tipoJustificacion->nombre }}</td>
                        <td>
                            <div class="text-nowrap">
                                @if ($incidencia->fecha_inicio == null)
                                    @foreach ($incidencia->fechas as $fecha)
                                        {{ Carbon::parse($fecha)->format("d-m-Y") }} <br>
                                    @endforeach
                                @else 
                                    <strong>Inicio:</strong> {{ Carbon::parse($incidencia->fecha_inicio)->format("d-m-Y") }} <br> 
                                    <strong>Final:</strong> {{ Carbon::parse($incidencia->fecha_final)->format("d-m-Y") }}
                                @endif
                            </div>
                        </td>
                        <td>{!! $incidencia->folio_cancelacion ?? "N/A" !!}</td>
                        <td>{{ $incidencia->observaciones_reporte ?? "N/A" }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive font-size-8 mt-8">
        <table class="table table-sm text-center font-size-10">
            <tr>
                <td style="padding: 20px; width: 33% !important; border: none;"> 
                </td>
                <td style="padding: 20px; width: 33% !important; border: none;"> 
                    ELABORÓ Y ENTREGÓ <br><br><br><br>
                    _________________________________ <br><br>
                    {{ auth()->user()->nombre_completo }} <br>
                    {{ auth()->user()->puesto }} 
                </td>
                <td style="padding: 20px; width: 33% !important; border: none;"> 
                </td>
            </tr>
        </table>
    </div>
@endsection