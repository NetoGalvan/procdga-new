@extends('p32_tramites_kardex.formatos.pdf')

@section("titulo")
    <h4><br>DETALLE(S) DE TRÁMITE KARDEX </h4>
@endsection

@section("contenido")

<div style="padding:15px;width:100%;margin-top:10px;">

    <p class="centrado letraTitulo">{{ mb_strtoupper($tramiteKardex->tipoTramiteKardex->nombre) }}</p>

    <div>
        <table class="letraMe" width="100%">
            <tr>
                <td colspan="4" style="text-align: center;"><b>TRÁMITE:</b> </td>
                <td colspan="4" style="text-align: center;">{{ $camposExtra->tramite }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>NOMBRE:</b></td>
                <td colspan="4" style="text-align: center;">{{ $tramiteKardex->nombre }} {{ $tramiteKardex->apellido_paterno }} {{ $tramiteKardex->apellido_materno }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>EMPLEO:</b> </td>
                <td colspan="4" style="text-align: center;">{{ $tramiteKardex->puesto }} </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>ADSCRIPCIÓN:</b></td>
                <td colspan="4" style="text-align: center;">{{ isset($tramiteKardex->unidad_administrativa_nombre) ? mb_strtoupper($tramiteKardex->unidad_administrativa_nombre) : '' }} </td>
            </tr>
        </table>

        <p class="letraSecretaria justificado">
            DE CONFORMIDAD CON SU SOLICITUD MANIFIESTO QUE SEGÚN LOS DATOS DEL REGISTRO GENERAL SE ENCUENTRA USTED PRESTANDO
            SUS SERVICIOS DESDE {{ $tramiteKardex->fecha_alta_empleado }}
        </p>

        <table class="letraMe" width="100%">
            <tr>
                <td colspan="4" style="text-align: center;"><b>NÚMERO DE EMPLEADO:</b> </td>
                <td colspan="4" style="text-align: center;">{{ $tramiteKardex->numero_empleado }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>RFC:</b></td>
                <td colspan="4" style="text-align: center;">{{ $tramiteKardex->rfc }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>CURP:</b> </td>
                <td colspan="4" style="text-align: center;">{{ $tramiteKardex->curp }} </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>SUELDO:</b></td>
                <td colspan="4" style="text-align: center;">${{ number_format($camposExtra->sueldo_total, 2, '.', '') }} MENSUAL</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>PRIMA QUINCENAL MENSUAL:</b></td>
                <td colspan="4" style="text-align: center;">${{ number_format($camposExtra->prima_quincenal, 2, '.', '') }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b>DOMICILIO:</b></td>
                <td colspan="4" style="text-align: center;">
                    {{ $tramiteKardex->calle }} {{ $tramiteKardex->numero_exterior }},
                    {{ $tramiteKardex->colonia }}, {{ $tramiteKardex->ciudad }}, {{ $tramiteKardex->municipio_alcaldia }},
                    {{ $tramiteKardex->cp }}, {{ isset($tramiteKardex->entidad->nombre) ? $tramiteKardex->entidad->nombre : '' }}
                </td>
            </tr>
        </table>

        {{-- <table width="100%"  class="letraCh tablaContenido">
            <tr class="letraTitulo centrado" bgcolor="#BDBDBD">
                <td class="td" >FOLIO</td>
                <td class="td" >FECHA DE INICIO</td>
                <td class="td" >FECHA DE TERMINO</td>
                <td class="td" >COMENTARIO</td>
            </tr>

            @foreach ($detallesKardex as $detalle)
                <tr class="centrado">
                    <td width="20%" class="td">{{$detalle->folio}}</td>
                    <td width="15%" class="td">{{$detalle->fecha_detalle_inicio}}</td>
                    <td width="15%" class="td">{{$detalle->fecha_detalle_termino}}</td>
                    <td width="50%" class="td">{{$detalle->comentario}}</td>
                </tr>
            @endforeach
        </table> --}}

        <br>
        <br>
        <br>

        <table width="100%"  class="letraMe tablaFirmas centrado" >
            <tr>
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
            </tr>
        </table>

    </div>
</div>


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

.tablaContenido{
    border-collapse: collapse;
}

.td {
  border: 1px solid black;
}
</style>
