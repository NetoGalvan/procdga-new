@extends('layouts.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br></h4>
@endsection

@section("contenido")

<div style="padding:15px;width:100%;margin-top:20px;">

    <p class="centrado letraTitulo">CONCENTRADO DEL INCENTIVO AL SERVIDOR PUBLICO DEL MES (FORMATO B)</p>

    <div>
        <table class="letraMe" width="100%">
            <tr>
                <td bgcolor="#BDBDBD" colspan="3" class="letraTitulo centrado">DATOS DEL INCENTIVO</td>
            </tr>
            <tr>
                <td width="25%"><b>FOLIO:</b> {{ $incentivoEmpleadoMes->folio }} </td>
                <td width="50%"><b>QUINCENA DE PAGO:</b> {{ mb_strtoupper($incentivoEmpleadoMes->nombre_quincena) }} </td>
                <td width="25%"><b>DOCUMENTO:</b> {{ $incentivoEmpleadoMes->numero_documento }}</td>
            </tr>
        </table>

        <table width="100%"  class="letraMe tablaContenido">
            <tr bgcolor="#dddddd" class="centrado td">
                <td class="td" > ÁREA </td>
                <td class="td" > NUMERO EMPLEADO </td>
                <td class="td" > APELLIDO PATERNO </td>
                <td class="td" > APELLIDO MATERNO </td>
                <td class="td" > NOMBRE (S) </td>
                <td class="td" > SECCIÓN SINDICAL </td>
                <td class="td" > NIVEL SALARIAL </td>
                <td class="td" > PERIODO </td>
                <td class="td" > OBSERVACIONES </td>
            </tr>
            @foreach ($nominaEmpleados as $nominaEmpleado)
            <tr class="centrado">
                <td class="td"> {{ $nominaEmpleado->areaEmpleado->identificador }} - {{ $nominaEmpleado->areaEmpleado->nombre }} </td>
                <td class="td"> {{ $nominaEmpleado->numero_empleado }} </td>
                <td class="td"> {{ mb_strtoupper($nominaEmpleado->apellido_paterno) }} </td>
                <td class="td"> {{ mb_strtoupper($nominaEmpleado->apellido_materno) }} </td>
                <td class="td"> {{ mb_strtoupper($nominaEmpleado->nombre_empleado) }} </td>
                <td class="td"> {{ $nominaEmpleado->id_sindicato }} </td>
                <td class="td"> {{ $nominaEmpleado->nivel_salarial ? $nominaEmpleado->nivel_salarial : '' }} </td>
                <td class="td"> {{ mb_strtoupper($nominaEmpleado->nombre_mes) }} </td>
                <td class="td"> {{ $nominaEmpleado->comentarios_admin_incen }} </td>
            </tr>
            @endforeach
        </table>

    </div>
</div>

<br>
<br>

<div>
    <table width="100%"  class="letraMe tablaFirmas centrado" >
        <tr>
            <td>Elaboro</td>
            <td>Reviso</td>
            <td>Vo.Bo.</td>
            <td>Autorizo</td>
        </tr>
        <tr>
            <td> ________________________________ </td>
            <td> ________________________________ </td>
            <td> ________________________________ </td>
            <td> ________________________________ </td>
        </tr>
        {{-- <tr>
            <td> SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN </td>
            <td> SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN </td>
            <td> SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN </td>
            <td> DIRECCIÓN DE RECURSOS HUMANOS </td>
        </tr> --}}
    </table>
</div>



<style>
.centrado{
    text-align: center;
}
.izquierda{
    text-align: left;
}
.derecha{
    text-align: right;
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
    color : black;

}
.saltoPagina{
    page-break-after: always;
}

.tablaContenido{
    border: 1px solid black !important;
    border-collapse: collapse;
}
.tablaFirmas tr td{
    border-style: none;
}
.espacio{
    position: fixed;
}
.td {
    border: 1px solid black !important;
}

</style>

@endsection
