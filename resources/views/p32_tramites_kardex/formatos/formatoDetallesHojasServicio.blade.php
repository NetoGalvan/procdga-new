@extends('p32_tramites_kardex.formatos.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br>DETALLE(S) DE TRÁMITE KARDEX</h4>
@endsection

@section("contenido")

<div style="padding:15px;width:100%;margin-top:10px;">

    <p class="centrado letraTitulo">{{ mb_strtoupper($tramiteKardex->tipoTramiteKardex->nombre) }}</p>

    <div>
        <table class="letraMe" width="100%" style="border-collapse: collapse;">
            <tr>
                <td bgcolor="#BDBDBD" colspan="5" class="letraTitulo centrado" style="border: 1px solid black;">DATOS DEL TRABAJADOR</td>
            </tr>
            <tr>
                <td width="20%" style="border: 1px solid black;">{{ mb_strtoupper($tramiteKardex->apellido_paterno) }} </td>
                <td width="20%" style="border: 1px solid black;">{{ mb_strtoupper($tramiteKardex->apellido_materno) }} </td>
                <td width="20%" style="border: 1px solid black;">{{ mb_strtoupper($tramiteKardex->nombre) }} </td>
                <td width="20%" style="border: 1px solid black;">{{ $tramiteKardex->curp }} </td>
                <td width="20%" style="border: 1px solid black;">{{ $tramiteKardex->rfc }} </td>
            </tr>
            <tr>
                <td width="20%" style="border: 1px solid black;"> <b> APELLIDO PATERNO </b></td>
                <td width="20%" style="border: 1px solid black;"> <b> APELLIDO MATERNO </b></td>
                <td width="20%" style="border: 1px solid black;"> <b> NOMBRE </b></td>
                <td width="20%" style="border: 1px solid black;"> <b> CURP </b></td>
                <td width="20%" style="border: 1px solid black;"> <b> RFC </b></td>
            </tr>
        </table>


        <table class="letraMe" width="100%" style="border-collapse: collapse;">
            <tr>
                <td bgcolor="#BDBDBD" colspan="3" class="letraTitulo centrado" style="border: 1px solid black;">DOMICILIO COMPLETO</td>
            </tr>
            <tr>
                <td width="50%" style="border: 1px solid black;"><b>DOMICILIO:</b> {{ $tramiteKardex->calle }} NO. {{ $tramiteKardex->numero_exterior }} - {{ $tramiteKardex->numero_interior }}  COL. {{ $tramiteKardex->colonia }} CP. {{ $tramiteKardex->cp }}</td>
                <td width="25%" style="border: 1px solid black;"><b>CIUDAD:</b> {{ $tramiteKardex->ciudad }} </td>
                <td width="25%" style="border: 1px solid black;"><b>ESTADO:</b> {{ $tramiteKardex->entidad->nombre }}</td>
            </tr>
        </table>

        @php
            use Carbon\Carbon;
            $fechaAlta = $tramiteKardex->fecha_alta_empleado ? Carbon::parse($tramiteKardex->fecha_alta_empleado)->format('d-m-Y') : '';
            $fechaAltaLetra = $tramiteKardex->fecha_alta_empleado ? Carbon::parse($tramiteKardex->fecha_alta_empleado)->locale('es')->translatedFormat('l j \d\e F \d\e Y') : '';
            $fechaBaja = $tramiteKardex->fecha_baja_empleado ? Carbon::parse($tramiteKardex->fecha_baja_empleado)->format('d-m-Y') : '';
            $fechaBajaLetra = $tramiteKardex->fecha_baja_empleado ? Carbon::parse($tramiteKardex->fecha_baja_empleado)->locale('es')->translatedFormat('l j \d\e F \d\e Y') : '';
        @endphp
        <table class="letraMe" width="100%" style="border-collapse: collapse;">
            <tr>
                <td bgcolor="#BDBDBD" colspan="4" class="letraTitulo centrado" style="border: 1px solid black;">PERÍODO DE APORTACIONES AL FONDO DEL I.S.S.S.T.E</td>
            </tr>
            <tr>
                <td width="20%" style="border: 1px solid black;"><b>FECHA ALTA:</b>  {{ $fechaAlta }}</td>
                <td width="30%" style="border: 1px solid black;"><b>CON LETRA:</b> {{ mb_strtoupper($fechaAltaLetra) }} </td>
                <td width="20%" style="border: 1px solid black;"><b>FECHA BAJA:</b> {{ $fechaBaja }} </td>
                <td width="30%" style="border: 1px solid black;"><b>CON LETRA:</b> {{ mb_strtoupper($fechaBajaLetra) }} </td>
            </tr>
        </table>

        <table width="100%"  class="letraCh tablaContenido">
            <tr bgcolor="#BDBDBD" class="letraTitulo centrado" >
                <td class="td" colspan="12">MOTIVO Y PERIODO EN QUE OCURRIO LA(S) BAJA(S), LICENCIA(S) Y/O SUSPENSION(ES)</td>
            </tr>
            <tr bgcolor="#dddddd" class="centrado td">
                <td class="td" rowspan="2"> FOLIO </td>
                <td class="td" rowspan="2"> ELABORADO </td>
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
                <td class="td"> {{ $detalleBaja->folio }} </td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleBaja->fecha_elaboracion_tramite) ) }} </td>
                <td class="td"> {{ $detalleBaja->motivo_baja }} </td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleBaja->fecha_desde) ) }}</td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleBaja->fecha_hasta) ) }}</td>
                <td class="td" colspan="2"> {{ $detalleBaja->puesto . ', ' . $detalleBaja->codigo_puesto . ', ' . $detalleBaja->nivel_salarial }}</td>
                <td class="td"> {{ $detalleBaja->pagaduria }} </td>
                <td class="td"> {{ $detalleBaja->sueldo_cotizable }} </td>
                <td class="td"> {{ $detalleBaja->quinquenios }} </td>
                <td class="td"> {{ $detalleBaja->otras_percepciones }} </td>
                <td class="td"> {{ $detalleBaja->total }} </td>
            </tr>
            @endforeach
            <tr>
                <td class="td izquierda" colspan="12" >OBSERVACIONES: {{ $tramiteKardex->observaciones }} </td>
            </tr>
        </table>

    </div>
</div>

<br>
<br>
<br>

<div style="padding:15px;width:100%;margin-top:80px;">
    <div>
        <table width="100%"  class="letraCh tablaContenido">
            <tr bgcolor="#BDBDBD" class="letraTitulo centrado" >
                <td class="td" colspan="11" width="100%">PERCEPCIONES QUE APORTARON AL FONDO DEL ISSSTE</td>
            </tr>
            <tr bgcolor="#dddddd" class="centrado td">
                <td class="td" rowspan="2"> FOLIO </td>
                <td class="td" rowspan="2"> ELABORADO </td>
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
            @foreach ($detallesAportaciones as $detalleAportacion)
            <tr class="centrado">
                <td class="td"> {{ $detalleAportacion->folio }} </td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleAportacion->fecha_elaboracion_tramite) ) }} </td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleAportacion->fecha_desde) ) }}</td>
                <td class="td"> {{ date('d-m-Y', strtotime($detalleAportacion->fecha_hasta) ) }}</td>
                <td class="td" colspan="2"> {{ $detalleAportacion->puesto . ', ' . $detalleAportacion->codigo_puesto . ', ' . $detalleAportacion->nivel_salarial }}</td>
                <td class="td"> {{ $detalleAportacion->pagaduria }} </td>
                <td class="td"> {{ $detalleAportacion->sueldo_cotizable }} </td>
                <td class="td"> {{ $detalleAportacion->quinquenios }} </td>
                <td class="td"> {{ $detalleAportacion->otras_percepciones }} </td>
                <td class="td"> {{ $detalleAportacion->total }} </td>
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
            <td>
                VERIFICÓ <br>
                {{ isset($firmas) ? $firmas->usuario_verifico : '' }}
            </td>
            <td>
                AUTORIZÓ <br>
                {{ isset($firmas) ? $firmas->usuario_autorizo : '' }}
            </td>
            <td>
                SOLICITO <br>
                {{ isset($tramiteKardex->solicitante) ? $tramiteKardex->solicitante : '' }}
            </td>
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
