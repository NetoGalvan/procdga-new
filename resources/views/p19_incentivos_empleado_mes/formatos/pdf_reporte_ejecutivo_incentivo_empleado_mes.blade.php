@extends('layouts.pdf')

@section("titulo")
    {{-- <h4 class="centrado">  </h4> --}}
@endsection

@section("contenido")

    <table class="table table-bordered table-general letraCh td" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th class="td centrado">FOLIO</th>
                <th class="td centrado">QUINCENA</th>
                <th class="td centrado">ÁREA</th>
                <th class="td centrado">ESTATUS</th>
                <th class="td centrado">FECHAS INCENTIVO</th>
                <th class="td centrado">SUBPROCESO</th>
                <th class="td centrado">ESTATUS</th>
                <th class="td centrado">ÁREA</th>
                <th class="td centrado">EMPLEADOS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incentivos as $incentivo)
            @foreach ($incentivo->subprocesos as $index => $subproceso)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ count($incentivo->subprocesos) }}" class="td centrado">{{ $incentivo->folio }}</td>
                        <td rowspan="{{ count($incentivo->subprocesos) }}" class="td centrado">{{ $incentivo->nombre_quincena }}</td>
                        <td rowspan="{{ count($incentivo->subprocesos) }}" class="td centrado">{{ $incentivo->areaCreadora->identificador }} - {{ $incentivo->areaCreadora->nombre }}</td>
                        <td rowspan="{{ count($incentivo->subprocesos) }}" class="td centrado">{{ $incentivo->estatus }}</td>
                        <td rowspan="{{ count($incentivo->subprocesos) }}" class="td centrado">{{ $incentivo->fecha_inicio_pago }} - {{ $incentivo->fecha_fin_pago }}</td>
                    @endif
                    <td class="td centrado">{{ $subproceso->folio }}</td>
                    <td class="td centrado">{{ $subproceso->estatus }}</td>
                    <td class="td centrado">{{ $subproceso->area->identificador }} - {{ $subproceso->area->nombre }}</td>
                    <td class="td centrado">{{ count($subproceso->nominas) }}</td>
                </tr>
            @endforeach
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
