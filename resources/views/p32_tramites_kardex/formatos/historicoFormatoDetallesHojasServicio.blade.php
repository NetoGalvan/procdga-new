@extends('p32_tramites_kardex.formatos.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br>DETALLE(S) DE HOJAS DE SERVICIO</h4>
@endsection

@section("contenido")

<div style="padding:15px;width:100%;margin-top:10px;">

    <p class="centrado letraTitulo">DETALLE(S) DE HOJAS DE SERVICIO</p>

    <div>
        <table class="letraMe" width="100%">
            <tr>
                <td bgcolor="#BDBDBD" colspan="3" class="letraTitulo centrado">DATOS DEL TRABAJADOR</td>
            </tr>
            <tr>
                <td width="33%"><b>NOMBRE:</b> {{ mb_strtoupper($hojaServicio->nombre_empleado) }} {{ mb_strtoupper($hojaServicio->apellido_paterno) }} {{ mb_strtoupper($hojaServicio->apellido_materno) }} </td>
                <td width="33%"><b>NÚMERO DE EMPLEADO:</b> {{ $hojaServicio->numero_empleado }}</td>
                <td width="33%"><b>RFC:</b> {{ $hojaServicio->rfc }} </td>
            </tr>
            <tr>
                <td width="33%"><b>CURP:</b> {{ $hojaServicio->curp }} </td>
                <td  width="33%"><b>FECHA DE INGRESO:</b> {{ date('d-m-Y', strtotime($hojaServicio->fecha_ingreso)) }} </td>
            </tr>
        </table>

        <table class="letraMe" width="100%">
            <tr>
                <td bgcolor="#BDBDBD" colspan="3" class="letraTitulo centrado">DOMICILIO COMPLETO</td>
            </tr>
            <tr>
                <td width="50%"><b>DOMICILIO:</b> {{ $hojaServicio->calle }} NO. {{ $hojaServicio->numero_exterior }} - {{ $hojaServicio->numero_interior }}  COL. {{ $hojaServicio->colonia }} CP. {{ $hojaServicio->cp }}</td>
                <td width="25%"><b>CIUDAD:</b> {{ $hojaServicio->ciudad }} </td>
                <td width="25%"><b>ESTADO:</b> {{ $hojaServicio->entidad }}</td>
            </tr>
        </table>

        <table width="100%"  class="letraMe tablaContenido">
            <tr bgcolor="#BDBDBD" class="letraTitulo centrado" >
                <td class="td" colspan="10" width="100%">MOTIVO Y PERIODO EN QUE OCURRIO LA(S) BAJA(S), LICENCIA(S) Y/O SUSPENSION(ES)</td>
            </tr>
            <tr bgcolor="#dddddd" class="centrado td">
                <td class="td" rowspan="2"> MOTIVO </td>
                <td class="td" colspan="2"> PERIODO </td>
                <td class="td" rowspan="2" colspan="2">PUESTO <p>(nombre, código y nivel)</p></td>
                <td class="td">PAGADURIA</td>
                <td class="td" rowspan="2">SUELDO COTIZABLE</td>
                <td class="td" rowspan="2">QUINQUENIOS</td>
                <td class="td" rowspan="2">OTRAS PERCEPCIONES</td>
                <td class="td" rowspan="2">TOTAL</td>
            </tr>
            <tr bgcolor="#dddddd" class="centrado td">
                <td class="td">DEL</td>
                <td class="td">AL</td>
                <td class="td">(registrada ante el ISSSTE)</td>
            </tr>
            @foreach ($detallesBajas as $detalleBaja)
            <tr class="centrado">
                <td class="td"> {{ $detalleBaja->motivo_baja }} </td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleBaja->fecha_desde) ) }}</td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleBaja->fecha_hasta) ) }}</td>
                <td class="td" colspan="2"> {{ $detalleBaja->nombre_puesto . ', ' . $detalleBaja->codigo_puesto . ', ' . $detalleBaja->nivel_puesto }}</td>
                <td class="td"> {{ $detalleBaja->pagaduria }} </td>
                <td class="td"> {{ $detalleBaja->sueldo_cotizable }} </td>
                <td class="td"> {{ $detalleBaja->quinquenios }} </td>
                <td class="td"> {{ $detalleBaja->otras_percepciones }} </td>
                <td class="td"> {{ $detalleBaja->sueldo_cotizable + $detalleBaja->quinquenios + $detalleBaja->otras_percepciones }} </td>
            </tr>
            @endforeach
            <tr>
                <td class="td izquierda" colspan="10">OBSERVACIONES: {{ $hojaServicio->observaciones }} </td>
            </tr>
        </table>

    </div>
</div>

<br>
<br>
<br>

<div style="padding:15px;width:100%;margin-top:80px;">
    <div>
        <table width="100%"  class="letraMe tablaContenido">
            <tr bgcolor="#BDBDBD" class="letraTitulo centrado" >
                <td class="td" colspan="9" width="100%">PERCEPCIONES QUE APORTARON AL FONDO DEL ISSSTE</td>
            </tr>
            <tr bgcolor="#dddddd" class="centrado td">
                <td class="td" colspan="2"> PERIODO </td>
                <td class="td" colspan="2" rowspan="2">PUESTO <p>(nombre, código y nivel)</p></td>
                <td class="td">PAGADURIA</td>
                <td class="td" rowspan="2">SUELDO COTIZABLE</td>
                <td class="td" rowspan="2">QUINQUENIOS</td>
                <td class="td" rowspan="2">OTRAS PERCEPCIONES</td>
                <td class="td" rowspan="2">TOTAL</td>
            </tr>
            <tr bgcolor="#dddddd" class="centrado">
                <td class="td">DEL</td>
                <td class="td">AL</td>
                <td class="td">(registrada ante el ISSSTE)</td>
            </tr>
            @foreach ($detallesAportacion as $detalleAportacion)
            <tr class="centrado">
                <td class="td"> {{ date('d-m-Y', strtotime($detalleAportacion->fecha_desde) ) }}</td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleAportacion->fecha_hasta) ) }}</td>
                <td class="td" colspan="2"> {{ $detalleAportacion->nombre_puesto . ', ' . $detalleAportacion->codigo_puesto . ', ' . $detalleAportacion->nivel_puesto }}</td>
                <td class="td"> {{ $detalleAportacion->pagaduria }} </td>
                <td class="td"> {{ $detalleAportacion->sueldo_cotizable }} </td>
                <td class="td"> {{ $detalleAportacion->quinquenios }} </td>
                <td class="td"> {{ $detalleAportacion->otras_percepciones }} </td>
                <td class="td"> {{ $detalleAportacion->sueldo_cotizable + $detalleAportacion->quinquenios + $detalleAportacion->otras_percepciones }} </td>
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
            <td> ________________________________ </td>
            <td> ________________________________ </td>
            <td> ________________________________ </td>
        </tr>
        <tr>
            <td>VERIFICÓ</td>
            <td>AUTORIZÓ</td>
            <td>SOLICITO</td>
        </tr>
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
    font-size: 8;
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
