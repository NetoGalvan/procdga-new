@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> COMPROBANTE DE SERVICIOS </h4> --}}
@endsection

@section("contenido")
<div class="mtn-20" style="font-family: Sans-serif;">
    <div class="font-size-13">
        <div class="text-right">
            <b> {{ $servicioSocial->instancia->folio ?? $servicioSocial->folio }} </b> <br>
            ASUNTO: ACEPTACIÓN DE {{ $servicioSocial->prestador->tipo_prestador ?? mb_strtoupper($servicioSocial->tipo_prestador)}} <br>
            PRESTADOR: {{ mb_strtoupper($servicioSocial->nombre_prestador_completo) }}
        </div>
        <p>
            <strong>
            {{ $servicioSocial->prestador->nombre_funcionario ?? mb_strtoupper($servicioSocial->funcionario_escuela) }} <br>
            {{ $servicioSocial->prestador->puesto_funcionario  ?? mb_strtoupper($servicioSocial->cargo_funcionario)}} <br>
            {{ $servicioSocial->prestador->escuela->institucion->nombre_institucion  ?? mb_strtoupper($servicioSocial->institucion) }} <br>
            {{ $servicioSocial->prestador->escuela->nombre_escuela ?? mb_strtoupper($servicioSocial->nombre_escuela) }} <br>
            {{ $servicioSocial->prestador->escuela->acronimo_escuela ?? mb_strtoupper($servicioSocial->acronimo_escuela) }} <br>
            PRESENTE
            </strong>
        </p>
    </div>
    <div class="font-size-12 text-justify">
        <p>
            De acuerdo al procedimiento de asignación de pasantes de 
            {{ mb_strtolower($servicioSocial->prestador->tipo_prestador ?? $servicioSocial->tipo_prestador) }} 
            y para los efectos que procedan, comunico a usted que el(la) 
            <b>C. {{ $servicioSocial->nombre_prestador_completo }}</b> 
            alumno(a) de esa Institución Educativa en la carrera de 
            <b>{{ $servicioSocial->prestador->carrera ?? mb_strtoupper($servicioSocial->carrera) }}</b> 
            con número de cuenta o matrícula 
            <b>{{ $servicioSocial->prestador->matricula ?? mb_strtoupper($servicioSocial->matricula)}}</b> 
            ha sido aceptado(a) como prestador de 
            <b>{{ $servicioSocial->prestador->tipo_prestador ?? mb_strtoupper($servicioSocial->tipo_prestador)}}</b>
            en esta Dependencia, adscrito(a) a la 
            <b>{{ $servicioSocial->areaAdscripcion->nombre_area_adscripcion ?? 'S/D' }}</b> 
            de lunes a viernes con horario de 
            <b>{{ $servicioSocial->horario }}</b>,
            en donde sus actividades a realizar consistirán en:
            <br><br>
            {{ ucfirst( mb_strtolower($servicioSocial->actividades) ) }}
            <br><br>
            El periodo de prestación será del {{ $cadenaFechaInicioSS }} al {{ $cadenaFechaFinSS }}, cubriendo un total de {{ $servicioSocial->prestador->total_horas ?? $servicioSocial->total_horas}} horas de servicio.
            <br><br>
            Programa: {{  ucfirst( mb_strtolower($servicioSocial->prestador->programa->nombre_programa ?? $servicioSocial->nombre_programa)) }}.  Clave: {{ $servicioSocial->prestador->programa->clave_programa ?? $servicioSocial->clave_programa }}.

            @if ( trim($servicioSocial->observaciones_carta_inicio) !== "")
                <br><br>
                Observaciones particulares: <br>
                {{ ucfirst( mb_strtolower($servicioSocial->observaciones_carta_inicio) ) }}
            @endif
        </p>
    </div>
    <div class="font-size-13 text-center">
        <br>ATENTAMENTE

        <div>
            <br><br><br>
            <hr style="width: 50%;">
            <table width="100%"  class="text-center">
                <tr>
                    <td>
                        {{$firmaCartaInicio->nombre}} {{$firmaCartaInicio->apellido_paterno}} {{$firmaCartaInicio->apellido_materno}}
                    </td>
                </tr>
                <tr class="font-size-12">
                    <td><b>{{$firmaCartaInicio->puesto}}</b></td>
                </tr>
                <tr class="font-size-12">
                    <td><b>LDA/JJFC/ERA</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection