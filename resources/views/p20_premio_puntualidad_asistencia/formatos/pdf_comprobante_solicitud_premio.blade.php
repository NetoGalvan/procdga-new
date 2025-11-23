@extends('layouts.pdf')

@section("titulo")
    <h4 class="centrado"> COMPROBANTE DE SOLICITUD DEL PREMIO DE PUNTUALIDAD Y ASISTENCIA </h4>
@endsection

@section("contenido")

    <table class="table table-bordered table-general" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th >FOLIO</th>
                <th >ÁREA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="centrado">{{ $empleado->folio }}</td>
                <td class="centrado">{{ $empleado->area_empleado }}</td>
            </tr>
        </tbody>
    </table> <br>
    <table class="table table-bordered table-general" style="width:100%">
        <thead>
            <tr bgcolor="#E6E6E6">
                <th >Número empleado</th>
                <th >Nombre completo</th>
                <th >Sección sindical</th>
                <th >Nivel salarial</th>
                <th >Período evaluado</th>
                <th >Quincena de pago</th>
            </tr>
        </thead>
        <tbody>
            <tr class="letraMe">
                <td class="centrado">{{ $empleado->numero_empleado }}</td>
                <td class="centrado">{{ $empleado->nombre_empleado }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                <td class="centrado">{{ $empleado->seccion_sindical }}</td>
                <td class="centrado">{{ $empleado->nivel_salarial }}</td>
                <td class="centrado">{{ $empleado->fecha_inicio_evaluacion }}</td>
                <td class="centrado">{{ $empleado->inscripcion->quincena }}</td>
            </tr>
        </tbody>
    </table> <br> <br> <br> <br> <br> <br> <br>
    <table style="width:100%">
        <tbody>
            <tr>
                <td class="centrado">______________________________________</td>
            </tr>
            <tr>
                <td class="centrado">Firma responsable</td>
            </tr>
        </tbody>
    </table>

@endsection

<style>

    .centrado{
        text-align: center;
    }
    .letraMe{
        font-size: 10;
    }
    .td {
      border: 1px solid black;
    }
</style>
