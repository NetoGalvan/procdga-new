@extends('layouts.pdf')

@section("titulo")
    <h4 class="centrado"> REPORTE ELECTÓNICO DE PREMIO SEMESTRAL </h4>
@endsection

@section("contenido")
<p class="letraCh">{{ $premio->quincena }} </p>
<table class="table table-bordered table-general letraCh td" style="width:100%">
    <thead>
        <tr bgcolor="#E6E6E6">
            <td rowspan="2" class="centrado td">Nombre</td>
            <td rowspan="2" class="centrado td">Num empleado</td>
            <td rowspan="2" class="centrado td">Nivel</td>
            <td colspan="5" class="centrado td">Mes 1 </td>
            <td colspan="5" class="centrado td">Mes 2</td>
            <td colspan="5" class="centrado td">Mes 3</td>
            <td colspan="5" class="centrado td">Mes 4</td>
            <td colspan="5" class="centrado td">Mes 5</td>
            <td colspan="5" class="centrado td">Mes 6</td>
            <td rowspan="2" class="centrado td">Periodo</th>
            <tr bgcolor="#E6E6E6">
                <td class="td">RL</td>
                <td class="td">RG</td>
                <td class="td">F</td>
                <td class="td">P/R</td>
                <td class="td">INC</td>
                <td class="td">RL</td>
                <td class="td">RG</td>
                <td class="td">F</td>
                <td class="td">P/R</td>
                <td class="td">INC</td>
                <td class="td">RL</td>
                <td class="td">RG</td>
                <td class="td">F</td>
                <td class="td">P/R</td>
                <td class="td">INC</td>
                <td class="td">RL</td>
                <td class="td">RG</td>
                <td class="td">F</td>
                <td class="td">P/R</td>
                <td class="td">INC</td>
                <td class="td">RL</td>
                <td class="td">RG</td>
                <td class="td">F</td>
                <td class="td">P/R</td>
                <td class="td">INC</td>
                <td class="td">RL</td>
                <td class="td">RG</td>
                <td class="td">F</td>
                <td class="td">P/R</td>
                <td class="td">INC</td>
            </tr>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $empleado)
            <tr>
                <td class="centrado td">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                <td class="centrado td">{{ $empleado->numero_empleado }}</td>
                <td class="centrado td">{{ $empleado->nivel_salarial }}</td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td"> </td>
                <td class="centrado td">{{ $empleado->fecha_inicio_evaluacion }} - {{ $empleado->fecha_fin_evaluacion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p class="letraMe justificado">El que suscribe avala la asistencia de los trabajadores que se mencionan, por ser un reporte que emite el sistema para el control de asistencía automatizado PROCDGA, y acepta cualquier otro tipo de responsabilidad que se genere con el mismo o que se acredite que la infomación no es comprobable. </p>
<br> <br> <br>
<table class="letraMe" style="width:100%">
    <tbody>
        <tr>
            <td class="centrado">______________________________________</td>
        </tr>
        <tr>
            <td class="centrado">Firma Enlace</td>
        </tr>
    </tbody>
</table>
<p class="letraMe">RL = Retardo leve - RG = Retardo grave - F = Falta - P/R = Pago por retardo - INC = Incapacidad - OP. AÑO QNA = Quincena en la que se tramita </p>

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
        font-size: 3;
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
