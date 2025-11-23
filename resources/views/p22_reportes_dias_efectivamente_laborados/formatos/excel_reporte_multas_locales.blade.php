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
                <td colspan="8" height="25" {!! "style=' $h2 '" !!} >
                    SECRETARÍA DE FINANZAS
                </td>
            </tr>
            <tr>
                <td colspan="8" height="25" {!! "style=' $h3 '" !!} >
                    PERIODO DE EVALUACIÓN: &nbsp;&nbsp; {{ $reporte->nombre_periodo_evaluacion }}
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan="5" height="25" {!! "style=' $h4 $border $bg_red_light '" !!}>
                    DATOS GENERALES
                </td>
                <td colspan="3" {!! "style=' $h4 $border $bg_red_light '" !!}>
                    E V A L U A C I Ó N
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
                    NIVEL SALARIAL
                </td>
                <td colspan="3" width="11"
                    {!! "style=' $font $border $bg_red_light'" !!}
                >
                    TOTAL DE DÍAS
                </td>
            </tr>
            <tr>
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
                <td {!! "style=' $bd_right '" !!} > 
                    {{$empleado->nivel_salarial}} 
                </td>

                <td> {{rand(120, 126)}}</td>
                <td> {{rand(0, 120)}} </td>
                <td {!! "style=' $bd_right '" !!} > {{"=(F$count - G$count)"}} </td>
            </tr>
            {{$count += 1}}
            @endforeach
        </table>
</html>