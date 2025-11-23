@extends('layouts.pdf')

@section('contenido')
<div style="font-family: Sans-serif;">
    <div class="mtn-100">
        <h4>
            REPORTE EJECUTIVO DIGITALIZACIÓN DE ARCHIVO
        </h4>
    </div>
    <br>

    <table class="table text-center table-bordered" width="100%">
        <thead class="font-size-13">
            <tr>
                <th colspan="2">DEL {{ $fechas[0] }} AL {{ $fechas[1] }}</th>
                <td colspan="2">CANTIDAD DE EXPEDIENTES: <b>{{ count($p23Indice) }}</b></td>
            </tr>
            <tr bgcolor="#E6E6E6">
                <th class="align-middle w-25">No. de expediente</th>
                <th class="align-middle w-25">Datos del empleado</th>
                <th class="align-middle w-25">Datos del expediente</th>
                <th class="align-middle w-25">Datos documento</th>
            </tr>
        </thead>
        <tbody class="font-size-12">
            @foreach($p23Indice as $indice)
            <tr>
                <td class="align-middle"> {{ $indice->numero_expediente }} </td>
                <td class="text-left align-middle">
                    <b>No. empleado:</b> {{ $indice->numero_empleado }} <br>
                    <b>Nombre empleado:</b> <br> {{ $indice->nombre_empleado_completo }} <br>
                    <b>RFC:</b> {{ $indice->rfc }}
                </td>
                <td class="text-left align-middle">
                    <b>Creado por:</b> <br> {{ $indice->creado_por_nombre }} <br>
                    <b>Fecha creación:</b> <br> {{ $indice->created_at }}
                </td>
                <td class="text-left align-middle">
                    <b>Nombre archivo:</b> <br> {{ $indice->digitalizacionFolio->nombre_archivo }} <br>
                    <b>Version:</b> {{ $indice->digitalizacionFolio->version }} <br>
                    <b>Fecha carga:</b> <br> {{ $indice->digitalizacionFolio->fecha_carga }} <br>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection