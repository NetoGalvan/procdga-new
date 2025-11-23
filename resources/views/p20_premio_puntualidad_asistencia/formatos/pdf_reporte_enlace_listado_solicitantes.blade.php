@extends('layouts.pdf')

@section("titulo")
    <h4 class="centrado"> LISTADO DE SOLICITANTES PARA EL PREMIO DE PUNTUALIDAD Y ASISTENCIA </h4>
@endsection

@section("contenido")

    Quincena: {{ $premio->quincena }}
    <p></p>
    <table class="table table-bordered table-general letraCh td" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th class="td centrado">Folio Premio</th>
                <th class="td centrado">Folio Inscripción</th>
                <th class="td centrado">Número empleado</th>
                <th class="td centrado">Nombre</th>
                <th class="td centrado">Área</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td width="20%" class="td centrado">{{ $empleado->folio_premio }}</td>
                    <td width="20%" class="td centrado">{{ $empleado->folio }}</td>
                    <td width="10%" class="td centrado">{{ $empleado->numero_empleado }}</td>
                    <td width="30%" class="td centrado">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                    <td width="10%" class="td centrado">{{ $empleado->areaPremio->area->identificador }} - {{ $empleado->areaPremio->area->nombre }}</td>
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
