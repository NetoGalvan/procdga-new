@extends('layouts.pdf')

@php 
    use Carbon\Carbon;                            
@endphp 

@section('contenido')
    <div class="mb-6">
        <h4 class="text-center font-size-14 mt-0 mb-6"> REPORTE DE FALTAS PERIODO {{ Carbon::parse($fechaInicio)->format("d/m/Y") }} - {{ Carbon::parse($fechaFinal)->format("d/m/Y") }} </h4>
    </div>
    @foreach ($unidadesEvaluaciones as $identificadorUnidad => $evaluaciones)
        <div class="table-responsive font-size-8">
            <table class="table table-sm table-bordered table-custom text-uppercase text-center">
                <thead class="thead-light">
                    <tr>
                        <th colspan="3"> {{ $unidadesAdministrativas[$identificadorUnidad]["nombre_completo"] }} </th>
                    </tr>
                    <tr>
                        <th>NOMBRE</th>
                        <th>NÚMERO DE EMPLEADO</th>
                        <th>FECHA DE FALTA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluaciones as $evaluacion)
                        <tr>
                            <td>
                                {{ $evaluacion->nombre_completo }}
                            </td>
                            <td>
                                {{ $evaluacion->numero_empleado }}
                            </td>
                            <td>
                                {{ $evaluacion->fecha }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection