<?php

namespace App\Http\Utils\procesos\asistencias;

use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\p15_asistencia\Evento;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use App\Models\p15_asistencia\DiaFestivoFecha;
use App\Models\p15_asistencia\Evaluacion;
use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioEmpleado;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class EvaluarAsistenciaEmpleado {
    const FORMATO_FECHA = "Y-m-d";
    const SIN_EVALUACION = "SIN_EVALUACION";
    const POR_EVALUAR = "POR_EVALUAR";
    const DIA_INHABIL = "DIA_INHABIL";
    const DIA_FESTIVO = "DIA_FESTIVO";
    const ASISTENCIA = "ASISTENCIA";
    const FALTA = "FALTA";
    const RETARDO_LEVE = "RETARDO_LEVE";
    const RETARDO_GRAVE = "RETARDO_GRAVE";

    private $empleado;
    private $fechaInicio;
    private $fechaFinal;

    public function __construct($empleado, $fechaInicio, $fechaFinal) {
        $this->empleado = $empleado;
        $this->fechaInicio = Carbon::parse($fechaInicio);
        $this->fechaFinal = Carbon::parse($fechaFinal);
    }

    public function evaluar() { 
        $evaluacionesFechas = []; 
        // OBTENER LOS DÍAS FESTIVOS
        $diasFestivosFechas = $this->getDiasFestivos();
        // OBTENER EL HORARIO DE EVALUACIÓN
        $horariosFechas = $this->getHorarios();
        // OBTENER TODOS LOS EVENTOS
        $eventosFechas = $this->getEventos($horariosFechas);
        // OBTENER LOS EVENTOS VALIDOS PARA LA EVALUACION
        $eventosValidosFechas = $this->getEventosValidos($eventosFechas, $horariosFechas);
        // OBTENER EL ESTADO DE LOS EVENTOS EN EL DIA
        $estadosEventosFechas = $this->getEstadosEventos($eventosValidosFechas);
        // OBTENER LA EVALUACION ORIGINAL
        $evaluacionesFechas = $this->getEvaluaciones($estadosEventosFechas, $horariosFechas, $diasFestivosFechas);
        // OBTENER TODAS lAS INCIDENCIAS 
        $incidenciasFechas = $this->getIncidencias($horariosFechas, $diasFestivosFechas);
        // OBTENER LAS HORAS EXTRA
        $horasExtraFechas = $this->getHorasExtra($eventosFechas, $horariosFechas, $evaluacionesFechas);
        // PERIODO DE EVALUACIÓN
        $perdiodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($perdiodo as $fecha) {    
            $horario = $horariosFechas[$fecha->format($this::FORMATO_FECHA)];
            $eventos = $eventosFechas[$fecha->format($this::FORMATO_FECHA)];
            $eventosValidos = $eventosValidosFechas[$fecha->format($this::FORMATO_FECHA)];
            $estadoEventos = $estadosEventosFechas[$fecha->format($this::FORMATO_FECHA)];
            $evaluacion = $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)];
            $incidencias = $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)];  
            $horasExtra = $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)];  
            // Si ésta fecha tiene incidencias y está dentro de las evaluaciones válidas para volver a hacer la evaluación.  
            if (count($incidencias) > 0 && 
                in_array($evaluacion, [$this::FALTA, $this::RETARDO_LEVE, $this::RETARDO_GRAVE])) {
                $estadoEventosFinal = $this->getEstadoEventosIncidencias($evaluacion, $estadoEventos, $incidencias);
                $evaluacionFinal = $this->getEvaluacionIncidencias($estadoEventosFinal);             
            } else {
                $estadoEventosFinal = $estadoEventos;
                $evaluacionFinal = $evaluacion;
            }
            
            $evaluacionEmpleado = Evaluacion::where([
                    "rfc" => $this->empleado->rfc,
                    "numero_empleado" => $this->empleado->numero_empleado,
                    "fecha" => $fecha
                ])
                ->first();
            
            if ($evaluacionEmpleado) {
                $evaluacionEmpleado->update([
                    "horario_id" => $horario->horario_id,
                    "estado_eventos_original" => $estadoEventos,
                    "estado_eventos_final" => $estadoEventosFinal,
                    "evaluacion_original" => $evaluacion,
                    "evaluacion_final" => $evaluacionFinal,
                    "horas_extra" => $horasExtra,
                    "incidencias" => json_encode($incidencias),
                    "eventos" => json_encode($eventos),
                    "eventos_validos" => json_encode($eventosValidos)
                ]);
            } else {
                $evaluacionEmpleado = Evaluacion::create([
                    "rfc" => $this->empleado->rfc,
                    "numero_empleado" => $this->empleado->numero_empleado,
                    "fecha" => $fecha,
                    "horario_id" => $horario->horario_id,
                    "estado_eventos_original" => $estadoEventos,
                    "estado_eventos_final" => $estadoEventosFinal,
                    "evaluacion_original" => $evaluacion,
                    "evaluacion_final" => $evaluacionFinal,
                    "horas_extra" => $horasExtra,
                    "incidencias" => json_encode($incidencias),
                    "eventos" => json_encode($eventos),
                    "eventos_validos" => json_encode($eventosValidos),
                ]);
            }
        }
    }

    public function getDiasFestivos() {   
        $diasFestivosFechas = []; 
        $diasFestivos = DiaFestivoFecha::whereDate("fecha", ">=", $this->fechaInicio)
            ->whereDate("fecha", "<=", $this->fechaFinal)->get();
        foreach ($diasFestivos as $diaFestivo) {
            $fecha = Carbon::parse($diaFestivo->fecha);
            $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)] = true;
        }
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)] = false;
            }
        }
        uksort($diasFestivosFechas, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        return $diasFestivosFechas;
    }

    public function getHorarios() {
        $horariosFechas = []; 
        $horarioBase = Horario::activo()
            ->where([
                "es_horario_base" => true, 
                "tipo_empleado" => $this->empleado->tipo_empleado
            ])
            ->with("intervalos")
            ->first();
        $horariosEmpleado = HorarioEmpleado::where([
                "rfc" => $this->empleado->rfc,
                "numero_empleado" => $this->empleado->numero_empleado,
            ])
            ->whereDate("fecha_inicio", "<=", $this->fechaFinal)
            ->whereDate("fecha_final", ">=", $this->fechaInicio)
            ->orderBy("created_at")
            ->with("horario.intervalos")
            ->get();            
        foreach ($horariosEmpleado as $horarioEmpleado) {    
            $perdiodoHorario = CarbonPeriod::create($horarioEmpleado->fecha_inicio, $horarioEmpleado->fecha_final);
            foreach ($perdiodoHorario as $fecha) {
                if ($fecha->lt($this->fechaInicio)) continue;
                if ($fecha->gt($this->fechaFinal)) break;
                $horariosFechas[$fecha->format($this::FORMATO_FECHA)] = $horarioEmpleado->horario; 
            }
        }   
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($horariosFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $horariosFechas[$fecha->format($this::FORMATO_FECHA)] = $horarioBase;
            }
        }
        uksort($horariosFechas, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        return $horariosFechas;
    }

    public function getEventos($horariosFechas) {
        $eventosFecha = [];
        $eventosEmpleado = Evento::where([
                /* "rfc" => $empleado->rfc, */
                "numero_empleado" => $this->empleado->numero_empleado,
            ])
            ->whereDate("fecha", ">=", $this->fechaInicio)
            ->whereDate("fecha", "<=", $this->fechaFinal->copy()->addDay())
            ->orderBy("fecha")
            ->get()
            ->each(function ($evento) {
                $evento->intervalo = null; 
            }); 
        foreach ($horariosFechas as $fecha => $horarioFecha) {
            $fecha = Carbon::parse($fecha);
            $horarioTieneSalida = !is_null($horarioFecha->salida);
            if ($horarioTieneSalida) {
                $entrada = Carbon::createFromFormat('H:i:s', $horarioFecha->entrada);
                $salida = Carbon::createFromFormat('H:i:s', $horarioFecha->salida);
                $horarioDiferentesDias = $entrada->gt($salida);
                if ($horarioDiferentesDias) {
                    $fechaInicio = $fecha->copy()->setTime(12, 0, 0);
                    $fechaFinal = $fecha->copy()->addDay()->setTime(11, 59, 59);
                } else {
                    $fechaInicio = $fecha->copy()->startOfDay();
                    $fechaFinal = $fecha->copy()->endOfDay();
                }
            } else {
                $fechaInicio = $fecha->copy()->startOfDay();
                $fechaFinal = $fecha->copy()->endOfDay();
            }
    
            $eventosEnRango = $eventosEmpleado->filter(function ($evento) use ($fechaInicio, $fechaFinal) {
                $fechaEvento = Carbon::parse($evento->fecha);
                return $fechaEvento->between($fechaInicio, $fechaFinal);
            });
            $eventosFecha[$fecha->format($this::FORMATO_FECHA)] = $eventosEnRango->values();
        }
        return $eventosFecha;
    }
    
    public function getEventosValidos($eventosFechas, $horariosFechas) {
        $eventosValidosFechas = [];
        foreach ($eventosFechas as $fecha => $eventos) {
            $eventosValidos = [
                "ENTRADA" => null,
                "RETARDO_LEVE" => null,
                "RETARDO_GRAVE" => null,
                "SALIDA" => null,
            ];  
            
            $horario = $horariosFechas[$fecha];
            $horarioTieneSalida = !is_null($horario->salida);
            $horarioTieneRetardos = $horario->aplica_retardos;

            // INTERVALOS
            $intervaloEntrada = $horario->intervalos->where("tipo", "ENTRADA")->first();
            if ($horarioTieneSalida) {
                $intervaloSalida = $horario->intervalos->where("tipo", "SALIDA")->first();
            }
            if ($horarioTieneRetardos) {
                $intervaloRetardoLeve = $horario->intervalos->where("tipo", "RETARDO_LEVE")->first();
                $intervaloRetardoGrave = $horario->intervalos->where("tipo", "RETARDO_GRAVE")->first();
            }
        
            $tieneEntrada = false;
            $tieneSalida = false;
            $tieneRetardoLeve = false;
            $tieneRetardoGrave = false;
            foreach ($eventos as $evento) {
                if (!$tieneEntrada && !$tieneRetardoLeve && !$tieneRetardoGrave) {
                    if ($this->fechaDentroDeIntervalo($evento->fecha, $intervaloEntrada)) {
                        $tieneEntrada = true;
                        $eventosValidos["ENTRADA"] = $evento;
                        $evento->intervalo = "ENTRADA";
                        continue;
                    }
                    if ($horarioTieneRetardos) {
                        if ($this->fechaDentroDeIntervalo($evento->fecha, $intervaloRetardoLeve)) {
                            $tieneRetardoLeve = true;
                            $eventosValidos["RETARDO_LEVE"] = $evento;
                            $evento->intervalo = "RETARDO_LEVE";
                            continue;
                        }
                        if ($this->fechaDentroDeIntervalo($evento->fecha, $intervaloRetardoGrave)) {
                            $tieneRetardoGrave = true;
                            $eventosValidos["RETARDO_GRAVE"] = $evento;
                            $evento->intervalo = "RETARDO_GRAVE";
                            continue;
                        }
                    }
                } 
                if ($horarioTieneSalida && !$tieneSalida) {
                    if ($this->fechaDentroDeIntervalo($evento->fecha, $intervaloSalida)) {
                        $tieneSalida = true;
                        $eventosValidos["SALIDA"] = $evento;
                        $evento->intervalo = "SALIDA";
                        continue;
                    }
                }
            }
            $eventosValidosFechas[$fecha] = $eventosValidos;
        }   
        return $eventosValidosFechas;
    }

    public function getEstadosEventos($eventosValidosFechas) {
        $estadosEventosFechas = [];
        foreach ($eventosValidosFechas as $fecha => $eventosValidos) {
            $evaluacionSistema = "0000";
            if (!is_null($eventosValidos["ENTRADA"])) {
                $evaluacionSistema = substr_replace($evaluacionSistema, "1", 0, 1);
            }
            if (!is_null($eventosValidos["RETARDO_LEVE"])) {
                $evaluacionSistema = substr_replace($evaluacionSistema, "1", 1, 1);
            }
            if (!is_null($eventosValidos["RETARDO_GRAVE"])) {
                $evaluacionSistema = substr_replace($evaluacionSistema, "1", 2, 1);
            }
            if (!is_null($eventosValidos["SALIDA"])) {
                $evaluacionSistema = substr_replace($evaluacionSistema, "1", 3, 1);
            }
            $estadosEventosFechas[$fecha] = $evaluacionSistema;
        }
        return $estadosEventosFechas;
    }

    public function getEvaluaciones($estadosEventosFechas, $horariosFechas, $diasFestivosFechas) {
        $evaluacionesFechas = [];
        foreach ($estadosEventosFechas as $fecha => $estadoEventos) {
            $horario = $horariosFechas[$fecha];
            $fecha = Carbon::parse($fecha);
            // Comprobar si la fecha es un día inhabil
            if (!$horario->dias[$fecha->dayOfWeek]) {
                $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::DIA_INHABIL;
                continue;
            } 
            // Comprobar que si la fecha es un dia festivo
            if (!$horario->dias_festivos_son_laborales) {
                $esDiaFestivo = $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
                if ($esDiaFestivo) {
                    $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::DIA_FESTIVO;
                    continue;
                }
            }

            $horarioTieneRetardos = $horario->aplica_retardos;
            $horarioTieneSalida = !is_null($horario->salida);

            if ($horarioTieneSalida) {
                if ($horarioTieneRetardos) {
                    $tipoEvaluacion = "TOTAL";
                } else {
                    $tipoEvaluacion = "ENTRADA_SALIDA";
                }
            } else {
                $tipoEvaluacion = "SOLO_ENTRADA";
            }
            
            if ($tipoEvaluacion == "SOLO_ENTRADA" && $estadoEventos == "1000") {
                $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::ASISTENCIA;
                continue;
            } else if ($tipoEvaluacion == "ENTRADA_SALIDA" && $estadoEventos == "1001") {
                $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::ASISTENCIA;
                continue;
            } else if ($tipoEvaluacion == "TOTAL") {
                if ($estadoEventos == "1001") {
                    $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::ASISTENCIA;
                    continue;
                } else if ($estadoEventos == "0101") {
                    $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::RETARDO_LEVE;
                    continue;
                } else if ($estadoEventos == "0011") {
                    $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::RETARDO_GRAVE;
                    continue;
                } 
            }
            
            // Comprobar si la fecha ya es apta para evaluar
            if ($horarioTieneSalida) {
                $horarioEntrada = Carbon::createFromFormat('H:i:s', $horario->entrada);
                $horarioSalida = Carbon::createFromFormat('H:i:s', $horario->salida);
                $horarioDiferentesDias = $horarioEntrada->gt($horarioSalida);
                $intervaloSalida = $horario->intervalos->where("tipo", "SALIDA")->first();
                list($horas, $minutos, $segundos) = explode(":", $intervaloSalida->final);
                if ($horarioDiferentesDias) {
                    $fechaInicioEvaluacion = $fecha->copy()->addDay()->setTime($horas, $minutos, 59);
                } else {
                    $fechaInicioEvaluacion = $fecha->copy()->setTime($horas, $minutos, 59);
                }
            } else {
                if ($horarioTieneRetardos) {
                    $intervaloRetardoGrave = $horario->intervalos->where("tipo", "RETARDO_GRAVE")->first();
                    list($horas, $minutos, $segundos) = explode(":", $intervaloRetardoGrave->final);
                }  else {
                    $intervaloEntrada = $horario->intervalos->where("tipo", "ENTRADA")->first();
                    list($horas, $minutos, $segundos) = explode(":", $intervaloEntrada->final);
                }
                $fechaInicioEvaluacion = $fecha->copy()->setTime($horas, $minutos, 59);
            }
            if (Carbon::now()->lt($fechaInicioEvaluacion)) {
                $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::POR_EVALUAR;
                continue;
            }
            $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $this::FALTA;
        }
        return $evaluacionesFechas;
    }

    public function getIncidencias($horariosFechas, $diasFestivosFechas){
        $incidenciasFechas = [];
       // INCIDENCIAS HISTÓRICAS
        $incidenciasHistorico = HistoricoIncidenciaEmpleado::whereHas("cardex", function ($query) {
                $query->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%{$this->empleado->rfc}%")
                    ->where("numero_empleado", $this->empleado->numero_empleado);
            })->where([
                "status" => "ACTIVO",
                ["tipo_justificacion", "!=", "Cambio de horario"],
                ["fecha_inicio_justificacion", "<=", $this->fechaFinal],
                ["fecha_fin_justificacion", ">=", $this->fechaInicio]
            ])
            ->orderBy("fecha_inicio_justificacion")
            ->with("tramiteIncidencia", "tipoIncidencia")
            ->get();
        foreach ($incidenciasHistorico as $incidencia) {    
            $periodo = CarbonPeriod::create($incidencia->fecha_inicio, $incidencia->fecha_final);
            foreach ($periodo as $fecha) {
                if ($fecha->lt($this->fechaInicio)) continue;
                if ($fecha->gt($this->fechaFinal)) break;
                if ($incidencia->tipoIncidencia->tipo_dias == "NATURALES") {
                    $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)][] = $incidencia;
                } else {
                    $horario = $horariosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $diasFestivosSonLaborales = $horario->dias_festivos_son_laborales;
                    $esDiaFestivo = $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $esDiaLaboral = $horario->dias[$fecha->dayOfWeek] && ($diasFestivosSonLaborales || !$esDiaFestivo);
                    if ($esDiaLaboral) {
                        $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)][] = $incidencia;
                    } 
                }
            }
        }
        // INCIDENCIAS LOCALES PARA FECHAS PASADAS
        $incidenciasLocal = IncidenciaEmpleado::where([
                "rfc" => $this->empleado->rfc,
                "numero_empleado" => $this->empleado->numero_empleado,
                "estatus" => "AUTORIZADO",
            ])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from(DB::raw("jsonb_array_elements_text(p12_incidencias_empleados.fechas::jsonb) AS fecha"))
                    ->whereRaw("fecha::date BETWEEN '{$this->fechaInicio->format($this::FORMATO_FECHA)}' 
                        AND '{$this->fechaFinal->format($this::FORMATO_FECHA)}'");
            })
            ->whereHas("tipoIncidencia.tipoJustificacion", function($query) {
                $query->where("identificador", "!=", "cambio_horario");
            })
            ->orderBy("fecha_inicio")
            ->with("tramiteIncidencia", "tipoIncidencia")
            ->get();
        foreach ($incidenciasLocal as $incidencia) {  
            foreach($incidencia->fechas as $fecha) {
                $fecha = Carbon::parse($fecha);
                if ($fecha->lt($this->fechaInicio)) continue;
                if ($fecha->gt($this->fechaFinal)) break;
                if ($incidencia->tipoIncidencia->tipo_dias == "NATURALES") {
                    $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)][] = $incidencia;
                } else {
                    $horario = $horariosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $diasFestivosSonLaborales = $horario->dias_festivos_son_laborales;
                    $esDiaFestivo = $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $esDiaLaboral = $horario->dias[$fecha->dayOfWeek] && ($diasFestivosSonLaborales || !$esDiaFestivo);
                    if ($esDiaLaboral) {
                        $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)][] = $incidencia;
                    }
                }  
            }
        }
        // AGREGAR FECHAS SIN INCIDENCIAS
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($incidenciasFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)] = [];
            }
        }
        return $incidenciasFechas;
    }
    
    public function getHorasExtra($eventosFechas, $horariosFechas, $evaluacionesFechas) {
        $horasExtraFechas = [];
        foreach ($eventosFechas as $fecha => $eventos) {
            $horasExtra = 0;
            $horario = $horariosFechas[$fecha];
            $horarioTieneSalida = !is_null($horario->salida);
            $evaluacionOriginal = $evaluacionesFechas[$fecha];
            $fecha = Carbon::parse($fecha);
            if ($evaluacionOriginal == $this::ASISTENCIA && $horarioTieneSalida) {
                $entrada = Carbon::createFromFormat('H:i:s', $horario->entrada);
                $salida = Carbon::createFromFormat('H:i:s', $horario->salida);
                $horarioDiferentesDias = $entrada->gt($salida);
                list($horas, $minutos, $segundos) = explode(":", $horario->salida);
                if ($horarioDiferentesDias) {
                    $fechaSalida = $fecha->copy()->addDay()->setTime($horas, $minutos, $segundos);
                } else {
                    $fechaSalida = $fecha->copy()->setTime($horas, $minutos, $segundos);
                }
                $ultimoEvento = Carbon::parse($eventos->last()->fecha);
                if ($fechaSalida->lt($ultimoEvento)) {
                    $horasExtra = $fechaSalida->diffInHours($ultimoEvento);
                }      
            } 
            $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)] = $horasExtra;
        }
        return $horasExtraFechas;
    }

    public function getEstadoEventosIncidencias($evaluacionOriginal, $estadoEventos, $incidencias) {
        $estadoEventoIncidencias = $estadoEventos;
        foreach ($incidencias as $incidencia) {
            if ($evaluacionOriginal == $this::FALTA) {
                if ($incidencia->tipoIncidencia->intervalo_evaluacion == "TODO_EL_DIA") {
                    $estadoEventoIncidencias = "1001";
                    break;
                } else if ($incidencia->tipoIncidencia->intervalo_evaluacion == "ENTRADA") {
                    $estadoEventoIncidencias = substr_replace($estadoEventoIncidencias, "100", 0, 3);
                    continue;
                } else if ($incidencia->tipoIncidencia->intervalo_evaluacion == "SALIDA") {
                    $estadoEventoIncidencias = substr_replace($estadoEventoIncidencias, "1", 3, 1);
                    continue;
                }
            } else if ($evaluacionOriginal == $this::RETARDO_LEVE) {
                if ($incidencia->tipoIncidencia->intervalo_evaluacion == "RETARDO_LEVE") {
                    $estadoEventoIncidencias = "1001";
                    break;
                } 
            } else if ($evaluacionOriginal == $this::RETARDO_GRAVE) {
                if ($incidencia->tipoIncidencia->intervalo_evaluacion == "RETARDO_GRAVE") {
                    $estadoEventoIncidencias = "1001";
                    break;
                } 
            }
        }
        return $estadoEventoIncidencias; 
    }

    public function getEvaluacionIncidencias($estadoEventos) {
        if ($estadoEventos == "1001") {
            $evaluacion = $this::ASISTENCIA;
        } else if ($estadoEventos == "0101") {
            $evaluacion = $this::RETARDO_LEVE;
        } else if ($estadoEventos == "0011") {
            $evaluacion = $this::RETARDO_GRAVE;
        } else {
            $evaluacion = $this::FALTA;
        }
        return $evaluacion;
    }

    public function fechaDentroDeIntervalo($fecha, $intervalo) {
        $fecha = Carbon::parse($fecha);
        $fechaInicio = Carbon::parse($fecha->format($this::FORMATO_FECHA) . " " . $intervalo->inicio)->setSeconds(00);
        $fechaFinal = Carbon::parse($fecha->format($this::FORMATO_FECHA) . " " . $intervalo->final)->setSeconds(59);
        return $fecha->between($fechaInicio, $fechaFinal);
    }
}