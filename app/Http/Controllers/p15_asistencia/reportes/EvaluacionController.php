<?php

namespace App\Http\Controllers\p15_asistencia\reportes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\p15_asistencia\general\GestionAsistencia;
use App\Http\Traits\Servicios\Biometrico;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    use Biometrico;

    public function index(Request $request) {
        $fechaInicio = Carbon::parse("2023-08-01");
        $fechaFinal = Carbon::parse("2023-08-10");
        $resp = $this->servBiometricoGetEventos($fechaInicio->copy(), $fechaFinal->copy());

        $evaluacionesEmpleados = [];
        foreach ($resp["empleados_eventos"] as $empleadoEventos) {
            $empleado = (object) [
                "rfc" => array_values($empleadoEventos)[0][0]["rfc"],
                "numero_empleado" => array_values($empleadoEventos)[0][0]["numero_empleado"],
            ];
            // Agregar las fechas que no tienen horario al arreglo de $eventos
            $periodo = CarbonPeriod::create($fechaInicio->copy(), $fechaFinal->copy());
            foreach ($periodo as $fecha) {
                if (!isset($empleadoEventos[$fecha->format("Y-m-d")])) {
                    $empleadoEventos[$fecha->format("Y-m-d")] = [];
                }
            }

            $gestionAsistencia = new GestionAsistencia();
            $evaluaciones = $gestionAsistencia->getEvaluacion($empleado, $fechaInicio->copy(), $fechaFinal->copy(), $conIncidencias = true);
            
            $evaluacionesEmpleados[] = [
                "rfc" => $empleado->rfc,
                "numero_empleado" => $empleado->numero_empleado,
                "evaluaciones" => $evaluaciones
            ]; 
        }
        
        dd($evaluacionesEmpleados);
        
        /* dd($resp); */
        return "hola";
    }
}
