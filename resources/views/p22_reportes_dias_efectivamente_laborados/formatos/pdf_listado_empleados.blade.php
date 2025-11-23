@extends('layouts.pdf')

@section("titulo")
    <h4 class="centrado"> LISTADO DE EMPLEADOS </h4>
@endsection

@section("contenido")

    <table class="" width="100%">
        <thead>
            <tr>
                <th class="">No.</th>
                <th class="">No. Empleado</th>
                <th class="">Nombre del empleado</th>
                <th class="">RFC</th>
                <th class="">Unidad administrativa</th>
                <th class="">Nivel salarial</th>
                <th class="">Sección sindical</th>
            </tr>
        </thead>
        <tbody>
            @forelse($empleados as $key => $empleado)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ $empleado->numero_empleado }}</td>
                    <td>{{ $empleado->nombre_completo }}</td>
                    <td>{{ $empleado->rfc }}</td>
                    <td>{{ $empleado->udAdministrativa->nombre }}</td>
                    <td>{{ $empleado->nivel_salarial }}</td>
                    <td>{{ $empleado->seccion_sindical }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Sin registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection