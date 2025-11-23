<?php

namespace App\Http\Servicios;

use Carbon\CarbonInterval;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

trait Biometrico
{
    public function servBiometricoGetEventosEmpleado($empleado, $fechaInicio, $fechaFinal) {
        $urlServicio = Config::get('services.eventos_biometricos.url');
        $endpoint = Config::get('services.eventos_biometricos.endpoints.get_eventos_empleado');
        $urlGetEventosEmpleado = "$urlServicio/$endpoint";
        $token = Config::get('services.eventos_biometricos.token');
        $queryParams = [
            "TokenId" => $token,
            "rfc" => $empleado->rfc,
            "num_empleado" => (string) ($empleado->numero_empleado)
        ];

        // SOLICITAR EVALUACIÓNES EN RANGOS DE 3 MESES
        $intervalo = CarbonInterval::days(80);
        $subperiodos = [];
        while ($fechaInicio->lessThanOrEqualTo($fechaFinal)) {
            $fechaFinSubperiodo = $fechaInicio->copy()->add($intervalo);            
            // Asegurarse de que la fecha de fin del subperíodo no exceda la fecha de fin global
            if ($fechaFinSubperiodo->greaterThan($fechaFinal)) {
                $fechaFinSubperiodo = $fechaFinal;
            }
            $subperiodos[] = [
                'fecha_inicio' => $fechaInicio->copy()->setTime(0, 0, 0)->format("Y-m-d H:i:s"),
                'fecha_final' => $fechaFinSubperiodo->setTime(23, 59, 59)->format("Y-m-d H:i:s")
            ];
            // Avanzar la fecha de inicio por el intervalo de tiempo
            $fechaInicio->add($intervalo)->addDay();
        }
        try {
            $eventos = [];
            foreach ($subperiodos as $subperiodo) {
                $queryParams["fecha_inicial"] = $subperiodo["fecha_inicio"];
                $queryParams["fecha_final"] = $subperiodo["fecha_final"];
                $response = Http::withOptions([
                    "verify" => false, 
                ])->post($urlGetEventosEmpleado, $queryParams)->json();
                $estatus = $response["success"];
                $code = $response["respuesta"]["code"];
                $message = $response["respuesta"]["msg"];
                // Manejo de errores
                if (!$estatus && $code != 8) {
                    switch ($code) {
                        case 4:
                            dd($subperiodo);
                            $message = "El rango de fechas es mayor a tres meses.";
                            break;
                        case 6:
                            $message = "El empleado con el RFC: {$empleado->rfc} no está registrado en el sistema de Asistencias.";
                            break;
                    } 
                    throw new Exception($message, $code);
                } else {
                    $eventos = array_merge($eventos, $response["body"]["asistencias"]);
                } 
            }
        } catch (Exception $e) {
            if ($e->getCode() == 6) {
                return [
                    "estatus" => true, 
                    "eventos" => []
                ];
            }
            throw new Exception($e->getMessage(), $e->getCode());
        }
        
        $eventos = collect($eventos)->map(function ($item) {
            return [
                "id" => $item["id_asistencia"],
                "fecha" => $item["fecha_asistencia"],
                "biometrico" => [
                    "ip" => "",
                    "ubicacion" => $item["nombre_checador"],
                    "tipo" => "facial",
                ],
                "acceso" => $item["nombre_acceso"],
                "estatus" => $item["tipo_evento_asistencia_empleado"],
            ];
        })->toArray();
    
        return [
            "estatus" => true, 
            "eventos" => $eventos
        ];
    }

    public function servBiometricoGetEventos($fechaInicio, $fechaFinal) {
        $urlServicio = Config::get('services.eventos_biometricos.url');
        $endpoint = Config::get('services.eventos_biometricos.endpoints.get_eventos');
        $urlGetEventos = "$urlServicio/$endpoint";
        $token = Config::get('services.eventos_biometricos.token');
        $queryParams = [
            "TokenId" => $token,
            "fecha_inicial" => $fechaInicio->format("Y-m-d H:i:s"),
            "fecha_final" => $fechaFinal->format("Y-m-d H:i:s")
        ];
        $response = Http::withOptions([
            "verify" => false, 
        ])->post($urlGetEventos, $queryParams)->json();
        $estatus = $response["success"];
        $code = $response["respuesta"]["code"];
        $message = $response["respuesta"]["msg"];
        if (!$estatus) {
            throw new Exception($message, $code);
        } 
        $eventos = collect($response["body"])->map(function ($item) {
            return [
                "evento_id" => $item["id_asistencia"],
                "usuario_citizen_id" => $item["usuario_citizen_id"],
                "fecha" => $item["fecha_asistencia"],
                "rfc" => $item["rfc"],
                "numero_empleado" => $item["num_empleado"],
                "nombre" => $item["nombre"],
                "apellido_paterno" => $item["apellido_paterno"],
                "apellido_materno" => $item["apellido_materno"],
                "biometrico" => [
                    "nombre" => $item["nombre_checador"],
                    "acceso" => $item["nombre_acceso"],
                    "ip" => null,
                    "tipo" => "FACIAL",
                    "ubicacion" => $item["nombre_checador"]
                ],
                "estatus" => $item["tipo_evento_asistencia_empleado"],
            ];
        });
        return $eventos; 
    }
    
    public function servBiometricoGetImagenEvento($eventoId) {
        $urlServicio = Config::get('services.eventos_biometricos.url');
        $endpoint = Config::get('services.eventos_biometricos.endpoints.get_imagen_evento');
        $urlGetImagenEvento = "$urlServicio/$endpoint";
        $token = Config::get('services.eventos_biometricos.token');
        $queryParams = [
            "TokenId" => $token,
            "id_asistencia" => $eventoId,
        ];

        /* try { */
            $response = Http::withOptions([
                "verify" => false, 
                /* "timeout" => 2, 
                "connect_timeout" => 2 */
            ])->post($urlGetImagenEvento, $queryParams)->json();
            $estatus = $response["success"];
            $code = $response["respuesta"]["code"];
            $message = $response["respuesta"]["msg"];
            // Manejo de errores
            if (!$estatus) {
                throw new Exception($message, $code);
            } 
        /* } catch (Exception $e) {
            $eventos = [];
        } */
            
        return [
            "estatus" => true, 
            "imagen" => $response["body"]["foto_audit"]
        ];
    }

}