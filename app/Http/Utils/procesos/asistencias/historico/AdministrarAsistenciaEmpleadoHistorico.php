<?php

namespace App\Http\Utils\procesos\asistencias\historico;

use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoDiaFestivoFecha;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoEvaluacion;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorario;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorarioEmpleado;
use App\Models\historico\lbpm_sica\HistoricoEvento;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

/** PRUEBA --> RFC = RARH720125HD1 NUMERO_EMPLEADO => 889806 **/
/** PRUEBA --> RFC = GOGS720916QL6 NUMERO_EMPLEADO => 164654 **/
/** PRUEBA --> RFC = RARG680803LG7 NUMERO_EMPLEADO => 838870 **/
class AdministrarAsistenciaEmpleadoHistorico
{
    const FORMATO_FECHA = "Y-m-d";
    const SIN_EVALUACION = "SIN_EVALUACION";
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
        $this->fechaInicio = $fechaInicio;
        $this->fechaFinal = $fechaFinal;
    }
    
    public function getEvaluacionesHistoricas() {
        $evaluacionesFechas = [];  
        // Traer los dias festivos 
        $diasFestivosFechas = $this->getDiasFestivos();
        // Traer los horarios del empleado asignados en el periodo
        $horariosFechas = $this->getHorarios();
        // Traer los eventos del empleado por fecha ocurridos en el periodo.
        $eventosFechas = $this->getEventos();
        // Traer los eventos validos por fecha ocurridos en el periodo
        $eventosValidosFechas = $this->getEventosValidos($horariosFechas, $eventosFechas);
        // Traer el estado de los eventos durante el dia por fecha ocurridos en el periodo
        $estadosEventosFechas = $this->getEstadosEventos();
        // Traer las incidencias del empleado por fecha ocurridos en el periodo
        $incidenciasFechas = $this->getIncidencias($diasFestivosFechas, $horariosFechas);
        // Traer las evaluaciones originales 
        $evaluacionesFechas = $this->getEvaluaciones($horariosFechas, $estadosEventosFechas, $diasFestivosFechas);        
        // Traer las horas extra por fecha
        $horasExtraFechas = $this->getHorasExtra();        
        // Periodo de registro de asistencia
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
            $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = [
                "rfc" => $this->empleado->rfc,
                "numero_empleado" => $this->empleado->numero_empleado,
                "fecha" => $fecha->format($this::FORMATO_FECHA),
                "horario" => json_decode(json_encode($horario), true),
                "estado_eventos_original" => $estadoEventos,
                "estado_eventos_final" => $estadoEventosFinal,
                "evaluacion_original" => $evaluacion,
                "evaluacion_final" => $evaluacionFinal,
                "horas_extra" => $horasExtra,
                "incidencias" => json_decode(json_encode($incidencias), true),
                "eventos" => json_decode(json_encode($eventos), true),
                "eventos_validos" => $eventosValidos,
            ];  
        }
        return $evaluacionesFechas;
    }

    public function getDiasFestivos() {    
        $diasFestivosFechas = []; 
        $diasFestivos = HistoricoDiaFestivoFecha::whereDate("fecha", ">=", $this->fechaInicio)
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
        return $diasFestivosFechas;
    }

    public function getHorarios() {
        $horarioBase = HistoricoHorario::where("id", 4)->with("intervalos")->first();
        $horariosEmpleado = HistoricoHorarioEmpleado::where([
                "id_empleado" => $this->empleado->numero_empleado,
            ])
            ->whereDate("fecha_fin", ">=", $this->fechaInicio)
            ->whereDate("fecha_inicio", "<=", $this->fechaFinal)
            ->orderBy("id")
            ->with("horario.intervalos")
            ->get();            
        foreach ($horariosEmpleado as $horarioEmpleado) {    
            $perdiodoHorario = CarbonPeriod::create($horarioEmpleado->fecha_inicio, $horarioEmpleado->fecha_fin);
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
        return $horariosFechas;
    }

    public function getEventos() {
        $eventosFechas = HistoricoEvento::where("no_empleado", $this->empleado->numero_empleado)
            ->whereBetween("ts_evento", [$this->fechaInicio->copy()->startOfDay(), $this->fechaFinal->copy()->endOfDay()])
            ->orderBy("ts_evento")
            ->with("biometrico")
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->ts_evento)->format($this::FORMATO_FECHA);
            })
            ->toArray();      
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($eventosFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $eventosFechas[$fecha->format($this::FORMATO_FECHA)] = [];
            }
        }
        return $eventosFechas;
    }

    public function fechaDentroDeIntervalo($fecha, $intervalo) {
        $fecha = Carbon::parse($fecha);
        $fechaInicio = Carbon::parse($fecha->format($this::FORMATO_FECHA) . " " . $intervalo->inicio)->setSeconds(00);
        $fechaFinal = Carbon::parse($fecha->format($this::FORMATO_FECHA) . " " . $intervalo->final)->setSeconds(59);
        return $fecha->between($fechaInicio, $fechaFinal);
    }

    public function getEventosValidos($horariosFechas, $eventosFechas) {
        $eventosValidosFechas = [];
        foreach ($eventosFechas as $fecha => $eventos) {
            $eventosValidos = [
                "ENTRADA" => null,
                "RETARDO_LEVE" => null,
                "RETARDO_GRAVE" => null,
                "SALIDA" => null,
            ];

            $horario = $horariosFechas[$fecha];

            $intervaloEntrada = $horario->intervalos->where("intervalo", "ENTRADA")->first();
            $intervaloRetardoLeve = $horario->intervalos->where("intervalo", "RETARDO LEVE")->first();
            $intervaloRetardoGrave = $horario->intervalos->where("intervalo", "RETARDO GRAVE")->first();
            $intervaloSalida = $horario->intervalos->where("intervalo", "SALIDA")->first();

            $tieneEntrada = false;
            $tieneRetardoLeve = false;
            $tieneRetardoGrave = false;
            $tieneSalida = false;
            foreach ($eventos as $evento) {
                if (!$tieneEntrada && !$tieneRetardoLeve && !$tieneRetardoGrave) {
                    if (!$tieneEntrada) {
                        if ($this->fechaDentroDeIntervalo($evento["fecha"], $intervaloEntrada)) {
                            $tieneEntrada = true;
                            $eventosValidos["ENTRADA"] = $evento;
                            continue;
                        }
                    } 
                    if (!$tieneRetardoLeve) {
                        if ($this->fechaDentroDeIntervalo($evento["fecha"], $intervaloRetardoLeve)) {
                            $tieneRetardoLeve = true;
                            $eventosValidos["RETARDO_LEVE"] = $evento;
                            continue;
                        }
                    }
                    if (!$tieneRetardoGrave) {
                        if ($this->fechaDentroDeIntervalo($evento["fecha"], $intervaloRetardoGrave)) {
                            $tieneRetardoGrave = true;
                            $eventosValidos["RETARDO_GRAVE"] = $evento;
                            continue;
                        }
                    }
                } 
                if (!$tieneSalida) {
                    if ($this->fechaDentroDeIntervalo($evento["fecha"], $intervaloSalida)) {
                        $tieneSalida = true;
                        $eventosValidos["SALIDA"] = $evento;
                        continue;
                    }
                }
            }
            $eventosValidosFechas[$fecha] = $eventosValidos;
        }
        return $eventosValidosFechas;
    }

    public function getIncidencias($diasFestivosFechas, $horariosFechas) {
        $incidenciasFechas = [];
        // INCIDENCIAS HISTÓRICAS
        $incidenciasHistorico = HistoricoIncidenciaEmpleado::where([
                "numero_empleado" => $this->empleado->numero_empleado,
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
                    $esDiaFestivo = $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $esDiaLaboral = $horario->dias[$fecha->dayOfWeek] && !$esDiaFestivo;
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
                    $esDiaFestivo = $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $esDiaLaboral = $horario->dias[$fecha->dayOfWeek] && !$esDiaFestivo;
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

    public function getEstadosEventos() {
        $estadosEventosFechas = [];
        $evaluaciones = HistoricoEvaluacion::where([
                "id_empleado" => $this->empleado->numero_empleado,
            ])
            ->whereDate("fecha", "<=", $this->fechaFinal)
            ->whereDate("fecha", ">=", $this->fechaInicio)
            ->get();
        foreach ($evaluaciones as $evaluacion) {
            $fecha = Carbon::parse($evaluacion->fecha);
            $estadosEventosFechas[$fecha->format($this::FORMATO_FECHA)] = $evaluacion->parcial;
        }
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($estadosEventosFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $estadosEventosFechas[$fecha->format($this::FORMATO_FECHA)] = "0000";
            }
        }          
        return $estadosEventosFechas; 
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

    public function getEvaluaciones($horariosFechas, $estadosEventosFechas, $diasFestivosFechas) {
        $evaluacionesFechas = [];
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            $horario = $horariosFechas[$fecha->format($this::FORMATO_FECHA)];
            $esDiaFestivo = $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
            $estadoEventos = $estadosEventosFechas[$fecha->format($this::FORMATO_FECHA)];
            if (!$horario->dias[$fecha->dayOfWeek]) {
                $evaluacion = $this::DIA_INHABIL;
            } else if ($esDiaFestivo) {
                $evaluacion = $this::DIA_FESTIVO;
            } else if ($estadoEventos == "1001") {
                $evaluacion = $this::ASISTENCIA;
            } else if ($estadoEventos == "0101") {
                $evaluacion = $this::RETARDO_LEVE;
            } else if ($estadoEventos == "0011") {
                $evaluacion = $this::RETARDO_GRAVE;
            } else {
                $evaluacion = $this::FALTA;
            }
            $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = $evaluacion;
        }  
        return $evaluacionesFechas;
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
    
    public function getHorasExtra() {
        $horasExtraFechas = [];
        $evaluaciones = HistoricoEvaluacion::where([
                "id_empleado" => $this->empleado->numero_empleado,
            ])
            ->whereDate("fecha", "<=", $this->fechaFinal)
            ->whereDate("fecha", ">=", $this->fechaInicio)
            ->get();
        foreach ($evaluaciones as $evaluacion) {
            $fecha = Carbon::parse($evaluacion->fecha);
            $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)] = intval(substr($evaluacion->overtime, 1, 2));
        }
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($horasExtraFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)] = 0;
            }
        }
        return $horasExtraFechas;
    }
}
