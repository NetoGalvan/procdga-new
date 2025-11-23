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
            <td>{{ $datosPremio->folio }}</td>
            <td>{{ $datosPremio->anio_convocatoria }}</td>
            <td>{{ $datosPremio->fecha_inicio_evaluacion_pa }}</td>
            <td>{{ $datosPremio->fecha_fin_evaluacion_pa }}</td>
        </tr>
    </table>
    <p></p>
    <table {{-- class="letraCh" width="100%" --}} class="table table-bordered table-general letraCh" style="width:100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="5" class="centrado letraMe"><b>LISTA DE CANDIDATOS</b></td>
        </tr>
        <tr>
            <td class="td centrado"><b>Folio de inscripción</b></td>
            <td class="td centrado"><b>Número de empleado</b></td>
            <td class="td centrado"><b>Nombre</b></td>
            <td class="td centrado"><b>Estado</b></td>
            <td class="td centrado"><b>Razón</b></td>
        </tr>
        @foreach ($empleados as $empleado)
            <tr>
                <td class="td">{{ $empleado->folio_inscripcion }}</td>
                <td class="td centrado">{{ $empleado->numero_empleado }}</td>
                <td class="td">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                <td class="td centrado">{{ $empleado->estatus_declinacion }}</td>
                <td class="td">{{ $empleado->comentarios_declinacion }}</td>
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
