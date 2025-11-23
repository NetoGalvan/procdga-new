<?php

namespace App\Http\Controllers\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\CalificacionPsicometrico;
use App\Models\Plaza;

trait ManejadorTareas
{
    public function seleccionCodigos($movimientoPersonal) {
        if ($movimientoPersonal->tipoMovimiento->tipo == "ALTAS") {
            $nombreTarea = 'TA02';
            $url = 'movimiento.personal.altas.capturar.propuesta'; 
        } 
        else if ($movimientoPersonal->tipoMovimiento->tipo == "BAJAS") {
            $nombreTarea = 'TB02';
            $url = 'movimiento.personal.bajas.alimentario';
        } 
        else if ($movimientoPersonal->tipoMovimiento->tipo == "REANUDACIONES") {
            $nombreTarea = 'TR02';
            $url = 'movimiento.personal.reanudaciones.alimentario';
        }
        return [
            "nombreTarea" => $nombreTarea,
            "url" => $url
        ];
    }

    public function guardarTareaT01($movimientoPersonal, $request) {
        $movimientoPersonal->tipo_movimiento_id = $request->tipo_movimiento_id;
        $movimientoPersonal->folio_aprobacion =  $request->folio_aprobacion;
        $movimientoPersonal->tipo_plaza =  $request->tipo_plaza;
        
        /* $movimientoPersonal->email =  $request['email']; */
        
        /* if ($movimientoPersonal->tipo_movimiento == "ALTAS") {
            $empleado = User::where("email", strtolower($movimientoPersonal->email))->first();
            if (is_null($empleado)) {
                // Crear usuario de empleado
                $password = $this->randomPassword();
                $empleado = User::create([
                    'nombre_usuario' => strtolower($movimientoPersonal->email),
                    'email' => strtolower($movimientoPersonal->email),
                    'password' => Hash::make($password),
                    'name' => $movimientoPersonal->nombre_empleado,
                    'apellido_paterno' => $movimientoPersonal->apellido_paterno,
                    'apellido_materno' => $movimientoPersonal->apellido_materno, 
                    'area_id' => Auth::user()->area->area_id
                ]);
                $empleado->assignRole('EMPLEADO_GRAL');
                EnviarMail::dispatchNow($movimientoPersonal->email, new CreacionCuentaEmpleado("DOCUMENTACIÓN - PROCDGA", $movimientoPersonal, $empleado, $password));
            } else {           
                EnviarMail::dispatchNow($movimientoPersonal->email, new Documentacion("DOCUMENTACIÓN - PROCDGA", $movimientoPersonal, $empleado));
            }

            $T09 = $this->crearTarea($movimientoPersonal->instancia,  "T09", 'NUEVO');
            $T09->asignado_al_usuario = $empleado->id;
            $T09->save();
        } */

        return $movimientoPersonal->save();
    }

    public function guardarTareaTA02($movimientoPersonal, $request) {
        $movimientoPersonal->numero_empleado =  $request->numero_empleado;
        $movimientoPersonal->rfc =  $request->rfc;
        $movimientoPersonal->curp = $request->curp;
        $movimientoPersonal->nombre_empleado =  $request->nombre_empleado;
        $movimientoPersonal->apellido_paterno =  $request->apellido_paterno;
        $movimientoPersonal->apellido_materno =  $request->apellido_materno;
        $movimientoPersonal->fecha_solicitud =  $request->fecha_solicitud;
        $movimientoPersonal->email =  $request->email;
        $movimientoPersonal->telefono =  $request->telefono;
        $movimientoPersonal->telefono_celular = $request->telefono_celular;
        $movimientoPersonal->fecha_propuesta_inicio =  $request->fecha_propuesta_inicio;
        $movimientoPersonal->nivel_estudio_id =  $request->nivel_estudio_id;
        // Plaza
        $plaza = Plaza::where("numero_plaza", $request->numero_plaza)->first();
        $movimientoPersonal->numero_plaza = $plaza->numero_plaza;
        $movimientoPersonal->codigo_puesto = $plaza->codigo_puesto;
        $movimientoPersonal->puesto = $plaza->puesto;
        $movimientoPersonal->nivel_salarial = $plaza->nivel_salarial;
        $movimientoPersonal->codigo_universo = $plaza->codigo_universo;
        $movimientoPersonal->codigo_situacion_empleado = $plaza->codigo_situacion_empleado;
        $movimientoPersonal->observaciones_plaza =  $request->observaciones_plaza;
        $movimientoPersonal->funciones_plaza =  $request->funciones_plaza;

        return $movimientoPersonal->save();
    }

    public function guardarTareaTA03($movimientoPersonal, $request) {
        $psicometrico = new CalificacionPsicometrico;
        $psicometrico->movimiento_personal_id = $movimientoPersonal->movimiento_personal_id;
        $psicometrico->lugar = $request['lugar_cita'];
        $psicometrico->hora = $request['hora_cita'];
        $psicometrico->fecha = $request['fecha_cita'];
        return $psicometrico->save();
    }

    public function guardarTareaTA04($movimientoPersonal, $request) {
        $psicometrico = $movimientoPersonal->calificacionPsicometrico;
        $psicometrico->tipo_calificacion_psicometrico_id =  $request->tipo_calificacion_psicometrico_id;
        $psicometrico->observaciones_calificacion = $request->observaciones_calificacion;
        return $psicometrico->save();
    }

    public function guardarTareaTA05($movimientoPersonal, $request) {
        $movimientoPersonal->fecha_nacimiento = $request->fecha_nacimiento;
        $movimientoPersonal->nacionalidad = $request->nacionalidad;
        $movimientoPersonal->numero_seguridad_social = $request->numero_seguridad_social;   
        $movimientoPersonal->calle = $request->calle;
        $movimientoPersonal->numero_exterior = $request->numero_exterior;
        $movimientoPersonal->numero_interior = $request->numero_interior;
        $movimientoPersonal->cp = $request->cp;
        $movimientoPersonal->ciudad = $request->ciudad;
        $movimientoPersonal->municipio_alcaldia = $request->municipio_alcaldia;
        $movimientoPersonal->colonia = $request->colonia;
        $movimientoPersonal->asistencia = $request->asistencia;
        $movimientoPersonal->fecha_fin = $request->fecha_fin;
        $movimientoPersonal->fecha_fin_contrato = $request->fecha_fin_contrato;
        $movimientoPersonal->contrato_sar = $request->contrato_sar;
        $movimientoPersonal->contrato_interno = $request->contrato_interno;
        $movimientoPersonal->grado = $request->grado;
        $movimientoPersonal->agencia = $request->agencia; 
        $movimientoPersonal->numero_cuenta_bancaria = $request->numero_cuenta_bancaria;
        $movimientoPersonal->modo_deposito = $request->modo_deposito;
        $movimientoPersonal->autorizador = $request->autorizador;
        $movimientoPersonal->titular = $request->titular;
        $movimientoPersonal->sexo_id = $request->sexo_id;
        $movimientoPersonal->entidad_federativa_nacimiento_id = $request->entidad_federativa_nacimiento_id;
        $movimientoPersonal->estado_civil_id = $request->estado_civil_id;
        $movimientoPersonal->entidad_federativa_domicilio_id = $request->entidad_federativa_domicilio_id;
        $movimientoPersonal->turno_id = $request->turno_id;
        $movimientoPersonal->regimen_issste_id = $request->regimen_issste_id;
        $movimientoPersonal->tipo_pago_id = $request->tipo_pago_id;
        $movimientoPersonal->banco_id = $request->banco_id;
        $movimientoPersonal->zona_pagadora_id = $request->zona_pagadora_id;

        return $movimientoPersonal->save();
    }

    public function guardarTareaTA06($movimientoPersonal) {
        $movimientoPersonal->estatus_issste = "LISTO";
        $movimientoPersonal->estatus_sun = "LISTO";
        return $movimientoPersonal->save();
    }

    public function guardarTareaTB02($movimientoPersonal, $request) {
        $empleado = json_decode($request->datos_empleado);
        if ($empleado) {
            $movimientoPersonal->numero_empleado =  $empleado->numero_empleado;
            $movimientoPersonal->rfc =  $empleado->rfc;
            $movimientoPersonal->curp =  $empleado->curp;
            $movimientoPersonal->nombre_empleado =  $empleado->nombre;
            $movimientoPersonal->apellido_paterno =  $empleado->apellido_paterno;
            $movimientoPersonal->apellido_materno =  $empleado->apellido_materno;
            $movimientoPersonal->numero_plaza =  $empleado->numero_plaza;
            $movimientoPersonal->codigo_situacion_empleado = $empleado->codigo_situacion_empleado;
            $movimientoPersonal->codigo_puesto =  $empleado->codigo_puesto;
            $movimientoPersonal->nivel_salarial = $empleado->nivel_salarial;
            $movimientoPersonal->codigo_universo = $empleado->codigo_universo;
            $movimientoPersonal->puesto = $empleado->puesto;
            $movimientoPersonal->observaciones_plaza = $request->observaciones_plaza;
        }
        
        $movimientoPersonal->fecha_solicitud = $request->fecha_solicitud;
        $movimientoPersonal->fecha_alta = $request->fecha_alta;
        $movimientoPersonal->fecha_fin = $request->fecha_fin;
        $movimientoPersonal->autorizador = $request->autorizador;
        $movimientoPersonal->titular = $request->titular;
        $movimientoPersonal->estatus_issste = "LISTO";
        $movimientoPersonal->estatus_sun = "LISTO";
        return $movimientoPersonal->save();
    }

    public function guardarTareaTR02($movimientoPersonal, $request) {
        $empleado = json_decode($request->datos_empleado);
        if ($empleado) {
            $movimientoPersonal->numero_empleado =  $empleado->numero_empleado;
            $movimientoPersonal->rfc =  $empleado->rfc;
            $movimientoPersonal->curp =  $empleado->curp;
            $movimientoPersonal->nombre_empleado =  $empleado->nombre;
            $movimientoPersonal->apellido_paterno =  $empleado->apellido_paterno;
            $movimientoPersonal->apellido_materno =  $empleado->apellido_materno;
        }

        // Plaza
        $plaza = Plaza::where("numero_plaza", $request->numero_plaza)->first();
        $movimientoPersonal->numero_plaza = $plaza->numero_plaza;
        $movimientoPersonal->codigo_puesto = $plaza->codigo_puesto;
        $movimientoPersonal->puesto = $plaza->puesto;
        $movimientoPersonal->nivel_salarial = $plaza->nivel_salarial;
        $movimientoPersonal->codigo_universo = $plaza->codigo_universo;
        $movimientoPersonal->codigo_situacion_empleado = $plaza->codigo_situacion_empleado;
        $movimientoPersonal->observaciones_plaza =  $request->observaciones_plaza;

        $movimientoPersonal->fecha_solicitud = $request->fecha_solicitud;
        $movimientoPersonal->telefono = $request->telefono;
        $movimientoPersonal->telefono_celular = $request->telefono_celular;
        $movimientoPersonal->email = $request->email;
        $movimientoPersonal->calle = $request->calle;
        $movimientoPersonal->numero_exterior = $request->numero_exterior;
        $movimientoPersonal->numero_interior = $request->numero_interior;
        $movimientoPersonal->cp = $request->cp;
        $movimientoPersonal->ciudad = $request->ciudad;
        $movimientoPersonal->municipio_alcaldia = $request->municipio_alcaldia;
        $movimientoPersonal->colonia = $request->colonia;
        $movimientoPersonal->entidad_federativa_domicilio_id = $request->entidad_federativa_domicilio_id;
        $movimientoPersonal->fecha_alta = $request->fecha_alta;
        $movimientoPersonal->fecha_fin = $request->fecha_fin;
        $movimientoPersonal->autorizador = $request->autorizador;
        $movimientoPersonal->titular = $request->titular;
        $movimientoPersonal->estatus_issste = "LISTO";
        $movimientoPersonal->estatus_sun = "LISTO";
        
        return $movimientoPersonal->save();
    }    
}
