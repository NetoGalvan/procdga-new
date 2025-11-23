@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="4" class="centrado letraMe"><b>DATOS DE LA CONVOCATORIA</b></td>
        </tr>
        <tr>
            <td ><b>FOLIO DEL PREMIO</b></td>
            <td ><b>CONVOCATORIA</b></td>
            <td ><b>FECHA INICIO</b></td>
            <td ><b>FECHA FIN</b></td>
        </tr>
        <tr>
            <td>{{ $datosPremio[0]->folio }}</td>
            <td>{{ $datosPremio[0]->anio_convocatoria }}</td>
            <td>{{ $datosPremio[0]->fecha_inicio_evaluacion_pa }}</td>
            <td>{{ $datosPremio[0]->fecha_fin_evaluacion_pa }}</td>
        </tr>
    </table>
    <p></p>
    <table {{-- class="letraCh" width="100%" --}} class="table table-bordered table-general letraCh" style="width:100%">
        <tr>
            @if ( $datosPremio[0]->comite_previo != null )
                <td bgcolor="#E6E6E6" colspan="8" class="centrado letraMe"><b>LISTA DE CANDIDATOS</b></td>
            @else
                <td bgcolor="#E6E6E6" colspan="6" class="centrado letraMe"><b>LISTA DE CANDIDATOS</b></td>
            @endif
        </tr>
        <tr>
            <td class="td centrado"><b>Número de empleado</b></td>
            <td class="td centrado"><b>Nombre</b></td>
            <td class="td centrado"><b>Puntaje</b></td>
            <td class="td centrado"><b>Premio</b></td>
            <td class="td centrado"><b>Estado de validación</b></td>
            <td class="td centrado"><b>Origen</b></td>
            @if ( $datosPremio[0]->comite_previo != null )
                <td class="td centrado"><b>Estatus inconformidad</b></td>
            @endif
            @if ( $datosPremio[0]->comite_previo != null )
                <td class="td centrado"><b>Razón</b></td>
            @endif
        </tr>
        @foreach ($empleados as $empleado)
            <tr>
                <td class="td centrado centrado">{{ $empleado->numero_empleado }}</td>
                <td class="td centrado">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                <td class="td centrado">
                    @if ( $datosPremio[0]->comite_previo != null )
                        {{ $empleado->puntaje_total_final }}%
                    @else
                        {{ $empleado->puntaje_total_inicial }}%
                    @endif
                </td>
                <td class="td centrado">
                    @if ( $datosPremio[0]->comite_previo != null )
                        {{ $empleado->premio_final }}
                    @else
                        {{ $empleado->premio_inicial }}
                    @endif
                </td>
                <td class="td centrado">{{ $empleado->estatus_origen }}</td>
                <td class="td centrado">{{ $empleado->estatus_tiempo }}</td>
                @if ( $datosPremio[0]->comite_previo != null )
                    <td class="td centrado">{{ $empleado->estatus_inconformidad }}</td>
                @endif
                @if ( $datosPremio[0]->comite_previo != null )
                    <td class="td centrado">{{ $empleado->comentarios_inconformidad }}</td>
                @endif
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
