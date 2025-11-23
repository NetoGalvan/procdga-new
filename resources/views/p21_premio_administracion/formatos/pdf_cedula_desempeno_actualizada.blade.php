@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

    <table class="letraMe " width="100%">
        <tr>
            <td ><b>NOMBRE DEL TRABAJADOR:</b></td>
            <td ><b>NÚMERO DE EMPLEADO</b></td>
            <td ><b>RFC</b></td>
        </tr>
        <tr>
            <td >{{ $datosDesempenio[0]->apellido_paterno }} {{ $datosDesempenio[0]->apellido_materno }} {{ $datosDesempenio[0]->nombre_empleado }}</td>
            <td >{{ $datosDesempenio[0]->numero_empleado }}</td>
            <td >{{ $datosDesempenio[0]->rfc }}</td>
        </tr>
    </table>
    <p></p>
    <table class="letra" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="2" class="centrado "><b>FACTORES DE DESEMPEÑO</b></td>
        </tr>
        <tr>
            <td class="td centrado" ><b>FACTOR</b></td>
            <td class="td centrado" ><b>DESEMPEÑO</b></td>
        </tr>
        @foreach ($datosDesempenioJson as $key => $value)
            <tr>
                <td class="td centrado">{{ $key }}</td>
                <td class="td centrado">{{ $value }}</td>
            </tr>
        @endforeach
    </table>
    <p class="derecha">
        Donde: <br>
        E: EXCELENTE <br>
        MB: MUY BIEN <br>
        B: BIEN <br>
        R: REGULAR <br>
        D: DEFICIENTE
    </p>

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
