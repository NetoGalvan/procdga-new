@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

    <table class="letraCh " width="100%">
        <tr>
            <td ><b>NOMBRE DEL TRABAJADOR:</b></td>
            <td ><b>NÚMERO DE EMPLEADO</b></td>
            <td ><b>RFC</b></td>
        </tr>
        <tr>
            <td >{{ $datosCursos[0]->apellido_paterno }} {{ $datosCursos[0]->apellido_materno }} {{ $datosCursos[0]->nombre_empleado }}</td>
            <td >{{ $datosCursos[0]->numero_empleado }}</td>
            <td >{{ $datosCursos[0]->rfc }}</td>
        </tr>
    </table>
    <p></p>
    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="5" class="centrado letraMe"><b></b></td>
        </tr>
        <tr>
            <td class="td centrado" ><b>NOMBRE CURSO</b></td>
            <td class="td centrado" ><b>APLICACIÓN</b></td>
            <td class="td centrado" ><b>COMENTARIOS OPER_PA</b></td>
            <td class="td centrado" ><b>ESTADO</b></td>
            <td class="td centrado" ><b>COMENTARIO</b></td>
        </tr>
        @foreach ($datosCursosJson as $curso)
            <tr>
                <td class="td centrado">{{ $curso->nombre_curso }}</td>
                <td class="td centrado">{{ $curso->aplicacion }}</td>
                <td class="td centrado">{{ $curso->comentarios_oper_pa }}</td>
                <td class="td centrado">{{ $curso->estado }}</td>
                <td class="td centrado">{{ $curso->comentario }}</td>
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
