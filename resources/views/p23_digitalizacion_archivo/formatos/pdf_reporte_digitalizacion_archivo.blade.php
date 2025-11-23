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
        <thead class="font-size-14">
            <tr>
                <th colspan="5">DEL {{ $fechas[0] }} AL {{ $fechas[1] }}</th>
            </tr>
            <tr bgcolor="#E6E6E6">
                <th class="align-middle">No. de expediente</th>
                <th class="align-middle">No. de empleado</th>
                <th class="align-middle w-25">Nombre del empleado</th>
                <th class="align-middle w-25">Creado por</th>
                <th class="align-middle">Documento digitalizado</th>
            </tr>
        </thead>
        <tbody class="font-size-12">
            @foreach($p23Indice as $indice)
            <tr>
                <td class="align-middle">{{ $indice->numero_expediente }}</td>
                <td class="align-middle">{{ $indice->numero_empleado }}</td>
                <td class="text-left align-middle">{{ $indice->nombre_empleado_completo }}</td>
                <td class="text-left align-middle">{{ $indice->creado_por_nombre }}</td>
                <td class="align-middle">{{ (!is_null($indice->digitalizacionFolio->nombre_archivo)) ? 'Si' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection