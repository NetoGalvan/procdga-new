<?php

namespace App\Http\Controllers\p12_tramites_incidencias;

use App\Models\Empleado;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use App\Models\p12_tramites_incidencias\NotaBuena;
use App\Models\p12_tramites_incidencias\TipoCaptura;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\p12_tramites_incidencias\TramiteNotaBuena;
use App\Models\p15_asistencia\HorarioEmpleado;
use App\Models\Proceso;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait ManejadorTareas
{
    public function guardarTareaT01($tramiteIncidencia, $request) {
        if (in_array($tramiteIncidencia->tipo_tramite, ["INCIDENCIA_INDIVIDUAL", "INCIDENCIA_INDIVIDUAL_ADMIN"])) {
            $empleado = json_decode($request->datos_empleado);
        } else {
            $empleado = Empleado::where("rfc", Auth::user()->rfc)->first();
        }
        // Si es alta_nb, el empleado debe ser SINDICALIZADO
        $tipoCaptura = TipoCaptura::find($request->tipo_captura_id);

        if (empty((array) $empleado)) {
            return [
                "estatus" => false,
                "mensaje" => "El empleado no se encuentra dentro del Directorio."
            ];
        }
        if ($tipoCaptura->identificador == "alta_nb" && (!$empleado->es_sindicalizado)) {
            return [
                "estatus" => false,
                "mensaje" => "La aplicación de una nota buena solo aplica para empleados sindicalizados."
            ];
        }
        $tramiteIncidencia->tipo_captura_id = $request->tipo_captura_id;
        $tramiteIncidencia->rfc = $empleado->rfc;
        $tramiteIncidencia->numero_empleado = $empleado->numero_empleado; 
        $tramiteIncidencia->nombre = $empleado->nombre;
        $tramiteIncidencia->apellido_paterno = $empleado->apellido_paterno;
        $tramiteIncidencia->apellido_materno = $empleado->apellido_materno;
        $tramiteIncidencia->sexo = trim($empleado->sexo);
        $tramiteIncidencia->es_sindicalizado = $empleado->es_sindicalizado;
        $tramiteIncidencia->seccion_sindical = $empleado->seccion_sindical;
        $tramiteIncidencia->nomina = $empleado->nomina;
        $tramiteIncidencia->nivel_salarial = $empleado->nivel_salarial;
        $tramiteIncidencia->puesto =  $empleado->puesto;
        $tramiteIncidencia->codigo_puesto =  $empleado->codigo_puesto;
        $tramiteIncidencia->codigo_universo =  $empleado->codigo_universo;
        $tramiteIncidencia->zona_pagadora = $empleado->zona_pagadora;
        $tramiteIncidencia->codigo_situacion_empleado = $empleado->codigo_situacion_empleado ?? "";
        $tramiteIncidencia->turno = $empleado->turno ?? "";
        $tramiteIncidencia->tipo_empleado = $empleado->tipo_empleado;
        $tramiteIncidencia->fecha_alta_empleado = $empleado->fecha_alta_empleado;
        $tramiteIncidencia->unidad_administrativa = $empleado->unidad_administrativa;
        $tramiteIncidencia->unidad_administrativa_nombre = $empleado->unidad_administrativa_nombre;
        $tramiteIncidencia->save();

        return [
            "estatus" => true
        ];
    }
    
    public function guardarTareaT02aAltaIncidencia($tramiteIncidencia, $request) {
        $usuarioIniciador = $tramiteIncidencia->creadoPor;
        $usuarioEnlace = User::activo()->where("area_id", $tramiteIncidencia->area->area_id)->role("SUB_EA")->first();
        $usuarioDRH   = User::activo()->role("DRH")->first();
        $usuarioJUDRH = User::activo()->role("JUD_RH")->first();

        $firmas["EMPLEADO"] = [
            "nombre" => mb_strtoupper(trim("$tramiteIncidencia->nombre $tramiteIncidencia->apellido_paterno $tramiteIncidencia->apellido_materno")),
            "puesto" => $tramiteIncidencia->puesto,
            "numero_empleado" => $tramiteIncidencia->numero_empleado,
            "codigo_puesto" => $tramiteIncidencia->codigo_puesto,
            "fecha_alta_empleado" => $tramiteIncidencia->fecha_alta_empleado, 
            "unidad_administrativa" => trim($tramiteIncidencia->unidad_administrativa . " " . $tramiteIncidencia->unidad_administrativa_nombre ?? ""),
        ];
        $firmas["JEFE_INMEDIATO"] = [
            "nombre" => $request->nombre_jefe_inmediato,
            "puesto" => $request->cargo_jefe_inmediato
        ];
        $firmas["INICIADOR_INCIDENCIA"] = [
            "nombre" => $usuarioIniciador->nombre_completo,
            "puesto" => $usuarioIniciador->puesto
        ];
        $firmas["SUB_EA"] = [
            "nombre" => $usuarioEnlace->nombre_completo,
            "puesto" => $usuarioEnlace->puesto
        ];
        $firmas["DRH"] = [
            "nombre" => $usuarioDRH->nombre_completo,
            "puesto" => $usuarioDRH->puesto
        ];
        $firmas["JUD_RH"] = [
            "nombre" => $usuarioJUDRH->nombre_completo,
            "puesto" => $usuarioJUDRH->puesto
        ];

        $tramiteIncidencia->numero_documento = $request->numero_documento;
        $tramiteIncidencia->observaciones = $request->observaciones;
        $tramiteIncidencia->firmas = json_encode($firmas);
        $tramiteIncidencia->save();

        $incidenciaEmpleado = [
            "tramite_incidencia_id" => $tramiteIncidencia->tramite_incidencia_id,
            "tipo_captura_id" => $tramiteIncidencia->tipo_captura_id,
            "estatus" => "EN_PROCESO",
            "numero_documento" => $tramiteIncidencia->numero_documento,
            "rfc" => $tramiteIncidencia->rfc,
            "numero_empleado" => $tramiteIncidencia->numero_empleado,
            "nombre" => $tramiteIncidencia->nombre,
            "apellido_paterno" => $tramiteIncidencia->apellido_paterno,
            "apellido_materno" => $tramiteIncidencia->apellido_materno,
            "sexo" => $tramiteIncidencia->sexo,
            "es_sindicalizado" => $tramiteIncidencia->es_sindicalizado,
            "seccion_sindical" => $tramiteIncidencia->seccion_sindical,
            "nomina" => $tramiteIncidencia->nomina,
            "nivel_salarial" => $tramiteIncidencia->nivel_salarial,
            "codigo_situacion_empleado" => $tramiteIncidencia->codigo_situacion_empleado,
            "puesto" =>  $tramiteIncidencia->puesto,
            "codigo_puesto" =>  $tramiteIncidencia->codigo_puesto,
            "codigo_universo" =>  $tramiteIncidencia->codigo_universo,
            "zona_pagadora" => $tramiteIncidencia->zona_pagadora,
            "turno" => $tramiteIncidencia->turno,
            "tipo_empleado" => $tramiteIncidencia->tipo_empleado,
            "fecha_alta_empleado" => $tramiteIncidencia->fecha_alta_empleado,
            "unidad_administrativa" => $tramiteIncidencia->unidad_administrativa,
            "unidad_administrativa_nombre" => $tramiteIncidencia->unidad_administrativa_nombre,
            "tipo_incidencia_id" => $request->tipo_incidencia_id,
            "observaciones" => $tramiteIncidencia->observaciones,
            "firmas" => $tramiteIncidencia->firmas,
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_final" => $request->fecha_final,
            "fechas" => $request->fechas,
            "total_dias" => $request->total_dias
        ];
        

        $tipoIncidencia = TipoIncidencia::find($request->tipo_incidencia_id);

        if ($tipoIncidencia->tipoJustificacion->identificador == "cambio_horario") {
            // Comprobar que no haya ninguna incidencia abierta de este tipo para este empleado. 
            $incidenciaAbierta = IncidenciaEmpleado::where([
                "rfc" => $tramiteIncidencia->rfc,
                "numero_empleado" => $tramiteIncidencia->numero_empleado
            ])
            ->whereHas("tramiteIncidencia", function (Builder $query) {
                $query->where("estatus", "EN_PROCESO");
            })
            ->whereHas("tipoIncidencia.tipoJustificacion", function (Builder $query) {
                $query->where("identificador", "cambio_horario");
            })
            ->first();

            if ($incidenciaAbierta) {
                $message = "Ya existe una solicitud de cambio de horario con el FOLIO: {$incidenciaAbierta->tramiteIncidencia->folio} para el empleado con el RFC: {$tramiteIncidencia->rfc}";
                $code = 1;
                throw new Exception($message, $code);
            }
            
            $incidenciaEmpleado["horario_id"] = $request->horario_id;
        } 
        
        return IncidenciaEmpleado::create($incidenciaEmpleado);   
    }

    public function guardarTareaT02aplicacionNotasBuenas($tramiteIncidencia, $request) {
        $usuarioIniciador = $tramiteIncidencia->creadoPor;
        $usuarioEnlace = User::activo()->where("area_id", $tramiteIncidencia->area->area_id)->role("SUB_EA")->first();
        $usuarioDRH   = User::activo()->role("DRH")->first();
        $usuarioJUDRH = User::activo()->role("JUD_RH")->first();

        $firmas["EMPLEADO"] = [
            "nombre" => mb_strtoupper(trim("$tramiteIncidencia->nombre $tramiteIncidencia->apellido_paterno $tramiteIncidencia->apellido_materno")),
            "puesto" => $tramiteIncidencia->puesto,
            "numero_empleado" => $tramiteIncidencia->numero_empleado,
            "codigo_puesto" => $tramiteIncidencia->codigo_puesto,
            "fecha_alta_empleado" => $tramiteIncidencia->fecha_alta_empleado, 
            "unidad_administrativa" => trim($tramiteIncidencia->unidad_administrativa . " " . $tramiteIncidencia->unidad_administrativa_nombre ?? ""),
        ];
        $firmas["JEFE_INMEDIATO"] = [
            "nombre" => $request->nombre_jefe_inmediato,
            "puesto" => $request->cargo_jefe_inmediato
        ];
        $firmas["INICIADOR_INCIDENCIA"] = [
            "nombre" => $usuarioIniciador->nombre_completo,
            "puesto" => $usuarioIniciador->puesto
        ];
        $firmas["SUB_EA"] = [
            "nombre" => $usuarioEnlace->nombre_completo,
            "puesto" => $usuarioEnlace->puesto
        ];
        $firmas["DRH"] = [
            "nombre" => $usuarioDRH->nombre_completo,
            "puesto" => $usuarioDRH->puesto
        ];
        $firmas["JUD_RH"] = [
            "nombre" => $usuarioJUDRH->nombre_completo,
            "puesto" => $usuarioJUDRH->puesto
        ];
        $tramiteIncidencia->numero_documento = $request->numero_documento;
        $tramiteIncidencia->observaciones = $request->observaciones;
        $tramiteIncidencia->firmas = json_encode($firmas);
        $tramiteIncidencia->save();

        $aplicacionesNB = json_decode($request->aplicaciones_notas_buenas);
        
        // TRAMITE DE NOTAS BUENAS 
        // Crear trámite de nota buena 
        $tramiteNotaBuena = TramiteNotaBuena::create([
            "estatus" => "EN_PROCESO",
            "area_id"=> $tramiteIncidencia->area_id,
            "tramite_incidencia_id"=> $tramiteIncidencia->tramite_incidencia_id,
        ]);
        $instancia = $this->crearInstancia("notas_buenas", $tramiteNotaBuena, Auth::user()->area);
        $tramiteIncidencia->numero_documento = $instancia->folio;
        $tramiteIncidencia->save();

        foreach ($aplicacionesNB as $aplicacionNB) {
            $identificadoresNotaBuena = [
                "RETARDO_LEVE" => "nota_buena_retardo_leve",
                "RETARDO_GRAVE" => "nota_buena_retardo_grave",
                "INASISTENCIA" => "nota_buena_inasistencia",
            ];
            $tipoIncidencia = TipoIncidencia::activo()->whereHas("tipoJustificacion", function ($query) use ($identificadoresNotaBuena, $aplicacionNB) {
                $query->where("identificador", $identificadoresNotaBuena[$aplicacionNB->tipo_aplicacion]);
            })->first();
            $incidenciaEmpleado = IncidenciaEmpleado::create([
                "tramite_incidencia_id" => $tramiteIncidencia->tramite_incidencia_id,
                "tramite_nota_buena_id"=> $tramiteNotaBuena->tramite_nota_buena_id,
                "tipo_captura_id" => $tramiteIncidencia->tipo_captura_id,
                "estatus" => "EN_PROCESO",
                "numero_documento" => $tramiteIncidencia->numero_documento,
                "rfc" => $tramiteIncidencia->rfc, 
                "numero_empleado" => $tramiteIncidencia->numero_empleado, 
                "nombre" => $tramiteIncidencia->nombre,
                "apellido_paterno" => $tramiteIncidencia->apellido_paterno,
                "apellido_materno" => $tramiteIncidencia->apellido_materno,
                "sexo" => $tramiteIncidencia->sexo,
                "es_sindicalizado" => $tramiteIncidencia->es_sindicalizado,
                "seccion_sindical" => $tramiteIncidencia->seccion_sindical,
                "nomina" => $tramiteIncidencia->nomina,
                "nivel_salarial" => $tramiteIncidencia->nivel_salarial,
                "codigo_situacion_empleado" => $tramiteIncidencia->codigo_situacion_empleado,
                "puesto" =>  $tramiteIncidencia->puesto,
                "codigo_puesto" =>  $tramiteIncidencia->codigo_puesto,
                "codigo_universo" =>  $tramiteIncidencia->codigo_universo,
                "zona_pagadora" => $tramiteIncidencia->zona_pagadora,
                "turno" => $tramiteIncidencia->turno,
                "tipo_empleado" => $tramiteIncidencia->tipo_empleado,
                "fecha_alta_empleado" => $tramiteIncidencia->fecha_alta_empleado,
                "unidad_administrativa" => $tramiteIncidencia->unidad_administrativa,
                "unidad_administrativa_nombre" => $tramiteIncidencia->unidad_administrativa_nombre,
                "tipo_incidencia_id" => $tipoIncidencia->tipo_incidencia_id,
                "fechas" => json_encode($aplicacionNB->fechas),
                "total_dias" => count($aplicacionNB->fechas),
                "observaciones" => $tramiteIncidencia->observaciones,
                "firmas" => $tramiteIncidencia->firmas,
            ]);  
            foreach ($aplicacionNB->notas_buenas as $notaBuena) {
                NotaBuena::create([
                    "periodo" => explode(" | ", $notaBuena)[0],
                    "tipo"  => explode(" | ", $notaBuena)[1],
                    "incidencia_empleado_id" => $incidenciaEmpleado->incidencia_empleado_id
                ]);
            }    
        }

        return true;
    }

    public function guardarTareaT02CancelacionIncidencia($tramiteIncidencia, $request) {
        $usuarioIniciador = $tramiteIncidencia->creadoPor;
        $usuarioEnlace = User::activo()->where("area_id", $tramiteIncidencia->area->area_id)->role("SUB_EA")->first();
        $usuarioDRH   = User::activo()->role("DRH")->first();
        $usuarioJUDRH = User::activo()->role("JUD_RH")->first();

        $firmas["EMPLEADO"] = [
            "nombre" => mb_strtoupper(trim("$tramiteIncidencia->nombre $tramiteIncidencia->apellido_paterno $tramiteIncidencia->apellido_materno")),
            "puesto" => $tramiteIncidencia->puesto,
            "numero_empleado" => $tramiteIncidencia->numero_empleado,
            "codigo_puesto" => $tramiteIncidencia->codigo_puesto,
            "fecha_alta_empleado" => $tramiteIncidencia->fecha_alta_empleado, 
            "unidad_administrativa" => trim($tramiteIncidencia->unidad_administrativa . " " . $tramiteIncidencia->unidad_administrativa_nombre ?? ""),
        ];
        $firmas["JEFE_INMEDIATO"] = [
            "nombre" => $request->nombre_jefe_inmediato,
            "puesto" => $request->cargo_jefe_inmediato
        ];
        $firmas["INICIADOR_INCIDENCIA"] = [
            "nombre" => $usuarioIniciador->nombre_completo,
            "puesto" => $usuarioIniciador->puesto
        ];
        $firmas["SUB_EA"] = [
            "nombre" => $usuarioEnlace->nombre_completo,
            "puesto" => $usuarioEnlace->puesto
        ];
        $firmas["DRH"] = [
            "nombre" => $usuarioDRH->nombre_completo,
            "puesto" => $usuarioDRH->puesto
        ];
        $firmas["JUD_RH"] = [
            "nombre" => $usuarioJUDRH->nombre_completo,
            "puesto" => $usuarioJUDRH->puesto
        ];

        $tramiteIncidencia->numero_documento = $request->numero_documento;
        $tramiteIncidencia->motivo_cancelacion = $request->motivo_cancelacion;
        $tramiteIncidencia->firmas = json_encode($firmas);
        $tramiteIncidenciaAsociado = json_decode($request->tramite_incidencia);


        if (isset($tramiteIncidenciaAsociado->id_proc)) {
            $tramiteIncidenciaAsociado->tipoCaptura = $tramiteIncidenciaAsociado->tipo_captura;
            $tramiteIncidenciaAsociado->incidenciasEmpleado = $tramiteIncidenciaAsociado->incidencias_empleado;
            foreach ($tramiteIncidenciaAsociado->incidenciasEmpleado as $item) {
                $item->tramiteIncidencia = $item->tramite_incidencia;            
                $item->tipoIncidencia = $item->tipo_incidencia;            
                $item->tipoCaptura = $item->tipo_captura;            
                $item->notasBuenas = $item->notas_buenas;            
                if (isset($item->tipoIncidencia->tipo_justificacion)) {
                    $item->tipoIncidencia->tipoJustificacion = $item->tipoIncidencia->tipo_justificacion;
                }
                if (isset($item->tramiteIncidencia->tipo_captura)) {
                    $item->tramiteIncidencia->tipoCaptura = $item->tramiteIncidencia->tipo_captura;
                }
            }
            $tramiteIncidencia->tramite_incidencia_asociado_historico = json_encode($tramiteIncidenciaAsociado);
            $tramiteIncidencia->tramite_incidencia_asociado_historico_folio = $tramiteIncidenciaAsociado->folio;
            $tramiteIncidencia->save();
        } else {
            $tramiteIncidencia->tramite_incidencia_asociado_id = $tramiteIncidenciaAsociado->tramite_incidencia_id;
            $tramiteIncidencia->save();
            $incidenciasEmpleado = collect($tramiteIncidenciaAsociado->incidencias_empleado)->pluck("incidencia_empleado_id");
            $tramiteIncidencia->incidenciasEmpleadoCancelacion()->attach($incidenciasEmpleado);
        }
        
        return true;
    }
    

    public function guardarTareaT01IncidenciaGrupalTipoCaptura($tramiteIncidencia, $request) {
        $tramiteIncidencia->tipo_captura_id = $request->tipo_captura_id;
        $tramiteIncidencia->save();
        return true;
    }

    public function guardarTareaT02GrupoIncidenciaAlta($tramiteIncidencia, $request) {        
        $empleadosIncidencias = json_decode($request->empleados);
        foreach ($empleadosIncidencias as $empleado) {
            IncidenciaEmpleado::create([
                "tramite_incidencia_id" => $tramiteIncidencia->tramite_incidencia_id,
                "tipo_captura_id" => $tramiteIncidencia->tipo_captura_id,
                "estatus" => "EN_PROCESO",
                "numero_documento" => $request->numero_documento,
                "rfc" => $empleado->rfc, 
                "numero_empleado" => $empleado->numero_empleado, 
                "nombre" => $empleado->nombre,
                "apellido_paterno" => $empleado->apellido_paterno,
                "apellido_materno" => $empleado->apellido_materno,
                "sexo" => $empleado->sexo,
                "es_sindicalizado" => $empleado->es_sindicalizado,
                "seccion_sindical" => $empleado->seccion_sindical,
                "nomina" => $empleado->nomina,
                "nivel_salarial" => $empleado->nivel_salarial,
                "codigo_situacion_empleado" => $empleado->codigo_situacion_empleado,
                "puesto" =>  $empleado->puesto,
                "codigo_puesto" =>  $empleado->codigo_puesto,
                "codigo_universo" =>  $empleado->codigo_universo,
                "zona_pagadora" => $empleado->zona_pagadora,
                "turno" => $empleado->turno ?? "",
                "tipo_empleado" => $empleado->tipo_empleado,
                "fecha_alta_empleado" => $empleado->fecha_alta_empleado,
                "unidad_administrativa" => $empleado->unidad_administrativa,
                "unidad_administrativa_nombre" => $empleado->unidad_administrativa_nombre,
                "tipo_incidencia_id" => $request->tipo_incidencia_id,
                "observaciones" =>  $request->observaciones,
                "firmas" => $tramiteIncidencia->firmas,
                "fecha_inicio" => $request->fecha_inicio,
                "fecha_final" => $request->fecha_final,
                "fechas" => $request->fechas,
                "total_dias" => $request->total_dias,
                "horario_id" => $request->horario_id
            ]);
        };

        $tramiteIncidencia->empleados = $empleadosIncidencias;
        $tramiteIncidencia->numero_documento = $request->numero_documento;
        $tramiteIncidencia->observaciones = $request->observaciones;
        return $tramiteIncidencia->save();
    }
    
    public function guardarTareaT02GrupoIncidenciaCancelacionIncidencia($tramiteIncidencia, $request) {
        $tramiteIncidenciaAsociado = json_decode($request->tramite_incidencia);
        $tramiteIncidencia->tramite_incidencia_asociado_id = $tramiteIncidenciaAsociado->tramite_incidencia_id;
        $tramiteIncidencia->tipo_cancelacion = $request->tipo_cancelacion;
        $tramiteIncidencia->numero_documento = $request->numero_documento;
        $tramiteIncidencia->motivo_cancelacion = $request->motivo_cancelacion;
        return $tramiteIncidencia->save();
    }
    
    public function guardarTareaT03GrupoIncidenciaCancelacionEmpleados($tramiteIncidencia, $request) {
        $incidenciasEmpleado = collect(json_decode($request->empleados_a_cancelar))->pluck("incidencia_empleado_id");
        $tramiteIncidencia->incidenciasEmpleadoCancelacion()->attach($incidenciasEmpleado);

        return true;
    }
}
