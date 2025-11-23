{{-- ESTILOS PROPIOS DE CSS CON PHP --}}
@php
    $font = "font-weight: bold; font-size: 9px; font-family: Century Gothic;";
    $h2 = "font-weight: bold; font-size: 13px; font-family: Century Gothic;";
    $h3 = "font-size: 12px; font-family: Century Gothic;";
    $h4 = "font-weight: bold; font-size: 11px; font-family: Century Gothic;";
    $bold = "font-weight: bold;";
    $border = "border: 1px solid black;";
    $bd_left = "border-left: 1px solid black;";
    $bd_right = "border-right: 1px solid black;";
    $bd_top = "border-top: 1px solid black;";
    $bd_bottom = "border-bottom: 1px solid black;";
    $bg_red_light = "background: #DA9694";
@endphp
<html>
        <table>
            <tr>
                <td colspan="19" height="25" {!! "style=' $h2 '" !!} >
                    UNIDAD DEPARTAMENTAL DE RECURSOS HUMANOS, REPORTE DE DÍAS EFECTIVAMENTE LABORADOS DEL PERSONAL DE FIZCALIZACIÓN PARA EFECTOS DE MULTAS FEDERALES
                </td>
            </tr>
            <tr>
                <td colspan="19" height="25" {!! "style=' $h3 '" !!} >
                    PERIODO DE EVALUACIÓN: &nbsp;&nbsp; {{ $reporte->nombre_periodo_evaluacion }}
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan="6" height="25" {!! "style=' $h4 $border $bg_red_light '" !!}>
                    DATOS GENERALES
                </td>
                @foreach($fechas as $key => $fecha)
                <td colspan="13" {!! "style=' $h4 $border $bg_red_light '" !!} >
                    MES {{$key+1}} EVALUACIÓN ( {{$fecha}} )
                </td>
                @endforeach
                <td colspan="3" {!! "style=' $h4 $border $bg_red_light '" !!}>
                    F I N A L
                </td>
            </tr>
            <tr>
                {{-- DATOS GENERALES --}}
                <td rowspan="2" width="11" height="20" 
                    {!! "style=' $font $border $bg_red_light '" !!}
                >
                    NO. EMPLEADO
                </td>
                <td rowspan="2" width="35"
                    {!! "style=' $font $border $bg_red_light '" !!}
                >
                    NOMBRE EMPLEADO
                </td>
                <td rowspan="2" width="17"
                    {!! "style=' $font $border $bg_red_light '" !!}
                >
                    R F C
                </td>
                <td rowspan="2" width="30"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    UNIDAD ADMINISTRATIVA 
                </td>
                <td rowspan="2" width="11"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    SECCIÓN SINDICAL
                </td>
                <td rowspan="2" width="11"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    NIVEL SALARIAL
                </td>
                @for($x=0; $x<3; $x++)
        {{-- - - - - - M  E  S  E  S - - - - - --}}
                <td rowspan="2" width="10"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    LIC. MEDICA
                </td>
                <td rowspan="2" width="10"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    LIC. CON SUELDO
                </td>
                <td rowspan="2" width="10"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    LIC. SIN SUELDO
                </td>
                <td rowspan="2" width="14"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    VACACIONES
                </td>
                <td rowspan="2" width="11"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    DÍA SINDICAL
                </td>
                <td rowspan="2" width="11"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    COMISIÓN SINDICAL
                </td>
                <td rowspan="2" width="11"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    CUID. MATERNAL
                </td>
                <td rowspan="2" width="13"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    SUSPENCIÓN
                </td>
                <td rowspan="2" width="10"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    BAJA
                </td>
                <td rowspan="2" width="13"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    DEFUNCIÓN
                </td>
                <td rowspan="2" width="10"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    FALTAS INJUST.
                </td>
                <td colspan="2" {!! "style=' $font $border $bg_red_light'" !!} >
                    TOTAL DE DÍAS
                </td>
                @endfor
                <td colspan="3" {!! "style=' $font $border $bg_red_light'" !!} > TOTAL DE DÍAS </td>
            </tr>
            <tr>
                @for($x=0; $x<3; $x++)
                <td width="14" height="20"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    LABORABLES
                </td>
                <td width="19" {!! "style=' $font $border $bg_red_light'" !!} >
                    EFECT. LABORADOS
                </td>
                @endfor
                <td width="14" height="20"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    LABORABLES
                </td>
                <td width="16"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    NO LABORADOS
                </td>
                <td width="19" {!! "style=' $font $border $bg_red_light'" !!} >
                    EFECT. LABORADOS
                </td>
            </tr>
            {{ $count = 7 }}
            @foreach($empleados as $empleado)
            <tr>
                {{-- DATOS GENERALES --}}
                <td {!! "style=' $bd_left '" !!} > 
                    {{$empleado->numero_empleado}} 
                </td>
                <td> {{$empleado->nombre_completo}} </td>
                <td> {{$empleado->rfc}} </td>
                <td> {{$empleado->unidad_administrativa .' - '. $empleado->unidad_administrativa_nombre}} </td>
                <td> {{$empleado->seccion_sindical}} </td>
                <td {!! "style=' $bd_right '" !!} > 
                    {{$empleado->nivel_salarial}} 
                </td>

                {{-- MES 1 DE G8 - Q8--}}
                <td> {{rand()&1}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand(0, 26)}}</td>
                <td> {{rand(26,31)}} </td>
                <td {!! "style=' $bd_right '" !!} > {{ "=(R$count - Q$count)" }} </td>

                {{-- MES 2 DE T8 - AD8--}}
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand(0, 26)}}</td>
                <td> {{rand(26,31)}} </td>
                <td {!! "style=' $bd_right '" !!} > {{ "=(AE$count - AD$count)" }} </td>

                {{-- MES 3 DE AG8 - AS8--}}
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&2}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand()&1}} </td>
                <td> {{rand(0, 26)}}</td>
                <td> {{rand(26,31)}} </td>
                <td {!! "style=' $bd_right '" !!} > {{ "=(AR$count - AQ$count)" }} </td>

                {{-- FINAL --}}
                <td> {{ "=(R$count + AE$count + AR$count)" }} </td>
                <td> {{ "=(Q$count + AD$count + AQ$count)" }} </td>
                <td {!! "style=' $bd_right '" !!} > {{ "=(AT$count - AU$count)" }} </td>
            </tr>
            {{$count += 1}}
            @endforeach
        </table>
</html>