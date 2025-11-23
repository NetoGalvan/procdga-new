@extends('p32_tramites_kardex.formatos.pdf')

@section("titulo")
    <h4><br>DETALLE(S) DE COMPROBANTES DE SERVICIO </h4>
@endsection

@section("contenido")

<div style="padding:15px;width:100%;margin-top:10px;">

    <p class="centrado letraTitulo">DETALLE(S) DE COMPROBANTES DE SERVICIO</p>

    <div>
        <table class="letraMe" width="100%">
            <tr class="letraTitulo centrado">
                <td bgcolor="#BDBDBD" colspan="3" class="td">Datos Generales</td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td width="50%"><b>Tramite:</b> {{ $comprobanteServicio->tramite }}</td>
                <td width="50%"><b>Nombre:</b> {{ $comprobanteServicio->nombre_empleado }} {{ $comprobanteServicio->primer_apellido }} {{ $comprobanteServicio->segundo_apellido }}</td>
                <td width="50%"><b>RFC:</b> {{ $comprobanteServicio->rfc }} </td>
            </tr>
            <tr>
                <td width="50%"><b>Empleo:</b> {{ $comprobanteServicio->denominacion_puesto }}</td>
                <td width="50%"><b>Número de empleado:</b> {{ $comprobanteServicio->numero_empleado }}</td>
                <td width="50%"><b>Adscripción:</b> {{ $comprobanteServicio->adscripcion }} </td>
            </tr>
            <tr>
                <td width="50%"><b>Sueldo:</b> ${{ number_format($comprobanteServicio->sueldo_total, 2) }} Mensual</td>
                <td width="50%" colspan="2"><b>Prima Quincenal Mensual:</b> ${{ number_format($comprobanteServicio->prima, 2) }}</td>
            </tr>
            <tr>
                <td width="50%" colspan="3"><b>Domicilio actual:</b> {{ $comprobanteServicio->calle }} {{ $comprobanteServicio->numero_exterior }},
                    {{ $comprobanteServicio->colonia }}, {{ $comprobanteServicio->ciudad }}, {{ isset($comprobanteServicio->municipio_alcaldia) ? $comprobanteServicio->municipio_alcaldia : $comprobanteServicio->mpio_delegacion }},
                    {{ $comprobanteServicio->cp }}, {{ $entidad ? $entidad : $comprobanteServicio->entidad->nombre }}</td>
            </tr>
        </table>

        <p class="letraSecretaria justificado">
            DE CONFORMIDAD CON SU SOLICITUD MANIFIESTO QUE SEGÚN LOS DATOS DEL REGISTRO GENERAL SE ENCUENTRA USTED PRESTANDO
            SERVICIOS DESDE EL:
        </p>

        <table width="100%"  class="letraMe tablaContenido" id="tablapdf">
            <tr class="letraTitulo centrado" bgcolor="#BDBDBD">
                <td class="td" >Fecha</td>
                <td class="td" >Trayectoria Laboral</td>
                <td class="td" >Comentario</td>
            </tr>
    
            @if (count($comprobanteServicio->detalles) === 0)
                <tr class="centrado">
                    <td colspan="3" class="td centrado">
                        Sin registros
                    </td>
                </tr>
            @else
                @foreach ($comprobanteServicio->detalles as $dt)
                    <tr>
                        <td width="20%" class="td centrado">{{$dt->fecha_detalle}}</td>
                        <td width="40%" class="td">{{$dt->trayectoria_laboral}}</td>
                        <td width="40%" class="td">{{$dt->comentario_detalle}}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        <br>
        <br>
        <br>

        <table width="100%"  class="letraMe tablaFirmas centrado" >
            <tr>
                <td> ________________________________ </td>
                <td> ________________________________ </td>
            </tr>
            <tr>
                <td>VERIFICÓ</td>
                <td>AUTORIZÓ</td>
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
