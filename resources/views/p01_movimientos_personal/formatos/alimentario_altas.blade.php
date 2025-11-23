@extends('layouts.pdf')

@section("contenido")
    <p class="text-right font-size-12 m-0"><b>{{ $movimientoPersonal->folio }}</b></p>
    <p class="text-center font-size-16 m-0 mt-4"><b>DOCUMENTO ALIMENTARIO DE PERSONAL</b></p>
    <p class="text-center font-size-16 m-0 mt-4"><b>{{ $movimientoPersonal->tipoMovimiento->descripcion }}</b></p>
    <div class="mt-4">
        <table class="table table-sm table-bordered font-size-12">
            <tr> 
                <td colspan="3" class="table-active"> DATOS DEL EMPLEADO </td>
            </tr>
            <tr>
                <td colspan="3">Unidad Administrativa: <span class="border-dark border-bottom">{{ $movimientoPersonal->area->identificador }} {{ $movimientoPersonal->nombre_unidad }}</span></td>
            </tr>
            <tr>
                <td colspan="1">ID Sociedad: <span class="border-dark border-bottom">{{ $movimientoPersonal->sociedad_id }}</span></td>
                <td colspan="2">Fecha de nacimiento: <span class="border-dark border-bottom">{{ $movimientoPersonal->fecha_nacimiento }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Nombre del Empleado: <span class="border-dark border-bottom">{{ $movimientoPersonal->nombre_empleado }}</span></td>
                <td colspan="1">Apellido Paterno: <span class="border-dark border-bottom">{{ $movimientoPersonal->apellido_paterno }}</span></td>
                <td colspan="1">Apellido Materno: <span class="border-dark border-bottom">{{ $movimientoPersonal->apellido_materno }}</span></td>
            </tr>
            <tr>
                <td colspan="2">R.F.C.: <span class="border-dark border-bottom">{{ $movimientoPersonal->rfc }}</span></td>
                <td colspan="1">Núm S.S.: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_seguridad_social }}</span></td>
            </tr>
            <tr>
                <td colspan="1">C.U.R.P: <span class="border-dark border-bottom">{{ $movimientoPersonal->curp }}</span></td>
                <td colspan="1">Núm. Expediente: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_expediente }}</span></td>
                <td colspan="1">Núm. Empleado: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_empleado }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Nacionalidad: <span class="border-dark border-bottom">{{ $movimientoPersonal->nacionalidad }}</span></td>
                <td colspan="1">Estado Civil: <span class="border-dark border-bottom">{{ $movimientoPersonal->estadoCivil->nombre }}</span></td>
                <td colspan="1">Sexo: <span class="border-dark border-bottom">{{ $movimientoPersonal->sexo->nombre }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Calle: <span class="border-dark border-bottom">{{ $movimientoPersonal->calle }}</span></td>
                <td colspan="1">Núm. Exterior: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_exterior }}</span></td>
                <td colspan="1">Núm. Interior: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_interior }}</span></td>
            </tr>
            <tr>
                <td colspan="3">Colonia: <span class="border-dark border-bottom">{{ $movimientoPersonal->colonia }}</span></td>
            </tr>
            <tr>
                <td colspan="1">CP: <span class="border-dark border-bottom">{{ $movimientoPersonal->cp }}</span></td>
                <td colspan="2">Alcaldía o Municipio: <span class="border-dark border-bottom">{{ $movimientoPersonal->municipio_alcaldia }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Teléfono: <span class="border-dark border-bottom">{{ $movimientoPersonal->telefono }}</span></td>
                <td colspan="1">Teléfono celular: <span class="border-dark border-bottom">{{ $movimientoPersonal->telefono_celular }}</span></td>
                <td colspan="1">Email: <span class="border-dark border-bottom">{{ $movimientoPersonal->email }}</span></td>
            </tr>
        </table>
        <table class="table table-sm table-bordered font-size-12">
            <tr> 
                <td colspan="4" class="table-active w-25"> DATOS DE FASES DE ALTA </td>
            </tr>
            <tr>
                <td colspan="2">Fecha de Inicio: <span class="border-dark border-bottom">{{ $movimientoPersonal->fecha_propuesta_inicio }}</span></td>
                <td colspan="1">Fecha de Fin: <span class="border-dark border-bottom">{{ $movimientoPersonal->fecha_fin }}</span></td>
                <td colspan="1">Contrato SAR: <span class="border-dark border-bottom">{{ $movimientoPersonal->contrato_sar }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Código de Movimiento: <span class="border-dark border-bottom">{{ $movimientoPersonal->tipoMovimiento->codigo }}</span></td>
                <td colspan="1">Pagaduría: <span class="border-dark border-bottom">{{ $movimientoPersonal->pagaduria }}</span></td>
                <td colspan="1">Modo de Pago: <span class="border-dark border-bottom">{{ $movimientoPersonal->tipoPago->nombre ?? "" }}</span></td>
                <td colspan="1">Banco: <span class="border-dark border-bottom">{{ $movimientoPersonal->banco->nombre ?? "" }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Agencia: <span class="border-dark border-bottom">{{ $movimientoPersonal->agencia }}</span></td>
                <td colspan="2">Núm de cuenta: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_cuenta_bancaria }}</span></td>
                <td colspan="1">Modo de Depósito: <span class="border-dark border-bottom">{{ $movimientoPersonal->modo_deposito }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Reg. Asis: <span class="border-dark border-bottom">{{ $movimientoPersonal->asistencia }}</span></td>
                <td colspan="2">Contrato Interno: <span class="border-dark border-bottom">{{ $movimientoPersonal->contrato_interno }}</span></td>
                <td colspan="1">Fin de Contrato: <span class="border-dark border-bottom">{{ $movimientoPersonal->fecha_fin_contrato }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Empresa: <span class="border-dark border-bottom">{{ $movimientoPersonal->empresa }}</span></td>
                <td colspan="1">Centro de Trabajo: <span class="border-dark border-bottom">{{ $movimientoPersonal->centro_trabajo }}</span></td>
                <td colspan="2">Tipo de Salario: <span class="border-dark border-bottom">{{ $movimientoPersonal->tipo_salario }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Turno: <span class="border-dark border-bottom">{{ $movimientoPersonal->turno->identificador }}</span></td>
                <td colspan="1">Grado: <span class="border-dark border-bottom">{{ $movimientoPersonal->grado }}</span></td>
                <td colspan="1">Zona Pagadora: <span class="border-dark border-bottom">{{ $movimientoPersonal->zonaPagadora->identificador }}</span></td>
                <td colspan="1">Núm. Plaza: <span class="border-dark border-bottom">{{ $movimientoPersonal->numero_plaza }}</span></td>
            </tr>
            <tr>
                <td colspan="2">Situación de Plaza: <span class="border-dark border-bottom">{{ $movimientoPersonal->codigo_situacion_empleado }}</span></td>
                <td colspan="2">Situación de Empleado: <span class="border-dark border-bottom">{{ $movimientoPersonal->codigo_situacion_empleado }}</span></td>
            </tr>
            <tr>
                <td colspan="1">Código de Puesto: <span class="border-dark border-bottom">{{ $movimientoPersonal->codigo_puesto }}</span></td>
                <td colspan="1">Nivel: <span class="border-dark border-bottom">{{ $movimientoPersonal->nivel_salarial }}</span></td>
                <td colspan="1">Universo: <span class="border-dark border-bottom">{{ $movimientoPersonal->codigo_universo }}</span></td>
                <td colspan="1">Régimen ISSSTE: <span class="border-dark border-bottom">{{ $movimientoPersonal->regimenIssste->nombre }}</span></td>
            </tr>
            <tr>
                <td colspan="4">Denominacion de Puesto: <span class="border-dark border-bottom">{{ $movimientoPersonal->puesto }}</span></td>
            </tr>
        </table>
        <table class="table table-sm table-bordered font-size-12">
            <tr> 
                <td colspan="4" class="table-active"> ELABORACIÓN </td>
            </tr>
            <tr class="text-center">
                <td colspan="1" class="w-25">FECHA DE ELABORACIÓN:</td>
                <td colspan="2" class="w-25">PROCESADO:</td>
                <td colspan="1" class="w-50">USUARIO INICIADOR DE PROCESO:</td>
            </tr>
            <tr class="text-center">
                <td class="align-middle">{{ $movimientoPersonal->fecha_elaboracion }}</td>
                <td class="align-middle">AÑO: <br> {{ $movimientoPersonal->anio_procesado }}</td>
                <td class="align-middle">QUINCENA: <br> {{ $movimientoPersonal->qna_procesado }}</td>
                <td class="align-middle">
                    {{ mb_strtoupper($movimientoPersonal->usuarioIniciador->nombre_completo) }} <br>
                    {{ mb_strtoupper($movimientoPersonal->usuarioIniciador->puesto) }} <br>
                    {{ mb_strtoupper($movimientoPersonal->usuarioIniciador->area->nombre) }}
                </td>
            </tr>
        </table>
        <table class="table table-sm table-bordered font-size-12">
            <tr class="text-center">
                <td class="h-20"></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td class="w-50"> 
                    NOMBRE Y FIRMA <br>
                    {{ $movimientoPersonal->usuarioTitular->puesto }} <br>
                    {{ $movimientoPersonal->usuarioTitular->nombre_completo }} <br>
                </td>
                <td class="w-50"> 
                    AUTORIZACIÓN DE MOVIMIENTO <br>
                    {{ $movimientoPersonal->usuarioAutorizador->puesto }} <br>
                    {{ $movimientoPersonal->usuarioAutorizador->nombre_completo }}  <br>
                </td>
            </tr>
        </table>
    </div>
@endsection
    
    
