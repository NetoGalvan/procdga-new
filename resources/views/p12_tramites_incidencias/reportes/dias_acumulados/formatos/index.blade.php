@extends('layouts.pdf')

@php
    use Carbon\Carbon;
@endphp

@section("contenido")
    <div class="mb-6">
        <h4 class="text-center font-size-14 mt-0 mb-6"> DÍAS ACUMULADOS POR TIPO DE INCIDENCIA PERIODO {{ Carbon::parse($fechaInicio)->format("d/m/Y") }} - {{ Carbon::parse($fechaFinal)->format("d/m/Y") }} </h4>
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
                    <th>TIPO JUSTIFICACIÓN</th>
                    <th>ARTÍCULO</th>
                    <th>SUBARTÍCULO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>TOTAL DÍAS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDiasGlobal = 0;
                @endphp
                @foreach ($incidenciasEmpleado as $tipoJustificacion)
                    @php
                        $totalDiasGlobal += $tipoJustificacion["dias_acumulados"];
                    @endphp
                    <tr>
                        <td>{{ $tipoJustificacion["tipo_justificacion"] }}</td>
                        <td>{{ $tipoJustificacion["articulo"] }}</td>
                        <td>{!! $tipoJustificacion["subarticulo"] ?? "N/A" !!}</td>
                        <td>{{ $tipoJustificacion["descripcion"] }}</td>
                        <td>{{ $tipoJustificacion["dias_acumulados"] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total de dias justificados</strong></td>
                        <td>{{ $totalDiasGlobal }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
@endsection
