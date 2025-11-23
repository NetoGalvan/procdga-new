@extends('layouts.pdf')

@section("folio")
    {{ $tramiteIncidencia->folio }}
@endsection

@section("contenido")
    @php
        use Carbon\Carbon;
    @endphp
    <p>
        {{ $firmas->DRH->nombre }} <br>
        {{ $firmas->DRH->puesto }} <br>
        PRESENTE.
    </p>
    <p>
        Por este medio, le solicito le sea autorizado a el (la) C. {{ $firmas->EMPLEADO->nombre }} con número de empleado
        {{ $firmas->EMPLEADO->numero_empleado }}, código de puesto {{ $firmas->EMPLEADO->codigo_puesto }}, 
        con fecha de alta {{ Carbon::parse($firmas->EMPLEADO->fecha_alta_empleado)->format("d-m-Y") }}, adscrito a {{ $firmas->EMPLEADO->unidad_administrativa }} lo siguiente:
    </p>

    <table class="table table-sm table-bordered text-center font-size-10">
        <thead>
            <tr>
                <th>FOLIO AUTORIZACIÓN</th>
                <th>TIPO APLICACIÓN</th>
                <th>FECHAS</th>
                <th>NOTAS BUENAS</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
            @endphp
            @foreach ($incidenciasEmpleado as $incidencia)
                <tr>
                    <td>
                        {{ $incidencia->tramiteIncidencia->folio }}
                    </td>
                    <td>
                        <strong>Artículo:</strong> {{ str_replace("_", " ", $incidencia->tipoIncidencia->articulo) }} <br>
                        {{ str_replace("_", " ", $incidencia->tipoIncidencia->tipoJustificacion->nombre) }}
                    </td>
                    <td>
                        @foreach ($incidencia->fechas as $fecha)
                            {{ Carbon::parse($fecha)->format("d-m-Y") }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($incidencia->notasBuenas as $notaBuena)
                            <strong>{{ $notaBuena->periodo }} - {{ $notaBuena->tipo }}</strong> <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        <strong>OBSERVACIONES:</strong> {{ $tramiteIncidencia->observaciones }}
    </p>
    <table class="table table-sm text-center font-size-10">
        <tr>
            <td style="padding: 20px; width: 33% !important; border: none;"> 
                _________________________________ <br>
                NOMBRE Y FIRMA DEL EMPLEADO <br>
                {{ $firmas->EMPLEADO->nombre }}
            </td>
            <td style="padding: 20px; width: 33% !important; border: none;"> 
                _________________________________ <br>
                NOMBRE Y FIRMA DEL JEFE INMEDIATO <br>
                {{ $firmas->JEFE_INMEDIATO->nombre }} <br>
                {{ $firmas->JEFE_INMEDIATO->puesto }}
            </td>
            <td style="padding: 20px; width: 33% !important; border: none;"> 
                _________________________________ <br>
                NOMBRE Y FIRMA DEL ENLACE <br>
                {{ $firmas->SUB_EA->nombre }} <br>
                {{ $firmas->SUB_EA->puesto }} 
            </td>
        </tr>
    </table>
    <table class="table table-sm text-center font-size-10">
        <tr>
            <td style="padding: 20px; width: 33% !important; border: none;"> 
               
            </td>
            <td style="padding: 20px; width: 33% !important; border: none;"> 
                _________________________________ <br>
                NOMBRE Y FIRMA DEL JUD DE RH <br>
                {{ $firmas->JUD_RH->nombre }} <br>
                {{ $firmas->JUD_RH->puesto }} 
            </td>
            <td style="padding: 20px; width: 33% !important; border: none;"> 
                _________________________________ <br>
                NOMBRE Y FIRMA DEL DRH <br>
                {{ $firmas->DRH->nombre }} <br>
                {{ $firmas->DRH->puesto }} 
            </td>
        </tr>
    </table>

    <div class="separator separator-dashed separator-border-3 mt-10 mb-4"></div>

    <div class="font-size-10">
        <span class="mr-4">La siguiente Incidencia fue:</span> 
        <span class="mr-4">APROBADA</span> <div class="mr-4" style="display: inline-block; width: 15px; height:15px; border:1px solid;"></div>
        <span class="mr-4">RECHAZADA</span> <div class="mr-4" style="display: inline-block; width: 15px; height:15px; border:1px solid;"></div>
        <span>En fecha: _____________________</span>
        <p>Con Folio {{ $tramiteIncidencia->folio }} para el empleado #{{ $firmas->EMPLEADO->numero_empleado }} {{ $firmas->EMPLEADO->nombre }}</p>
    </div>
    <table class="table font-size-8 text-center">
        <tr>
            <td style="padding: 0px; width: 70% !important; border: none;"> 
                <table class="table table-sm table-bordered text-center mb-0">
                    <thead>
                        <tr>
                            <th>FOLIO AUTORIZACIÓN</th>
                            <th>TIPO APLICACIÓN</th>
                            <th>FECHAS</th>
                            <th>NOTAS BUENAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
                        @endphp
                        @foreach ($incidenciasEmpleado as $incidencia)
                            <tr>
                                <td>
                                    {{ $incidencia->tramiteIncidencia->folio }}
                                </td>
                                <td>
                                    <strong>Artículo:</strong> {{ str_replace("_", " ", $incidencia->tipoIncidencia->articulo) }} <br>
                                    {{ str_replace("_", " ", $incidencia->tipoIncidencia->tipoJustificacion->nombre) }}
                                </td>
                                <td>
                                    @foreach ($incidencia->fechas as $fecha)
                                        {{ Carbon::parse($fecha)->format("d-m-Y") }} <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($incidencia->notasBuenas as $notaBuena)
                                        <strong>{{ $notaBuena->periodo }} - {{ $notaBuena->tipo }}</strong> <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="width: 30% !important; border: none;"> 
                ________________________________ <br>
                {{ $firmas->INICIADOR_INCIDENCIA->nombre }} <br>
                {{ $firmas->INICIADOR_INCIDENCIA->puesto }} 
            </td>
        </tr>
    </table>

    <div class="separator separator-dashed separator-border-3 my-4"></div>

    <div>
        <p class="font-size-10">La siguiente Incidencía fue solicitada el día {{ Carbon::now()->format("d-m-Y") }} con Folio {{ $tramiteIncidencia->folio }} para el numero de empleado {{ $firmas->EMPLEADO->numero_empleado }} {{ $firmas->EMPLEADO->nombre }}</p>
    </div>
    <table class="table font-size-8 text-center">
        <tr>
            <td style="padding: 0px; width: 70% !important; border: none;"> 
                <table class="table table-sm table-bordered text-center mb-0">
                    <thead>
                        <tr>
                            <th>FOLIO AUTORIZACIÓN</th>
                            <th>TIPO APLICACIÓN</th>
                            <th>FECHAS</th>
                            <th>NOTAS BUENAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
                        @endphp
                        @foreach ($incidenciasEmpleado as $incidencia)
                            <tr>
                                <td>
                                    {{ $incidencia->tramiteIncidencia->folio }}
                                </td>
                                <td>
                                    <strong>Artículo:</strong> {{ str_replace("_", " ", $incidencia->tipoIncidencia->articulo) }} <br>
                                    {{ str_replace("_", " ", $incidencia->tipoIncidencia->tipoJustificacion->nombre) }}
                                </td>
                                <td>
                                    @foreach ($incidencia->fechas as $fecha)
                                        {{ Carbon::parse($fecha)->format("d-m-Y") }} <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($incidencia->notasBuenas as $notaBuena)
                                        <strong>{{ $notaBuena->periodo }} - {{ $notaBuena->tipo }}</strong> <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="width: 30% !important; border: none;"> 
                ________________________________ <br>
                {{ $firmas->INICIADOR_INCIDENCIA->nombre }} <br>
                {{ $firmas->INICIADOR_INCIDENCIA->puesto }} 
            </td>
        </tr>
    </table>
@endsection
