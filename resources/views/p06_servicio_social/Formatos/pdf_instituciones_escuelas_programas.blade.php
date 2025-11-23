@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")

<div style="font-family: Sans-serif;">
    <div class="mtn-100">
        <h3 class="">REPORTE EJECUTIVO DE {{ $opcion }} <br> SERVICIO SOCIAL Y PRÁCTICAS PROFESIONALES</h3>
    </div>
    <br>
    <table class="table table-bordered table-general text-center" width="100%">
        <thead>
            <tr bgcolor="#E6E6E6" class="font-size-14">
                <th>NOMBRE</th>
                @if ($opcion != 'PROGRAMAS')
                <th>ACRONIMO</th>
                @endif
                @if ($opcion == 'ESCUELAS')
                <th>DIRECCIÓN</th>
                @else
                <th>CLAVE</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($informacion as $info)
                <tr class="font-size-13">
                    <td class="text-left">
                        {{ ( isset($info->nombre_escuela) ) 
                            ? $info->nombre_escuela 
                            : ( $info->nombre_institucion ?? $info->nombre_programa)
                        }}
                    </td>
                    @if ($opcion != 'PROGRAMAS')
                    <td>
                        {{ $info->acronimo_escuela ?? $info->acronimo_institucion }}
                    </td>
                    @endif
                    <td class="{{($opcion == 'ESCUELAS') ? 'text-left' : ''}}">
                        {{ ( isset($info->direccion_escuela) ) 
                            ? $info->direccion_escuela 
                            : ( $info->clave_institucion ?? $info->clave_programa)
                        }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection