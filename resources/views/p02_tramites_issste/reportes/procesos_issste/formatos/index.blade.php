@extends('layouts.pdf')

@section("header")
    <p class="text-right font-size-12 mb-0"><b></b></p>
@endsection

@section("titulo")
    <h4><br> REPORTE EJECUTIVO DE PROCESOS P02 ISSSTE</h4>
@endsection

@section("contenido")
    <div style="padding:15px;width:100%;margin-top:80px;">
        <div>
            <table width="100%"  class="letraMe tablaContenido" id="tablapdf">
                <tr class="letraTitulo centrado" bgcolor="#BDBDBD">
                    <td class="td" width="50%" >Folio</td>
                    <td class="td" width="50%">Fecha</td>
                </tr>
                @foreach ($procesosISSSTE as $registro)
                <tr>
                    <td class="td centrado">{{ $registro->folio }}</td>
                    <td class="td centrado">{{ $registro->created_at }}</td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>

    <style>
        .centrado{
            text-align: center;
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
            color : black;

        }
        .saltoPagina{
            page-break-after: always;
        }

        .tablaContenido{
            border-collapse: collapse;
        }

        .mt-Tabla{
            margin-top: 200px;
        }
        .mb-Tabla{
            margin-bottom: 200px;
        }
        .td {
          border: 1px solid black;
        }

    </style>

@endsection
