@extends('layouts.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4 class="centrado">COMPROBANTE DE SOLICITUD DEL PREMIO DE INCENTIVO AL SERVIDOR PUBLICO DEL MES<br></h4>
    <div class="derecha">
        <p> {{$fechaCompleta}} </p>
    </div>
@endsection

@section("contenido")

<div style="padding:15px;width:100%;margin-top:50px;">
    <table width="100%"  class="letraMe">
        <tr class="centrado">
            <td><b>FOLIO</b></td>
            <td><b>ÁREA</b></td>
            <td><b>SUB ÁREA</b></td>
        </tr>
        <tr class="centrado">
            <td width="33%">{{ $empleadoNomina->folio }}</td>
            <td width="33%">{{ $empleadoNomina->area }}</td>
            <td width="33%">{{ $empleadoNomina->sub_area }}</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table width="100%"  class="letraMe tableBorder justificado">
        <tr class="centrado">
            <td class="td-border"><b>No. Empleado</b></td>
            <td class="td-border"><b>Nombre</b></td>
            <td class="td-border"><b>Área</b></td>
            <td class="td-border"><b>Sección sindical</b></td>
            <td class="td-border"><b>Nivel Salarial</b></td>
            <td class="td-border"><b>Periodo evaluado</b></td>
            <td class="td-border"><b>Quincena de pago</b></td>
        </tr>
        <tr class="centrado">
            <td class="td-border">{{ $empleadoNomina->numero_empleado }}</td>
            <td class="td-border">{{ mb_strtoupper($empleadoNomina->nombre_empleado) }} {{ mb_strtoupper($empleadoNomina->apellido_paterno) }} {{ mb_strtoupper($empleadoNomina->apellido_materno) }}</td>
            <td class="td-border">{{ $empleadoNomina->area }}</td>
            <td class="td-border">{{ $empleadoNomina->id_sindicato }}</td>
            <td class="td-border">{{ $empleadoNomina->nivel_salarial ? $empleadoNomina->nivel_salarial : '' }}</td>
            <td class="td-border">{{ date('d-m-Y', strtotime($empleadoNomina->fecha_inicio_evaluacion) ) }} a {{ date('d-m-Y', strtotime($empleadoNomina->fecha_fin_evaluacion) ) }}</td>
            <td class="td-border">{{ $empleadoNomina->subproceso->nombre_quincena }}</td>
        </tr>
    </table>

</div>
<br>
<br>
<br>
<div>
    <table width="100%"  class="letraMe tablaFirmas centrado" >
        <tr class="centrado">
            <td> ________________________________ </td>
        </tr>
        <tr class="centrado">
            <td> {{ $enlace->nombre }} {{ $enlace->apellido_paterno }} {{ $enlace->apellido_materno }}</td>
        </tr>
        <tr class="centrado">
            <td> {{ $enlace->puesto }} </td>
        </tr>
    </table>
</div>

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

.letraExtraCh{
    font-size: 6;
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

div.saltoPagina{
    display: block; /* unhide all tabs */
    break-before: always;
    page-break-before: always;
}

.tablaContenido{
    border-collapse: collapse;
}

.td {
  border: 1px solid black;
}

.tableBorder {
  border: 1px solid black;
  border-collapse: collapse;
}

.td-border {
  border: 1px solid black;
  border-collapse: collapse;
}

.tablaFirmas tr td{
    border-style: none;
}

.m-t {
  margin-top: 50px;
}

th.cal {
  height: 30px;
  background-color: #E5E7E9;
}
td.cal {
  height: 80px;
  width: 100px;
  vertical-align: top;
}


</style>

@endsection

