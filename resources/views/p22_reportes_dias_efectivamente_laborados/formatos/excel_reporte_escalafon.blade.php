{{-- ESTILOS PROPIOS DE CSS CON PHP --}}
@php
    $font = "font-weight: bold; font-size: 9px; font-family: Century Gothic;";
    $f2 = "font-size: 10px; font-family: Century Gothic;";
    $fb2 = "font-weight: bold; font-size: 10px; font-family: Century Gothic;";
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
                <td colspan="16" width="25" height="25" {!! "style=' $h2 '" !!} >
                    SUBCOMISIÓN MIXTA DE ESCALAFÓN EN LA SECRETARÍA DE FINANZAS
                </td>
            </tr>
            <tr>
                <td colspan="16" height="25" {!! "style=' $h3 '" !!} >
                    RECORD ANUAL DE DISCIPLINA Y PUNTUALIDAD PARA CONCURSO ESCALAFONARIO
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="16" height="25" {!! "style=' $h2 $bg_red_light '" !!} >
                    DATOS GENERALES
                </td>
                <td></td>
                <td colspan="9" {!! "style=' $h2 $bg_red_light '" !!}>
                    SIMBOLOGÍA
                </td>
            </tr>
            <tr>
                <td height="25" {!! "style='$border $fb2 '" !!} >
                    NO. EMPLEADO:
                </td>
                <td colspan="2" {!! "style='$border $f2 '" !!} >
                    {{$empleados->numero_empleado}}
                </td>
                <td colspan="2" {!! "style='$border $fb2 '" !!} >
                    NOMBRE:
                </td>
                <td colspan="4" {!! "style='$border $f2 '" !!} >
                    {{$empleados->nombre_completo}}
                </td>
                <td {!! "style=' $border $fb2 '" !!} >
                    RFC:
                </td>
                <td colspan="2" {!! "style='$border $f2 '" !!} >
                    {{$empleados->rfc}}
                </td>
                <td colspan="3" {!! "style='$border $fb2 '" !!} >
                    UD. ADSCRIPCIÓN:
                </td>
                <td {!! "style='$border $f2 '" !!} >
                    {{$empleados->unidad_administrativa}}
                </td>
                <td></td>
                <td colspan="3" {!! "style=' $border $f2 '" !!}>
                    INASISTENCIA &nbsp; " I "
                </td>
                <td colspan="3" {!! "style=' $border $f2 '" !!}>
                    RETARDO LEVE &nbsp; " RL "
                </td>
                <td colspan="3" {!! "style=' $border $f2 '" !!}>
                    OMISIÓN DE ENTRADA " OE "
                </td>
            </tr>
            <tr>
                <td colspan="16" height="25" {!! "style=' $h3 '" !!} >
                    PERIODO DE EVALUACIÓN: &nbsp;&nbsp; {{ $reporte->nombre_periodo_evaluacion }}
                </td>
                <td></td>
                <td colspan="3" {!! "style=' $border $f2 '" !!}>
                    INCAPACIDAD &nbsp; " E "
                </td>
                <td colspan="3" {!! "style=' $border $f2 '" !!}>
                    RETARDO GRAVE &nbsp; " RG "
                </td>
                <td colspan="3" {!! "style=' $border $f2 '" !!}>
                    OMISIÓN DE SALIDA " OS "
                </td>
            </tr>
        </table>
        
        <table>
            <tr>
                <td height="25" {!! "style=' $border $font $bg_red_light '" !!} >
                    CONCEPTO
                </td>
                <td {!! "style=' $border $font $bg_red_light '" !!} >
                    CALIF.
                </td>
                @foreach($fechas as $fecha)
                <td colspan="2" {!! "style=' $border $font $bg_red_light '" !!} >
                    {{$fecha}}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>NOTAS BUENAS</td>
                <td> --- </td>
                @for($x = 0; $x < 12; $x++)
                <td colspan="2"> {{rand()&2}} </td>
                @endfor
            </tr>
            <tr>
                <td>INASISTENCIAS</td>
                <td> --- </td>
                @for($x = 0; $x < 12; $x++)
                <td colspan="2"> {{rand()&2}} </td>
                @endfor
            </tr>    
        </table>

        <table>
            <tr>
                <td height="22" {!! "style=' $border $fb2 $bg_red_light '" !!}>
                    FECHAS
                </td>
                <td colspan="31" {!! "style=' $border $fb2 $bg_red_light '" !!}>
                    D Í A S
                </td>
            </tr>
            <tr>
                <td height="22" {!! "style=' $border $font $bg_red_light '" !!}>
                    MES - AÑO
                </td>
                @for($x = 1; $x <= 31; $x++)
                <td {!! "style=' $border $font $bg_red_light '" !!}>{{$x}}</td>
                @endfor
            </tr>
            @foreach($fechas as $fecha)
                <tr>
                    <td height="22" {!! "style=' $bd_right $bd_left '" !!}>{{$fecha}}</td>
                    @for($x = 1; $x <= 31; $x++)
                        <td> {{$caracteres[rand()&6]}} </td>
                    @endfor
                </tr>
            @endforeach
        </table>
</html>