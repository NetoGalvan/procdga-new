@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="5" class="centrado letraMe"><b>REPORTE EJECUTIVO DE PREMIOS DE ADMINISTRACIÓN</b></td>
        </tr>
        <tr bgcolor="#E6E6E6">
            <th class="td" ><b>FOLIO</b></th>
            <th class="td" ><b>FECHA CONVOCATORIA</b></th>
            <th class="td" ><b>UNIDAD ADMINISTRATIVA</b></th>
            <th class="td" ><b>ESTATUS</b></th>
            <th class="td" ><b>PREMIOS</b></th>
        </tr>
        @foreach ($premios as $premio)
            <tr>
                <td class="td centrado">{{ $premio->folio }}</td>
                <td class="td centrado">{{ $premio->anio_convocatoria }}</td>
                <td class="td">{{ $premio->area->identificador }} - {{ $premio->area->nombre }}</td>
                <td class="td centrado">
                    @if ( $premio->estatus == 'COMPLETADO')
                        COMPLETADA
                    @elseif ($premio->estatus == 'PREMATURAMENTE_FINALIZADO')
                        CANCELADA
                    @elseif ($premio->work_status == 'EN_PROCESO')
                        EN PROCESO
                    @endif
                </td>
                <td class="td centrado">
                    {{ count($premio->candidatosPremio) }}
                </td>
            </tr>
        @endforeach
    </table>

@endsection

<style>
.justificado{
    text-align: justify;
}

.centrado{
    text-align: center;
}

.derecha{
    text-align: right
}

.izquierda{
    text-align: left;
}

.letraCh{
    font-size: 9;
}

.letraMe{
    font-size: 10;
}

.letraSecretaria{
    font-size: 11;
}

.letraTitulo{
    font-size: 12;
}

.letraLeyenda{
    font-size: 8;
}

.letraTabla{
    font-size: 8;
}

.saltoPagina{
    page-break-before: always;
}

header {
    /*Para la hoja horizontal*/
    /* position: fixed;
    left: 0px;
    top: -30px;
    right: 0px;
    height: 100px;
    text-align: center; */

    position: fixed;
    left: 25px;
    top: -25px;
    right: 0px;
    height: 100px;
    text-align: center;
}

body{
    /*Alto, Derecha, Bajo, Izquierda*/
    margin: 5mm 8mm 15mm 8mm;
}



footer {
    /* Para la hoja horizontal */
    /* position: fixed;
    left: 100px;
    bottom: -15px;
    right: 0px;
    height: 45px;
    text-align: center; */

    position: fixed;
    left: 45px;
    bottom: -15px;
    right: 0px;
    height: 45px;
    text-align: center;
}

.imagen {
    right: 30px;
}

.tablaContenido{
    border-collapse: collapse;
}

.td {
    border: 1px solid black;
}

.colapsado {
    border-collapse: collapse;
}

.color {
    color: #C8C6C5;
}

.fuente {
  font: Arial, 10;
}

table {
	border-collapse: collapse;
}

@page {
		margin-left: 0.2cm;
		margin-right: 1.5cm;
}

</style>
