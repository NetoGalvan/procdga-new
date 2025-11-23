@extends('layouts.pdf')

@section("contenido")
<div style="font-family: Sans-serif;">
    <div class="mtn-100">
        <h4>REPORTE EJECUTIVO DE CONTRAPRESTACIÓN <br> DE PRESTADORES <br> DE SERVICIO SOCIAL Y/O PRACTICAS PROFESIONALES <br> DEL AÑO {{ $anio }}</h4>
    </div>
    <div class="text-center">
        
    @if( $user->hasRole("SUB_EA") )

    <table class="table table-bordered text-center w-100">
        <thead class="font-size-11">
            <tr bgcolor="#E6E6E6">
                <th class="align-middle" width="18%">FOLIO</th>
                <th class="align-middle" width="29%">DESCRIPCIÓN</th>
                <th class="align-middle" width="12%">TIPO DE NOMINA</th>
                <th class="align-middle" width="14%">FECHA DE CREACIÓN</th>
                <th class="align-middle" width="14%">FECHA DE CIERRE</th>
                <th class="align-middle" width="12%">TOTAL DE PRESTADORES</th>
            </tr>
        </thead>
        <tbody class="font-size-11">
            @foreach ($datosNominas as $nomina)
            <tr>
                <td class="align-middle">{{ $nomina->folio }}</td>
                <td class="align-middle text-left">{{ mb_strtoupper($nomina->descripcion) }}</td>
                <td class="align-middle">{{ mb_strtoupper($nomina->tipo_validacion) }}</td>
                <td class="align-middle">{{ date_format($nomina->fecha_creacion, 'd/m/Y') }}</td>
                <td class="align-middle">
                    {{ 
                        date_format(\Carbon\Carbon::parse($nomina->nominaDetalle->first()->fecha_cerrado ?? $nomina->fecha_cerrado), 'd/m/Y') 
                    }}
                </td>
                <td class="align-middle font-size-12"> <b> {{ count($nomina->nominaDetalle) }} </b> </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @elseif($user->hasRole("PROG_SS") || $user->hasRole("SUPER_ADMIN"))

        @foreach ($datosNominas as $nomina)
        <!-- BEGIN::Tabla con los Datos generales de la Nomina -->
        <table class="table table-bordered text-center w-100">
            <thead class="font-size-11">
                <tr bgcolor="#E6E6E6">
                    <th class="align-middle" width="18%">FOLIO</th>
                    <th class="align-middle" width="29%">DESCRIPCIÓN</th>
                    <th class="align-middle" width="12%">TIPO DE NOMINA</th>
                    <th class="align-middle" width="14%">FECHA DE CREACIÓN</th>
                    <th class="align-middle" width="14%">FECHA DE CIERRE</th>
                    <th class="align-middle" width="12%">TOTAL DE PRESTADORES</th>
                </tr>
            </thead>
            <tbody class="font-size-11">
                <tr>
                    <td class="align-middle">{{ $nomina->folio }}</td>
                    <td class="align-middle text-left">{{ mb_strtoupper($nomina->descripcion) }}</td>
                    <td class="align-middle">{{ mb_strtoupper($nomina->tipo_validacion) }}</td>
                    <td class="align-middle">{{ date_format($nomina->fecha_creacion, 'd/m/Y') }}</td>
                    <td class="align-middle">
                        {{ 
                            date_format(\Carbon\Carbon::parse($nomina->nominaDetalle->first()->fecha_cerrado ?? $nomina->fecha_cerrado), 'd/m/Y') 
                        }}
                    </td>
                    <td class="align-middle font-size-12"> <b> {{ count($nomina->nominaDetalle) }} </b> </td>
                </tr>
            </tbody>
        </table>
        <!-- END::Tabla con los Datos generales de la Nomina -->
        <!-- BEGIN::Tabla conteo de prestadores por unidad administrativa -->
        <table class="table table-bordered text-center mtn-20">
            <thead class="font-size-11">
                <tr bgcolor="#E6E6E6">
                    <th colspan="{{count($areas)}}" class="align-middle">PRESTADORES POR UNIDAD ADMINISTRATIVA</th>
                </tr>
                <tr bgcolor="#E6E6E6">
                    @foreach($areas as $area)
                    <th class="font-size-11">{{$area->identificador}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="font-size-11">
                <tr>
                    @foreach($areas as $area)
                    <td class="align-middle"> 
                    {{  ( !is_null($nomina->nominaDetalle->first()->id_p06) ) 
                        ? count(\App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoServicioSocial::whereIn('id_p06', $nomina->nominaDetalle->pluck('id_p06'))
                                                                                                          ->where('id_unidad_administrativa', $area->identificador)
                                                                                                          ->get() )
                        : count(App\Models\p06_servicio_social\P06ServicioSocial::whereIn('nomina_id', $nomina->nominaDetalle->pluck('nomina_id'))
                                                                                ->whereHas('area', function ($q) use ($area) { 
                                                                                    $q->where('identificador', $area->identificador); 
                                                                                  })
                                                                                ->get() )
                    }}
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <!-- END::Tabla conteo de prestadores por unidad administrativa -->
        @endforeach
        <!-- BEGIN::Tabla de las unidades administrativas-->
        <table class="table table-bordered text-center font-size-11">
            <tr bgcolor="#E6E6E6">
                <th colspan="4" class="align-middle">UNIDADES ADMINISTRATIVAS</th>
            </tr>
            <!-- PHP::Estructura para generar cuatro columnas en la tabla -->
            @php
                $mitad_datos = round(count($areas)/2); 
                $parte_uno = []; 
                $parte_dos = [];
                for($x = 0; $x < $mitad_datos; $x++){
                    array_push($parte_uno, '<th bgcolor="#E6E6E6" class="align-middle font-size-12">'.$areas[$x]->identificador.'</th>
                                            <td class="align-middle text-left">'.$areas[$x]->nombre.'</td>');
                }
                for($y = $mitad_datos; $y < count($areas); $y++){
                    array_push($parte_dos, '<th bgcolor="#E6E6E6" class="align-middle font-size-12">'.$areas[$y]->identificador.'</th>
                                            <td class="align-middle text-left">'.$areas[$y]->nombre.'</td>');
                }
            @endphp
            @for($x = 0; $x < $mitad_datos; $x++)
            <tr>
                {!! isset($parte_uno[$x]) ? $parte_uno[$x] : '<td colspan="2"></td>' !!}
                {!! isset($parte_dos[$x]) ? $parte_dos[$x] : '<td colspan="2"></td>' !!}
            </tr>
            @endfor
        </table>
        <!-- END::Tabla de las unidades administrativas-->
    @endif
    </div>
</div>

@endsection