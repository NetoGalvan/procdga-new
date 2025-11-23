<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Proveedor</title>
    <style>
        body {
            margin-top: 4cm;
            margin-bottom: 1cm;
            margin-left: 2mm;
            margin-right: 2mm;
        }

        h3.titulo {
            font-weight: bold;
            font-family: sans-serif;
            text-align: center;
        }

        table.table {
            /* page-break-after: always; */
            width: 80%;
            font-family: sans-serif;
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }

        table.table th {
            background-color: #235B4E;
            color: white;
        }

        table.table tr:nth-child(even) {
            background-color: #d6d6d6;
        }

        table.table td {
            font-size: 13px;
            border-right: 1px solid black;
            border-left: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h3 class="titulo">Relacion de Personal Para el Pago de Tiempo Extraordinario de la quincena xxxxxxxxxxxxxxxxx</h3>
    <br>
    <table>
        <tbody>
            <tr>
                <th colspan="2" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Total de Horas</th>
                <td colspan="1" style="text-align: center; border: .1px solid #00000000;">{{ $empleados->sum('horas') }}</td>
                <td colspan="12"></td>
                <th colspan="5" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Importe Total Aplicado en Tiempo Extraordinario</th>
                <td colspan="1" style="text-align: center; border: .1px solid #00000000;">{{ $empleados->sum('monto_bruto') }}</td>
            </tr>
            <tr>
                <th colspan="2" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Total de Personas</th>
                <td colspan="1" style="text-align: center; border: .1px solid #00000000;">{{ count($empleados) }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th colspan="1" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">#</th>
                <th colspan="2" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">#Empleado</th>
                <th colspan="4" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Nombre del Empleado</th>
                <th colspan="2" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Horas</th>
                <th colspan="2" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Nivel Salarial</th>
                <th colspan="2" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Monto Bruto</th>
                <th colspan="4" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Área</th>
                <th colspan="4" style="border: .1px solid #00000000; font-weight: bold; text-align: center;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $key => $empleado)
            <tr>
                <td colspan="1" style="text-align: center; border: .1px solid #00000000;">{{ $key+1 }}</td>
                <td colspan="2" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->user->numero_empleado }}</td>
                <td colspan="4" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->user->nombre.' '.$empleado->user->apellido_paterno.' '.$empleado->user->apellido_materno }}</td>
                <td colspan="2" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->horas }}</td>
                <td colspan="2" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->user->plazas[0]->nivelSalarial->identificador }}</td>
                <td colspan="2" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->monto_bruto }}</td>
                <td colspan="4" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->user->area->nombre }}</td>
                <td colspan="4" style="text-align: center; border: .1px solid #00000000;">{{ $empleado->observaciones }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br><br><br><br>
    <table>
        <tbody>
            <tr>
                <td colspan="5"></td>
                <td colspan="11" style="text-align: center;">
                    <p>{{ auth()->user()->nombre.' '.auth()->user()->apellido_paterno .' '.auth()->user()->apellido_materno }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="11" style="border-top: .1px solid #00000000; text-align: center;">
                    <p>NOMBRE Y FIRMA DE QUIEN AUTORIZA</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
