<?php

namespace App\Http\Utils\procesos\asistencias;

use App\Http\Servicios\Biometrico as ServiciosBiometrico;
use App\Models\p15_asistencia\Biometrico;
use App\Models\p15_asistencia\BiometricoArchivo;
use App\Models\p15_asistencia\Evento;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class RecuperarEventos {
    use ServiciosBiometrico;

    private $fechaInicio;
    private $fechaFinal;

    public function __construct($fechaInicio, $fechaFinal) {
        $this->fechaInicio = Carbon::parse($fechaInicio);
        $this->fechaFinal = Carbon::parse($fechaFinal);
    }

    public function recuperar() {
        // Recuperar eventos biométricos dactilares
        $biometricos = Biometrico::activo()->get();
        foreach ($biometricos as $biometrico) {
            $archivos = Storage::disk("sica")->allFiles("$biometrico->ip/Descargas");
            foreach ($archivos as $nombreArchivo) {
                $fechaArchivo = explode("-", $nombreArchivo)[1];
                $fechaArchivo = Carbon::createFromFormat("Ymd", $fechaArchivo);            
                if ($fechaArchivo->between($this->fechaInicio->startOfDay(), $this->fechaFinal->endOfDay())) {
                    $rutaArchivo = Storage::disk("sica")->path($nombreArchivo);
                    $biometricoArchivo = BiometricoArchivo::where([
                        "biometrico_id" => $biometrico->biometrico_id,
                        "fecha" => $fechaArchivo,
                        "nombre" => basename($nombreArchivo)
                    ])->first();
                    if (!$biometricoArchivo) {
                        $biometricoArchivo = BiometricoArchivo::updateOrCreate([
                            "biometrico_id" => $biometrico->biometrico_id,
                            "fecha" => $fechaArchivo,
                            "nombre" => basename($nombreArchivo),
                            "ruta" => $rutaArchivo,
                            "disco" => "sica"
                        ]);
                    }
                    $contenidoArchivo = Storage::disk("sica")->get($nombreArchivo);
                    $lineas = explode("\n", $contenidoArchivo);
                    foreach ($lineas as $linea) {
                        $datosEvento = array_values(array_filter(explode(".", $linea)));
                        $estructuraValida = count($datosEvento) == 5;
                        if ($estructuraValida) {
                            $fechaEvento = Carbon::createFromFormat("d/m/y H:i:s", "$datosEvento[1] $datosEvento[2]"); 
                            $numeroEmpleado = $datosEvento[3];
                            $evento = Evento::where([
                                "fecha" => $fechaEvento,
                                "numero_empleado" => $numeroEmpleado,
                                "biometrico_id" => $biometrico->biometrico_id
                            ])->first();
                            if (!$evento) {
                                $evento = Evento::create([
                                    "fecha" => $fechaEvento,
                                    "numero_empleado" => $numeroEmpleado,
                                    "biometrico_id" => $biometrico->biometrico_id,
                                    "biometrico_archivo_id" => $biometricoArchivo->biometrico_archivo_id
                                ]); 
                            }
                        } 
                    }
                }
            }
        }
        // Recuperar eventos biométricos faciales
        $eventosEmpleados = $this->servBiometricoGetEventos($this->fechaInicio->startOfDay(), $this->fechaFinal->endOfDay());
        foreach ($eventosEmpleados as $eventoEmpleado) {
            $biometrico = Biometrico::where([
                "nombre" => $eventoEmpleado["biometrico"]["nombre"],
                "acceso" => $eventoEmpleado["biometrico"]["acceso"],
            ])->first();
            if (!$biometrico) {
                $biometrico = Biometrico::create([
                    "nombre" => $eventoEmpleado["biometrico"]["nombre"],
                    "acceso" => $eventoEmpleado["biometrico"]["acceso"],
                    "ip" => $eventoEmpleado["biometrico"]["ip"],
                    "ubicacion" => $eventoEmpleado["biometrico"]["ubicacion"],
                    "tipo" => $eventoEmpleado["biometrico"]["tipo"],
                ]);
            }
            $evento = Evento::where([
                "fecha" => $eventoEmpleado["fecha"],
                "rfc" => $eventoEmpleado["rfc"],
                "numero_empleado" => $eventoEmpleado["numero_empleado"],
                "biometrico_id" => $biometrico->biometrico_id
            ])->first();
            if (!$evento) {
                $evento = Evento::create([
                    "fecha" => $eventoEmpleado["fecha"],
                    "rfc" => $eventoEmpleado["rfc"],
                    "numero_empleado" => $eventoEmpleado["numero_empleado"],
                    "biometrico_id" => $biometrico->biometrico_id
                ]); 
            }
        }
    }
}
       
