@extends('layouts.pdf')

@section("titulo")
    {{-- <h4 class="centrado">  </h4> --}}
@endsection

@section("contenido")

    <table class="table table-bordered table-general letraCh td" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th class="td centrado">FOLIO</th>
                <th class="td centrado">ÁREA</th>
                <th class="td centrado">QUINCENA</th>
                <th class="td centrado">ESTATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($premios as $premio)
                <tr>
                    <td width="15%" class="td centrado">{{ $premio->folio }}</td>
                    <td width="40%" class="td centrado">{{ $premio->area->identificador }} - {{ $premio->area->nombre }}</td>
                    <td width="30%" class="td centrado">{{ $premio->quincena }}</td>
                    <td width="15%" class="td centrado">{{ $premio->estatus }}</td>
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
