
@extends('layouts.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br> COMPROBANTE SOLICITUD DE SERVICIO </h4>
@endsection

@section("contenido")

<table class="table table-bordered table-general tablaContenido table-sm" style="width:100%">
    <thead>
        <tr>
            <td bgcolor="#E6E6E6" colspan="3" class="centrado letraCh td"><b>DATOS GENERALES</b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th class="centrado letraCh td">TIPO DE SERVICIO</th>
            <th class="centrado letraCh td">FOLIO</th>
            <th class="centrado letraCh td">ESTATUS</th>
        </tr>
        <tr>
            <td class="centrado letraCh td">{{ mb_strtoupper($servicioSolicitado->nombre_servicio_general) }}</td>
            <td class="centrado letraCh td">{{ $servicioSolicitado->folio }}</td>
            <td class="centrado letraCh td">{{ $servicioSolicitado->estatus == 'EN_PROCESO' ? 'EN PROCESO' : $servicioSolicitado->estatus }}</td>
        </tr>
        <tr>
            <th class="centrado letraCh td">ÁREA QUE SOLICITÓ</th>
            <th class="centrado letraCh td">FECHA DE LA SOLICITUD</th>
            <th class="centrado letraCh td">URGENTE</th>
        </tr>
        <tr>
            <td class="centrado letraCh td">{{ isset($servicioSolicitado->area->identificador) ? $servicioSolicitado->area->identificador . ' - ' . mb_strtoupper($servicioSolicitado->area->nombre) : mb_strtoupper($servicioSolicitado->nombre_area) }}</td>
            {{-- <td class="centrado letraCh td">{{ $servicio->area->identificador }} - {{ $servicio->area->nombre }}</td> --}}
            <td class="centrado letraCh td">{{ $servicioSolicitado->created_at }}</td>
            <td class="centrado letraCh td">
                @if ($servicioSolicitado->urgente == true)
                    {{"SI"}}
                @else
                    {{"NO"}}
                @endif
            </td>
        </tr>
    </tbody>
</table>
<br>
<table class="table table-bordered table-general tablaContenido table-sm" style="width:100%">
    <thead>
        <tr>
            <td bgcolor="#E6E6E6" colspan="2" class="centrado letraCh td"><b>DATOS DEL CONTACTO</b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th class="centrado letraCh td">NOMBRE</th>
            <th class="centrado letraCh td">SUBÁREA</th>
        </tr>
        <tr>
            <td class="centrado letraCh td">{{ mb_strtoupper($servicioSolicitado->contacto_servicio) }}</td>
            <td class="centrado letraCh td">{{ $servicioSolicitado->sub_area }}</td>
        </tr>
        <tr>
            <th class="centrado letraCh td">TELÉFONO</th>
            <th class="centrado letraCh td">DIRECCIÓN</th>
        </tr>
        <tr>
            <td class="centrado letraCh td">{{ $servicioSolicitado->telefono_servicio }}</td>
            <td class="centrado letraCh td">{{ $servicioSolicitado->direccion_servicio }}</td>
        </tr>
        <tr>
            <th colspan="2" class="centrado letraCh td">DESCRIPCIÓN DEL SERVICIO</th>
        </tr>
        <tr>
            <td colspan="2" class="centrado letraCh td">{!! $servicioSolicitado->texto_solicitud !!}</td>
        </tr>
    </tbody>
</table>
<br>
<table class="table table-bordered table-general tablaContenido table-sm" style="width:100%">
    <thead>
        <tr bgcolor="#E6E6E6">
            <th class="centrado letraCh td">TIPO DE SERVICIO</th>
            <th class="centrado letraCh td">DESCRIPCIÓN</th>
            <th class="centrado letraCh td">ESTATUS</th>
            <th class="centrado letraCh td">FECHA ESTIMADA</th>
            <th class="centrado letraCh td">FECHA REALIZADO</th>
            <th class="centrado letraCh td">UNIDAD</th>
        </tr>
    </thead>
    <tbody>
        @if (count($servicioSolicitado->detalles) > 0)
            @foreach ($servicioSolicitado->detalles as $detalle)
                <tr>
                    <td class="centrado letraCh td">{{ mb_strtoupper($detalle->nombre_servicio ? $detalle->nombre_servicio : $detalle->tipo_servicio ) }}</td>
                    <td class="centrado letraCh td">{{ $detalle->descripcion_servicio }}</td>
                    <td class="centrado letraCh td">{{ ($detalle->estatus_detalle == ' ' || $detalle->estatus_detalle == null || $detalle->estatus_detalle == 'undefined' ) ? 'PENDIENTE' : $detalle->estatus_detalle }}</td>
                    <td class="centrado letraCh td">{{ $detalle->fecha_estimada }}</td>
                    <td class="centrado letraCh td">{{ $detalle->fecha_entrega !== null ? $detalle->fecha_entrega : 'PENDIENTE' }}</td>
                    <td class="centrado letraCh td">{{ $detalle->unidad }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="centrado td">SIN REGISTROS</td>
            </tr>
        @endif
    </tbody>
</table>
<br>
@if ($servicioSolicitado->servicioGeneral->clave == 'telefonia')
    <div class="justificado">
        <p class="letraCh">
            <b>COMENTARIOS ADICIONALES:</b> {{ $servicioSolicitado->comentario_privado ? $servicioSolicitado->comentario_privado : 'NO HAY COMENTARIOS ADICIONALES' }}
        </p>
    </div>
@endif

@endsection

<style>
body{
    /*Alto, Derecha, Bajo, Izquierda*/
    margin: 5mm 8mm 15mm 8mm;
}
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
.letraSecretariaTitulo{
    font-size: 14;
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

.letraFirma{
    font-size: 7;
    word-wrap: break-word;
}

.saltoPagina{
    page-break-after: always;
}

.tablaContenido{
    border-collapse: collapse;
}

.tablaFirmas tr td{
    border-style: none;
}

.td {
  border: 1px solid black;
}

.imagenD
{
    margin-right:25px;
}

</style>
