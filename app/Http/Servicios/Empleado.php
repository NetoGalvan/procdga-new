<?php

namespace App\Http\Servicios;

use App\Models\p24_directorio\AlfabeticoMain;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

trait Empleado
{

    // Uso:
        /*
        En su Controller
        use App\Http\Traits\Servicios\Empleado;
        use Empleado;

        $rfc = "GACE841222DH0";
        $resp = $this->servGetDatosEmpleado($rfc); */

        // Respuesta original:
        /*
        "error" => array:2 [▼
            "msg" => "Datos obtenidos correctamente"
            "code" => 0
        ]
        "data" => array:20 [▼
            "COD_PUESTO_CVE_ACT" => "PTT078"
            "FECHAINICIOREALLABORAL" => "2019-07-16"
            "NombreUsuario" => "ERNESTO GALVAN CHAVEZ"
            "COMISION_SIND" => null
            "UNIDAD_ADM" => "11"
            "ANTIGUEDAD" => null
            "RFC" => "GACE841222DH0"
            "CURP" => "GACE841222HDFLHR00"
            "SINDICATO" => "NO ESPECIFICADO"
            "SINDICALIZADO" => "No"
            "NIVEL_SALARIAL" => "1026"
            "ZONA_PAGADORA" => "1100000"
            "NUM_PLAZA" => "16512309"
            "UNIVERSO" => "P"
            "N_PUESTO_ACT_ASOC_PROG" => null
            "Genero" => "H"
            "NUMEMPLEADO" => "1107925"
            "N_UNIDAD_ADM" => "TESORERIA DE LA CIUDAD DE MÉXICO"
            "TIPOCONTRATO" => "Trabajador FP"
            "status" => "Activo"
        ]
        */

        // Respuesta ajustada:
        /*
        ---BIEN---
        "estatus" => true
        "empleado" => array:20 [▼
            "numero_empleado" => "1107925"
            "plaza_id" => "16512309"
            "nombre_completo" => "ERNESTO GALVAN CHAVEZ"
            "rfc" => "GACE841222DH0"
            "curp" => "GACE841222HDFLHR00"
            "sexo" => "H"
            "unidad_administrativa" => "11"
            "nombre_unidad_administrativa" => "TESORERIA DE LA CIUDAD DE MÉXICO"
            "tipo_nomina" => "Trabajador FP"
            "universo" => "P"
            "nivel_salarial" => "1026"
            "nombre_puesto" => "PTT078"
            "descripcion_puesto" => null
            "seccion_sindical" => "NO ESPECIFICADO"
            "fecha_alta_empleado" => "2019-07-16"
            "zona_pagadora" => "1100000"
            "antiguedad" => null
            "sindicalizado" => "No"
            "comision_sindical" => null
            "estatus" => "Activo"
        ]
        "mensaje" => "Datos obtenidos correctamente"
        "estatus_servicio" => 200
        "estatus_servidor" => false

        ---MAL---
        "estatus" => false
        "empleado" => []
        "mensaje" => "sin datos"
        "estatus_servicio" => 200
        "estatus_servidor" => false
        */

        // Errores comunes:
        /*
        "error" => array:2 [▼
            "msg" => "sin datos"
            "code" => 1 // CUANDO SE ENVÍA UN RFC Y NO ENCUENTRA DATOS
        ]
        "error" => array:2 [▼
            "msg" => "Sin acceso, consulta con tu administrador quedará registro de la solicitud"
            "code" => 0 // PROBLEMAS CON EL REQUEST, TOKEN o URL
        ]
        */
        
    public function servGetDatosEmpleado($rfc) {
        $empleado = AlfabeticoMain::where("rfc", $rfc)->first();
        if ($empleado) {
            $campos = [
                'numero_empleado',
                'numero_plaza',
                'nombre_completo',
                'nombre',
                'apellido_paterno',
                'apellido_materno',
                'rfc',
                'curp',
                'sexo',
                'unidad_administrativa',
                'unidad_administrativa_nombre', 
                'nomina',
                'codigo_universo',
                'nivel_salarial',
                'puesto',
                'codigo_puesto',
                'descripcion_puesto',
                'codigo_situacion_empleado',
                'es_sindicalizado',
                'seccion_sindical',
                'fecha_alta_empleado',
                'zona_pagadora',
                'fecha_antiguedad',
                'comision_sindical',
                'estatus',
            ];
            $data = [];
            foreach ($campos as $value) {
                if (array_key_exists($value, $empleado->toArray()) ) {
                    if ($value == "seccion_sindical") {
                        $data["seccion_sindical"] = $empleado->toArray()[$value];
                        $data["es_sindicalizado"] = $empleado->toArray()[$value] != 0;
                    } else {
                        $data[$value] = $empleado->toArray()[$value];
                    }
                } else {
                    $data[$value] = null;
                }
            }
            $resp = [
                "estatus" => true,
                "empleado" => $data,
                "mensaje" => "Datos obtenidos correctamente",
                "estatus_servicio" => 200,
                "estatus_servidor" => false,
            ];
        } else {
            $url = Config::get('services.consulta_empleado.url');
            $token = Config::get('services.consulta_empleado.token');

            $relacionCampos = [
                'numero_empleado' => 'NUMEMPLEADO',
                'numero_plaza' => 'NUM_PLAZA',
                'nombre_completo' => 'NombreUsuario',
                'nombre' => 'nombres',
                'apellido_paterno' => 'apellidoPaterno',
                'apellido_materno' => 'apellidoMaterno',
                'rfc' => 'RFC',
                'curp' => 'CURP',
                'sexo' => 'Genero',
                'unidad_administrativa' => 'UNIDAD_ADM',
                'unidad_administrativa_nombre' => 'N_UNIDAD_ADM',
                'nomina' => 'TIPOCONTRATO',
                'codigo_universo' => 'UNIVERSO',
                'nivel_salarial' => 'NIVEL_SALARIAL',
                'puesto' => 'PUESTO',
                'codigo_puesto' => 'COD_PUESTO_CVE_ACT',
                'descripcion_puesto' => 'N_PUESTO_ACT_ASOC_PROG',
                'codigo_situacion_empleado' => null,
                'es_sindicalizado' => 'SINDICALIZADO',
                'seccion_sindical' => 'SINDICATO',
                'fecha_alta_empleado' => 'FECHAINICIOREALLABORAL',
                'zona_pagadora' => 'ZONA_PAGADORA',
                'fecha_antiguedad' => 'ANTIGUEDAD',
                'comision_sindical' => 'COMISION_SIND',
                'estatus' => 'status',
            ];

            $request = [
                "security" => [
                    "tokenId" => $token
                ],
                "data" => [
                    "RFC" => $rfc
                ]
            ];

            $response = Http::withOptions(['verify' => false])->post($url, $request);

            $data = [];
            if ( isset($response->json()['data']) ) {
                foreach ($relacionCampos as $key => $value ) {
                    if (array_key_exists($value, $response->json()['data']) ) {
                        if ($key == "sexo") {
                            $sexos = [
                                "H" => "M",
                                "M" => "F"
                            ];
                            $data[$key] = $sexos[$response->json()['data'][$value]];
                        } else if ($key == "es_sindicalizado") {
                            $data[$key] = $response->json()['data']["SINDICALIZADO"] == "Si";
                        } else if ($key == "seccion_sindical") {
                            $data[$key] = $response->json()['data']["SINDICALIZADO"] == "Si" ? $response->json()['data']["SINDICATO"] : 0; 
                        } else if ($key == "fecha_alta_empleado") {
                            try {
                                new DateTime($response->json()['data'][$value]);
                                $data[$key] = $response->json()['data'][$value];
                            } catch (Exception $e) {
                                $data[$key] = null;
                            }
                        } else {
                            $data[$key] = $response->json()['data'][$value];
                        }
                    }
                }
            }
            
            $resp = [
                "estatus"   => count($data) > 0,
                "empleado"  => $data,
                "mensaje"   => $response->json()['error']['msg'], // mensaje del servicio
                "estatus_servicio" => $response->status(), // Este nos permite ver el status de la petición si es correcta regresa un 200
                "estatus_servidor" => $response->serverError(), // Este nos permite ver el status del servidor true o false y validar si es problema de ellos o nuestro
            ];
        }

        return $resp;
    }
}
