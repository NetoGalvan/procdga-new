@extends('layouts.pdf')

@section("contenido")
    <p class="text-right font-size-12 m-0"><b>{{ $movimientoPersonal->folio }}</b></p>
    <p class="text-center font-size-16 m-0 mt-4"><b>DOCUMENTO ALIMENTARIO DE PERSONAL</b></p>
    <p class="text-center font-size-16 m-0 mt-4"><b>{{ $movimientoPersonal->tipoMovimiento->descripcion }}</b></p>
    <div class="mt-4">
        <table class="table table-sm table-bordered font-size-12">
            <tr> 
                <td colspan="3" class="table-active"> DATOS GENERALES </td>
            </tr>
            <tr>
                <td colspan="3">Código de Movimiento: <span class="border-dark border-bottom">{{ $movimientoPersonal->tipoMovimiento->codigo }} {{ $movimientoPersonal->tipoMovimiento->descripcion }}</span></td>
            </tr>
            <tr>
                <td colspan="2">Núm. Plaza: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_plaza }}</span></td>
                <td colspan="1">ID Sociedad: <span class="border-dark border-bottom">{{ $movimientoPersonal->sociedad_id }}</span></td>
            </tr>
            <tr>
                <td colspan="3">Unidad Administrativa: <span class="border-dark border-bottom">{{ $movimientoPersonal->area->identificador }} {{ $movimientoPersonal->area->nombre }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Número Empleado: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_empleado }}</span></td>
                <td colspan="2">Nombre del Empleado: <span class="border-dark border-bottom">{{ $movimientoPersonal->nombre_empleado }} {{ $movimientoPersonal->apellido_paterno }} {{ $movimientoPersonal->apellido_materno }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Código de Puesto: <span class="border-dark border-bottom">{{ $movimientoPersonal->codigo_puesto }}</span></td>
                <td colspan="1">Nivel: <span class="border-dark border-bottom">{{ $movimientoPersonal->nivel_salarial }}</span></td>
                <td colspan="1">Universo: <span class="border-dark border-bottom">{{ $movimientoPersonal->codigo_universo }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Fecha inicio: <span class="border-dark border-bottom">{{ $movimientoPersonal->fecha_alta }}</span></td>
                <td colspan="2">Fecha fin: <span class="border-dark border-bottom">{{ $movimientoPersonal->fecha_fin }}</span></td>
            </tr>
        </table>
        <table class="table table-sm table-bordered font-size-12">
            <tr> 
                <td colspan="4" class="table-active"> ELABORACIÓN </td>
            </tr>
            <tr class="text-center">
                <td colspan="1" class="w-25">FECHA DE ELABORACIÓN:</td>
                <td colspan="2" class="w-25">PROCESADO:</td>
                <td colspan="1" class="w-50">USUARIO INICIADOR DE PROCESO:</td>
            </tr>
            <tr class="text-center">
                <td class="align-middle">{{ $movimientoPersonal->fecha_elaboracion }}</td>
                <td class="align-middle">AÑO: <br> {{ $movimientoPersonal->anio_procesado }}</td>
                <td class="align-middle">QUINCENA: <br> {{ $movimientoPersonal->qna_procesado }}</td>
                <td class="align-middle">
                    {{ mb_strtoupper($movimientoPersonal->usuarioIniciador->nombre_completo) }} <br>
                    {{ mb_strtoupper($movimientoPersonal->usuarioIniciador->puesto) }} <br>
                    {{ mb_strtoupper($movimientoPersonal->usuarioIniciador->nombre_area) }}
                </td>
            </tr>
        </table>
        <table class="table table-sm table-bordered font-size-12">
            <tr class="text-center">
                <td class="h-20"></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td class="w-50"> 
                    NOMBRE Y FIRMA <br>
                    {{ $movimientoPersonal->usuarioTitular->puesto }} <br>
                    {{ $movimientoPersonal->usuarioTitular->nombre_completo }} <br>
                </td>
                <td class="w-50"> 
                    AUTORIZACIÓN DE MOVIMIENTO <br>
                    {{ $movimientoPersonal->usuarioAutorizador->puesto }} <br>
                    {{ $movimientoPersonal->usuarioAutorizador->nombre_completo }}  <br>
                </td>
            </tr>
        </table>
    </div>
@endsection
    