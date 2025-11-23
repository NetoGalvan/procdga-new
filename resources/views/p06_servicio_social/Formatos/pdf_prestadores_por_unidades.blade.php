@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

<div style="font-family: Sans-serif;">
    <div class="mtn-100">
        <h3>REPORTE EJECUTIVO DE PRESTADORES DE SERVICIO SOCIAL <br> Y PRACTICAS PROFESIONALES</h3>
    </div>
    <br>
    <table class="table table-bordered text-center" width="95%">
        <thead class="font-size-14">
            <tr bgcolor="#E6E6E6">
                <th rowspan="2" class="align-middle">UNIDAD ADMINISTRATIVA</th>
                <th rowspan="2" class="align-middle">PRESTADOR</th>
                <th rowspan="2" class="align-middle">FOLIO</th>
                <th rowspan="2" class="align-middle">TIPO DE PRESTADOR</th>
                <th rowspan="2" class="align-middle">ESCUELA</th>
                <th rowspan="2" class="align-middle">ESTATUS</th>
                <th colspan="2">FECHAS</th>
            </tr>
            <tr bgcolor="#E6E6E6">
                <th>SERVICIO</th>
                <th>CARTAS</th>
            </tr>
        </thead>
        <tbody class="font-size-12">
            @foreach ($servicioSocial as $info)
                <tr>
                    <td class="align-middle text-left">
                        {{ mb_strtoupper($info->nombre_unidad_administrativa) }} 
                    </td>
                    <td class="align-middle text-left">
                        {{ mb_strtoupper($info->nombre_prestador_completo) }}
                    </td>
                    <td class="align-middle">{{ $info->folio }}</td>
                    <td class="align-middle">
                        {{ isset($info->tipo_prestador) 
                            ? mb_strtoupper($info->tipo_prestador) 
                            : mb_strtoupper($info->prestador->tipo_prestador) 
                        }}
                    </td>
                    <td class="align-middle text-left">
                        {{ isset($info->nombre_escuela)
                            ? mb_strtoupper($info->nombre_escuela)
                            : mb_strtoupper($info->prestador->escuela->nombre_escuela) 
                        }}
                    </td>
                    <td class="align-middle">
                        @if ( isset($info->work_status) )
                            {{ $estatus[$info->work_status] }}
                        @elseif ( $info->prestador->estatus_prestador == 'EN_CURSO' || $info->prestador->estatus_prestador == 'EN_PROCESO')
                            {{ $estatus[$info->prestador->estatus_prestador] }}
                        @else    
                            {{ $info->prestador->estatus_prestador }}
                        @endif
                    </td>
                    
                    <td class="align-middle">
                        <b>Inicio: </b> <br> 
                        {{ date_format(Carbon\Carbon::parse($info->fecha_inicio), 'd/m/Y') }} <br>
                        <b>Fin: </b> <br> 
                        {{ date_format(Carbon\Carbon::parse($info->fecha_fin), 'd/m/Y') }}
                    </td>
                    <td class="align-middle">
                        <b>Inicio: </b><br> 
                        {{ date_format(Carbon\Carbon::parse($info->fecha_carta_inicio), 'd/m/Y') }} <br>
                        <b>Termino: </b><br>
                        @if ($info->fecha_carta_fin !== null)
                            {{ date_format(Carbon\Carbon::parse($info->fecha_carta_fin), 'd/m/Y') }}
                        @else
                            Aún no se genera
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection