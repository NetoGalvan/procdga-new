@extends('layouts.pdf')

@section('contenido')
<div style="font-family: Sans-serif;">
    <div class="mtn-100">
        <h4>
            REPORTE EJECUTIVO DIGITALIZACIÓN DE ARCHIVO <br> DETALLE DE EXPEDIENTE DIGITAL
        </h4>
    </div>
    <br>
    <table class="table text-center table-bordered" width="100%">
        <thead class="font-size-14">
            <tr bgcolor="#E6E6E6"><th colspan="4"> E X P E D I E N T E </th></tr>
        </thead>
        <tbody class="font-size-13">
            <tr>
                <td class="align-middle w-25">
                    <b>Nombre:</b> <br> {{ $p23Digitalizacion->nombre_empleado_completo }}
                </td>
                <td class="align-middle w-25">
                    <b>No. empleado:</b> <br> {{ $p23Digitalizacion->numero_empleado }}
                </td>
                <td class="align-middle w-25">
                    <b>RFC:</b> <br> {{ $p23Digitalizacion->rfc }}
                </td>
                <td class="align-middle w-25">
                    <b>Folio:</b> <br> {{ $p23Digitalizacion->folio }}
                </td>
            </tr>
            <tr>
                <td class="align-middle">
                    <b>Última modificación:</b> <br> {{ $p23Digitalizacion->updated_at }}
                </td>
                <td class="align-middle">
                    <b>Versión digital:</b> <br> {{ $p23Digitalizacion->version }}
                </td>
                <td class="align-middle">
                    <b>No. expediente:</b> <br> {{ $p23Digitalizacion->numero_expediente }}
                </td>
                <td class="align-middle">
                    <b>Archivo digitalizado:</b> <br> {{ (!is_null($p23Digitalizacion->nombre_archivo)) ? 'Si' : 'No' }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table text-center table-bordered" width="100%">
        <thead class="font-size-14">
            <tr><th colspan="3"> D E T A L L E S </th></tr>
            <tr bgcolor="#E6E6E6">
                <th> TIPO </th>
                <th> HOJAS </th>
                <th> CAPTURADO POR </th>
            </tr>
        </thead>
        <tbody class="font-size-12">
            @foreach($p23DetalleDig as $descirpcion)
            <tr>
                <td class="text-left">
                    {{ $descirpcion->documento }}
                </td>
                <td>
                    {{ $descirpcion->hojas }}
                </td>
                <td class="text-left">
                    {{ $descirpcion->creado_por_nombre }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection