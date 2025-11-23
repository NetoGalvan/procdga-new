@extends('layouts.pdf')

@section("titulo")
    <h4> SISTEMA DE EVALUACIÓN DEL DESEMPEÑO - LISTADO DE CANDIDATOS A ESTÍMULOS Y RECOMPENSAS </h4>
@endsection

@section("contenido")

    <table class="letraCh" width="100%">
        <tr bgcolor="#E6E6E6">
            <th class="td">NOMBRE DE LA UNIDAD ADMINISTRATIVA</th>
            <th class="td">FOLIO</th>
            <th class="td">AÑO DE LA CONVOCATORIA</th>
        </tr>
        <tr>
            <td class="td centrado">{{ $premio->area->identificador }} - {{ $premio->area->nombre }}</td>
            <td class="td centrado">{{ $premio->folio }}</td>
            <td class="td centrado">{{ $premio->anio_convocatoria }}</td>
        </tr>
        <tr bgcolor="#E6E6E6">
            <th class="td centrado" colspan="3">PERSONAL ADSCRITO A LA DEPENDENCIA - TOTAL: {{ count($premio->candidatosPremio) }} </th>
        </tr>
    </table>
    <p></p>
    <table class="letraCh" width="100%">
        <tr bgcolor="#E6E6E6">
            <th class="td" ><b>No. DE EMPLEADO</b></th>
            <th class="td" ><b>NOMBRE DEL TRABAJADOR</b></th>
            <th class="td" ><b>GANADOR DE</b></th>
            <th class="td" ><b>PUNTAJE OBTENIDO EN LA EVALUACIÓN</b></th>
            <th class="td" ><b>OBSERVACIONES</b></th>
            <th class="td" ><b>ORIGEN DEL CANDIDATO / PROPUESTO POR</b></th>
            <th class="td" ><b>PUNTUALIDAD DE INSCRIPCIÓN</b></th>
            <th class="td" ><b>SOLICITUD DE PREMIO</b></th>
            <th class="td" ><b>CONFORMIDAD DE RESULTADO</b></th>
        </tr>
        @foreach ($empleados as $empleado)
            <tr>
                <td class="td centrado">{{ $empleado->numero_empleado }}</td>
                <td class="td centrado">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                <td class="td centrado">{{ $empleado->premio_final }}</td>
                <td class="td centrado">{{ $empleado->puntaje_total_final }}</td>
                <td class="td centrado">{{ $empleado->observaciones }}</td>
                <td class="td centrado">{{ $empleado->estatus_origen }} / {{ $empleado->propuesto_por }}</td>
                <td class="td centrado">{{ $empleado->estatus_tiempo }}</td>
                <td class="td centrado">{{ $empleado->estatus_declinacion }}</td>
                <td class="td centrado">{{ $empleado->estatus_inconformidad }}</td>
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

.distanciaDerecha {
  margin-right: 20px;
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
