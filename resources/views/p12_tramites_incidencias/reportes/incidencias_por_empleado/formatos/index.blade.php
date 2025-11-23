@extends('layouts.pdf')

@php 
    use Carbon\Carbon;                            
@endphp 

@section("contenido")
    <div class="mb-6">
        <h4 class="text-center font-size-14 mt-0 mb-6"> INCIDENCIAS DEL EMPLEADO PERIODO {{ Carbon::parse($fechaInicio)->format("d/m/Y") }} - {{ Carbon::parse($fechaFinal)->format("d/m/Y") }} </h4>
        <p class="font-size-14 mt-0 mb-0"> 
            <strong> NOMBRE: </strong> {{ $empleado->nombre_completo }} <br>
            <strong> RFC: </strong> {{ $empleado->rfc }} <br>
            <strong> NÚMERO DE EMPLEADO: </strong> {{ $empleado->numero_empleado }} <br>
            <strong> UNIDAD ADMINISTRATIVA: </strong> {{ $empleado->unidad_administrativa }} - {{ $empleado->unidad_administrativa_nombre }}
        </p>
    </div>
    <div class="table-responsive font-size-8">
        <table class="table table-bordered text-center text-uppercase">
            <thead class="thead-light">
                <tr>
                    <th>FOLIO AUTORIZACIÓN</th>
                    <th>FECHAS</th>
                    <th>TOTAL DÍAS</th>
                    <th>TIPO JUSTIFICACIÓN</th>
                    <th>ARTÍCULO</th>
                    <th>DESCRIPCIÓN</th>
                    {{-- <th>FOLIO CANCELACIÓN</th> --}}
                    <th>OBSERVACIONES</th>
                    <th>ESTATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidenciasEmpleado as $incidencia)
                    <tr>
                        <td>{{ $incidencia->folio_autorizacion }}</td>
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
                        <td>{{ $incidencia->total_dias }}</td>
                        <td>{{ $incidencia->tipoIncidencia->tipoJustificacion->nombre }}</td>
                        <td>{{ $incidencia->tipoIncidencia->articulo }}</td>
                        <td>{!! $incidencia->tipoIncidencia->descripcion ?? "N/A" !!}</td>
                        {{-- <td>{!! $incidencia->folio_cancelacion ?? "N/A" !!}</td> --}}
                        <td>{{ $incidencia->observaciones_reporte ?? "N/A" }}</td>
                        <td>{{ $incidencia->estatus }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
