@extends('layouts.pdf')

@section("titulo")
    <h4 class="centrado"> REPORTE EJECUTIVO RELACIÓN DE PROCESOS </h4>
@endsection

@section("contenido")

    <table class="table table-bordered table-general letraCh td" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th class="centrado td">FOLIO</th>
                <th class="centrado td">ÁREA</th>
                <th class="centrado td">PERIODO</th>
                <th class="centrado td">ESTATUS</th>
                <th class="centrado td">TIPO</th>
                <th class="centrado td">FECHA LÍMITE</th>
                <th class="centrado td">NÚMERO DE EMPLEADOS </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $pago)
                <tr>
                    <td width="10%" class="centrado td">{{ $pago->folio }}</td>
                    <td width="30%" class="izquierda td">{{ $pago->area->identificador }} - {{ $pago->area->nombre }}</td>
                    <td width="30%" class="centrado td">{{ $pago->quincena }}</td>
                    <td width="10%" class="centrado td">{{ $pago->estatus }}</td>
                    <td width="10%" class="centrado td">{{ $pago->tipo }}</td>
                    <td width="15%" class="centrado td">{{ $pago->fecha_limite }}</td>
                    <td width="5%" class="centrado td">{{ $pago->total_horas_empleados }}</td>
                </tr>
            @endforeach
        </tbody>
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

    .tablaContenido{
        border-collapse: collapse;
    }

    .td {
      border: 1px solid black;
    }
</style>
