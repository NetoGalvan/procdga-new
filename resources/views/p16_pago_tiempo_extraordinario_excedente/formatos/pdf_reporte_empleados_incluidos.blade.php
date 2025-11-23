@extends('layouts.pdf')

@section("titulo")
    <h4 class="centrado"> REPORTE DE EMPLEADOS INCLUIDOS EN EL PAGO </h4>
@endsection

@section("contenido")
    <p>
        <b>Folio: </b>{{ $pago->folio }}
        <b>Tipo: </b>{{ $pago->tipo }} <br>
    </p>

    <table class="table table-bordered table-general letraCh td" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th class="td">Número empleado</th>
                <th class="td">Nombre empleado</th>
                <th class="td">Justificación</th>
                <th class="td">Hrs registradas</th>
                {{-- <th class="td">Hrs pagadas</th> --}}
            </tr>
        </thead>
        <tbody>
            @if (count($empleadosHoras) >= 1)
                @foreach ($empleadosHoras as $empleado)
                <tr>
                    <td class="centrado td">{{ $empleado->numero_empleado }}</td>
                    <td class="centrado td">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                    <td class="centrado td">{{ $empleado->observaciones }}</td>
                    <td class="centrado td">{{ $empleado->horas }}</td>
                    {{-- <td class="centrado td">---</td> --}}
                </tr>
                @endforeach
                    <tr>
                        <td colspan="3" class="derecha td">Total de horas: </td>
                        <td class="centrado td">{{ $total_horas }}</td>
                        {{-- <td class="centrado td">---</td> --}}
                    </tr>
            @else
                <tr>
                    <td colspan="5" class="centrado td">Sin registros</td>
                </tr>
            @endif
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
