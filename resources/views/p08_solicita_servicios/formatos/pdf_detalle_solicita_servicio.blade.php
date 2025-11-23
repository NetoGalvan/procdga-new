@extends('layouts.pdf')

@section("titulo")
{{-- <h4 class="centrado"> DETALLE DE LA SOLICITUD DEL SERVICIO </h4>a --}}
@endsection

@section("contenido")

    <table class="table table-bordered table-general tablaContenido table-sm" style="width:100%">
        <thead>
            <tr>
                <td bgcolor="#E6E6E6" colspan="2" class="centrado letraCh td"><b>DATOS GENERALES</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="centrado letraCh td">TIPO DE SERVICIO</th>
                <th class="centrado letraCh td">FOLIO</th>
            </tr>
            <tr>
                <td class="centrado letraCh td">{{ mb_strtoupper($servicio->nombre_servicio_general) }}</td>
                <td class="centrado letraCh td">{{ $servicio->folio }}</td>
            </tr>
            <tr>
                <th class="centrado letraCh td">ÁREA QUE SOLICITÓ</th>
                <th class="centrado letraCh td">FECHA DE LA SOLICITUD</th>
            </tr>
            <tr>
                <td class="centrado letraCh td">{{ $servicio->area->identificador }} - {{ $servicio->area->nombre }}</td>
                <td class="centrado letraCh td">{{ $servicio->created_at }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-general tablaContenido  table-sm" style="width:100%">
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
                <td class="centrado letraCh td">{{ mb_strtoupper($servicio->contacto_servicio) }}</td>
                <td class="centrado letraCh td">{{ $servicio->sub_area }}</td>
            </tr>
            <tr>
                <th class="centrado letraCh td">TELÉFONO</th>
                <th class="centrado letraCh td">DIRECCIÓN</th>
            </tr>
            <tr>
                <td class="centrado letraCh td">{{ $servicio->telefono_servicio }}</td>
                <td class="centrado letraCh td">{{ $servicio->direccion_servicio }}</td>
            </tr>
            <tr>
                <th colspan="2" class="centrado letraCh td">DESCRIPCIÓN DEL SERVICIO</th>
            </tr>
            <tr>
                <td colspan="2" class="centrado letraCh td">{!! $servicio->texto_solicitud !!}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-general tablaContenido  table-sm" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th class="centrado letraCh td">TIPO DE SERVICIO</th>
                <th class="centrado letraCh td">DESCRIPCIÓN</th>
                <th class="centrado letraCh td">UNIDAD</th>
                <th class="centrado letraCh td">FECHA REALIZADO</th>
            </tr>
        </thead>
        <tbody>
            @if (count($servicio->detalles) > 0)
                @foreach ($servicio->detalles as $detalle)
                    <tr>
                        <td class="centrado letraCh td">{{ mb_strtoupper($detalle->nombre_servicio ? $detalle->nombre_servicio : $detalle->tipo_servicio ) }}</td>
                        <td class="centrado letraCh td">{{ $detalle->descripcion_servicio }}</td>
                        <td class="centrado letraCh td">{{ $detalle->unidad }}</td>
                        <td class="centrado letraCh td"></td>
                    </tr>
                @endforeach
                <tr>
                    <th class="centrado letraCh td">OBSERVACIONES:</th>
                    <td colspan="3" class="td"></td>
                </tr>
            @else
                <tr>
                    <td colspan="4" class="centrado td">SIN REGISTROS</td>
                </tr>
            @endif
        </tbody>
    </table>
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
