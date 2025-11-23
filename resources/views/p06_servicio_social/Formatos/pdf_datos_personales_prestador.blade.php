@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> REGISTRO DE SERVICIO SOCIAL </h4> --}}
@endsection

@section("contenido")
    <div style="font-family: Sans-serif;">
        <table width="100%" class="mtn-100">
            <tr>
                <td class="border" style="width: 80px; height: 100px;"></td>
                <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REGISTRO DE SERVICIO SOCIAL</b></td>
            </tr>
        </table>
        <table class="" width="100%">
            <tr>
                <td bgcolor="#E6E6E6" class="font-size-14 py-1 text-center" colspan="4">
                    <b>DATOS PERSONALES</b>
                </td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2" width="25%"><b>APELLIDO PATERNO:</b></td>
                <td class="pt-2" width="25%"><b>APELLIDO MATERNO:</b></td>
                <td class="pt-2" width="25%"><b>NOMBRE:</b></td>
                <td class="pt-2" width="25%"><b>MATRÍCULA:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2">
                    {{ $datosPrestador->prestador->primer_apellido ?? $datosPrestador->apellido_paterno }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->prestador->segundo_apellido ?? $datosPrestador->apellido_materno }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->prestador->nombre_prestador ?? $datosPrestador->nombre_prestador }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->prestador->matricula ?? $datosPrestador->matricula }}
                </td>
            </tr>
            <tr class="font-size-12">
                <td colspan="2" class="pt-2"><b>INSTITUCIÓN:</b></td>
                <td colspan="2" class="pt-2"><b>ESCUELA:</b></td>
            </tr>
            <tr class="font-size-12">
                <td colspan="2" class="pb-2">{{ $datosPrestador->prestador->escuela->institucion->nombre_institucion ?? $datosPrestador->institucion }}</td>
                <td colspan="2" class="pb-2">{{ $datosPrestador->prestador->escuela->nombre_escuela ?? $datosPrestador->nombre_escuela }}</td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2"><b>ACRÓNIMO:</b></td>
                <td class="pt-2"><b>CARRERA:</b></td>
                <td class="pt-2"><b>TELÉFONO:</b></td>
                <td class="pt-2"><b>CORREO:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2">
                    {{ $datosPrestador->prestador->escuela->acronimo_escuela ?? $datosPrestador->acronimo_escuela }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->prestador->carrera ?? $datosPrestador->carrera }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->prestador->telefono ?? $datosPrestador->telefono }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->prestador->email ?? $datosPrestador->email }}
                </td>
            </tr>
            <tr class="font-size-12 text-left">
                <td colspan="4" class="border-top border-secondary pt-2"><b>DOMICILIO:</b></td>
            </tr>
            <tr class="font-size-12">
                <td colspan="4" class="text-left pb-2">
                    <b>CALLE:</b> {{ $datosPrestador->prestador->calle ?? $datosPrestador->calle}},
                    <b>NO.</b> {{ $datosPrestador->prestador->numero_exterior ?? $datosPrestador->numero_exterior}},
                    <b>COLONIA:</b> {{ $datosPrestador->prestador->colonia ?? $datosPrestador->colonia }},
                    <b>ALCALDÍA:</b> {{ $datosPrestador->prestador->municipio_alcaldia ?? $datosPrestador->municipio_alcaldia}}, {{ $datosPrestador->prestador->cp ?? $datosPrestador->cp}}
                </td>   
            </tr>
        </table>
        <table class="" width="100%">
            <tr>
                <td bgcolor="#E6E6E6" class="font-size-14 py-1 text-center" colspan="2">
                    <b>DATOS DE ADSCRIPCIÓN</b>
                </td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2 pr-2" width="50%"><b>ÁREA DE ADSCRIPCIÓN:</b></td>
                <td class="pt-2 pl-1" width="50%"><b>SUBDIRECCIÓN:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2 pr-2">{{ $datosPrestador->areaAdscripcion->nombre_area_adscripcion ?? $datosPrestador->direccion_ua}}</td>
                <td class="pb-2 pl-1">{{ $datosPrestador->subdireccion_ua ?? 'S/D' }}</td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2 pr-2"><b>UNIDAD DEPARTAMENTAL:</b></td>
                <td class="pt-2 pl-1"><b>DIRECCIÓN:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2 pr-2">{{ $datosPrestador->unidad_departamental_ua ?? 'S/D'}}</td>
                <td class="pb-2 pl-1">{{ $datosPrestador->areaAdscripcion->direccion_area_adscripcion ?? $datosPrestador->domicilio_ua}}</td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2 pr-2"><b>JEFE INMEDIATO:</b></td>
                <td class="pt-2 pl-1"><b>TELÉFONO:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2 pr-2">{{ $datosPrestador->jefe }}</td>
                <td class="pb-2 pl-1">{{ $datosPrestador->telefono_jefe }}</td>
            </tr>
        </table>
        <table class="text-center" width="100%">
            <tr>
                <td bgcolor="#E6E6E6" class="font-size-14 py-1" colspan="4"><b>DETALLES</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2" width="25%"><b>ESTATUS:</b></td>
                <td class="pt-2" width="25%"><b>INICIO DE SERVICIO:</b></td>
                <td class="pt-2" width="25%"><b>HORARIO:</b></td>
                <td class="pt-2" width="25%"><b>CARTA DE ACEPTACIÓN:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2">
                    <?php
                        $estatus = ($datosPrestador->work_status ?? $datosPrestador->prestador->estatus_prestador);
                    ?>
                    @if ( $estatus == "LIBERADO" || $estatus == 'FREE' )
                            LIBERADO
                        @elseif( $estatus == "WORKING" || $estatus == 'EN_CURSO' )
                            EN CURSO
                        @elseif( $estatus == "RECHAZADO" || $estatus == 'BLOCKED' )
                            RECHAZADO
                        @elseif( $estatus == 'ABANDON' || $estatus == 'ABANDONO' )
                            ABANDONO
                        @elseif( $estatus == "BAJA" || $estatus == 'PREMATURE_END' )
                            DADO DE BAJA
                        @else
                    @endif
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->fecha_inicio }}
                </td>
                <td class="pb-2">
                    {{ $datosPrestador->horario }}
                </td>
                <td class="pb-2">
                    @php
                        if( isset($datosPrestador->firma_drh_inicio)) {
                            echo date_format(Carbon\Carbon::parse($datosPrestador->firma_drh_inicio), 'd/m/Y');
                        } else if( isset($datosPrestador->fecha_firma_drh_inicio)) {
                            echo date_format(Carbon\Carbon::parse($datosPrestador->fecha_firma_drh_inicio), 'd/m/Y');
                        } else{
                            echo 'S/C';
                        }
                    @endphp
                </td>
            </tr>
            <tr class="font-size-12">
                <td class="pt-2"><b>FECHA DE RECLUTAMIENTO:</b></td>
                <td class="pt-2"><b>FIN DE SERVICIO:</b></td>
                <td class="pt-2"><b>TOTAL DE HORAS:</b></td>
                <td class="pt-2"><b>CARTA DE TERMINO:</b></td>
            </tr>
            <tr class="font-size-12">
                <td class="pb-2">{{ date_format(Carbon\Carbon::parse($datosPrestador->fecha_cita), 'd/m/Y') }}</td>
                <td class="pb-2">{{ $datosPrestador->fecha_fin }}</td>
                <td class="pb-2">{{ $datosPrestador->prestador->total_horas ?? $datosPrestador->total_horas }}</td>
                <td class="pb-2">
                    @php
                        if( isset($datosPrestador->firma_drh_fin)) {
                            echo date_format(Carbon\Carbon::parse($datosPrestador->firma_drh_fin), 'd/m/Y');
                        } else if( isset($datosPrestador->fecha_firma_drh_fin)) {
                            echo date_format(Carbon\Carbon::parse($datosPrestador->fecha_firma_drh_fin), 'd/m/Y');
                        } else{
                            echo 'S/C';
                        }
                    @endphp
                </td>
            </tr>
            <tr class="font-size-12 text-left">
                <td class="border-top border-secondary pt-2" colspan="4"><b>ACTIVIDADES A REALIZAR:</b></td>
            </tr>
            <tr class="font-size-12 text-left">
                <td class="pb-2" colspan="4">{!! nl2br(e($datosPrestador->actividades)) !!}</td>
            </tr>
        </table>
    </div>
@endsection