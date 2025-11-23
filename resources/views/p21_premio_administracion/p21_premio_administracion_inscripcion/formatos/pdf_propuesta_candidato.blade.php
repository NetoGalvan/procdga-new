@extends('layouts.pdf')

@section("titulo")
    <h4> PROPUESTA DE CANDIDATO A PARTICIPAR EN EL OTORGAMIENTO DE ESTIMULOS Y RECOMPENSAS </h4>
@endsection

@section("contenido")

    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="3" class="centrado letraMe">DATOS DEL CANDIDATO</td>
        </tr>
        <tr>
            <td ><b>APELLIDO PATERNO</b></td>
            <td ><b>APELLIDO MATERNO</b></td>
            <td ><b>NOMBRE (S)</b></td>
        </tr>
        <tr>
            <td>{{ $datosEmpleado->apellido_paterno }}</td>
            <td>{{ $datosEmpleado->apellido_materno }}</td>
            <td>{{ $datosEmpleado->nombre }}</td>
        </tr>
        <tr>
            <td ><b>RFC</b></td>
            <td ><b>NIVEL SALARIAL</b></td>
            <td ><b>FECHA DE INGRESO</b></td>
        </tr>
        <tr>
            <td>{{ $datosEmpleado->rfc }}</td>
            <td>{{ $datosEmpleado->nivel_salarial }}</td>
            <td>{{ $datosEmpleado->fecha_alta_empleado }}</td>
        </tr>
        <tr>
            <td ><b>PUESTO O FUNCIÓN REAL</b></td>
        </tr>
        <tr>
            <td>{{ $datosEmpleado->puesto }}</td>
        </tr>
    </table>
    <p></p>
    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="6" class="centrado letraMe">TIPOS DE NOMBRAMIENTO</td>
        </tr>
        <tr>
            <td class="derecha"><label  >BASE</label></td>
            <td class="td"><label class="titulo-dato" style="color:white;">AAA</label></td>
            <td class="derecha"><label class="" >LISTA DE RAYA BASE</label></td>
            <td class="td"><label class="titulo-dato" style="color:white;">AAA</label></td>
            <td class="derecha"><label class="" >CONFIANZA</label></td>
            <td class="td"><label class="titulo-dato" style="color:white;">AAA</label></td>
        </tr>
    </table>
    <p></p>
    <table class="letraCh" width="100%">
        <tr>
            <td class=""><label  >UNIDAD ADMINISTRATIVA DE ADSCRIPCION</label></td>
            <td class=""><label class="" >DOMICILIO DEL CENTRO DE TRABAJO</label></td>
        </tr>
        <tr>
            <td class="td" width="50%" height="20"><label class=""></label></td>
            <td class="td" width="50%" height="20"><label class=""></label></td>
        </tr>
        <tr>
            <td class=""><label  >TELEFONO</label></td>
            <td class=""><label class="" >EXT</label></td>
        </tr>
        <tr>
            <td class="td" width="50%" height="15"></td>
            <td class="td" width="50%" height="15"></td>
        </tr>
    </table>
    <p></p>
    <table class="letraCh" width="100%">
        <tr>
            <td bgcolor="#E6E6E6" colspan="4" class="centrado letraMe">PROPUESTO POR</td>
        </tr>
        <tr>
            <td class=""><label  >SUPERIOR JERÁRQUICO</label></td>
            <td class="td" width="20%" height="15"><label class=""></label></td>
            <td class=""><label class="" >COMPAÑEROS DE LABORES</label></td>
            <td class="td" width="20%" height="15"><label class=""></label></td>
        </tr>
        <tr>
            <td class=""><label>REPRESENTANTES SINDICALES</label></td>
            <td class="td" width="20%" height="15"><label class=""></label></td>
            <td class=""><label class="" >AUTOPROPUESTA</label></td>
            <td class="td" width="20%" height="15"><label class=""></label></td>
        </tr>
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
    page-break-after: always;
}

header {
    position: fixed;
    left: 0px;
    top: 0px;
    right: 0px;
    height: 100px;
    text-align: center;
}

footer {
    position: fixed;
    left: 0px;
    bottom: -15px;
    right: 0px;
    height: 45px;
    text-align: center;
}

.tablaContenido{
    border-collapse: collapse;
}

.td {
  border: 1px solid black;
}

body{
    /*Alto, Derecha, Bajo, Izquierda*/
    margin: 5mm 8mm 15mm 8mm;
}
</style>
