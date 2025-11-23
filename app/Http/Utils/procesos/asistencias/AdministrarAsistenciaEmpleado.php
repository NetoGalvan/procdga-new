<?php

namespace App\Http\Utils\procesos\asistencias;

use Exception;
use App\Http\Utils\procesos\asistencias\historico\AdministrarAsistenciaEmpleadoHistorico;
use App\Http\Utils\conexion_db_historicos\ConexionDBHistoricos;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoEmpleadoCardex;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoDiaFestivoFecha;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoEvaluacion;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorario;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorarioEmpleado;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use App\Models\p15_asistencia\DiaFestivoFecha;
use App\Models\p15_asistencia\Evaluacion;
use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioEmpleado;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

/** PRUEBA --> RFC = RARH720125HD1 NUMERO_EMPLEADO => 889806 **/
/** PRUEBA --> RFC = GOGS720916QL6 NUMERO_EMPLEADO => 164654 **/
/** PRUEBA --> RFC = RARG680803LG7 NUMERO_EMPLEADO => 838870 **/
class AdministrarAsistenciaEmpleado
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
    private $fechaInicioHistorico;
    private $fechaFinalHistorico;
    private $fechaInicioLocal;
    private $fechaFinalLocal;
    private $diasFestivosFechas;
    private $horariosFechas;
    private $empleadoExisteEnHistorico;

    public function __construct($empleado, $fechaInicio, $fechaFinal) {
        // Fecha de inicio de evaluaciones en el sistema actual
        $fechaInicioEvaluacionLocal = Carbon::parse(config("general.asistencia.fecha_inicio_evaluacion"));
        // Fecha inicio a tomar en cuenta en el registro de asistencia
        $fechaInicio = Carbon::parse($fechaInicio);
        // Fecha final a tomar en cuenta en el registro de asistencia
        $fechaFinal = Carbon::parse($fechaFinal);
        // Fecha inicio historico a tomar en cuenta en el registro de asistencia
        $fechaInicioHistorico = null;
        // Fecha final historico a tomar en cuenta en el registro de asistencia
        $fechaFinalHistorico = null;
        // Fecha inicio local a tomar en cuenta en el registro de asistencia
        $fechaInicioLocal = null;
        // Fecha final local a tomar en cuenta en el registro de asistencia
        $fechaFinalLocal = null;
        // Si la fecha de inicio es menor o igual a la última fecha de evaluación de los históricos
        if ($fechaInicio->lt($fechaInicioEvaluacionLocal)) {
             // Comprobar conexión a los datos históricos
            $conexionDBHistoricos = new ConexionDBHistoricos("lbpm_dga");
            if (!$conexionDBHistoricos->connectionIsSuccess()) {
                throw new Exception($conexionDBHistoricos->getMessageError(), 1);
            }
            $fechaInicioHistorico = $fechaInicio->copy()->startOfDay();
            if ($fechaFinal->lt($fechaInicioEvaluacionLocal)) {
                $fechaFinalHistorico = $fechaFinal->copy()->endOfDay();
                $fechaInicioLocal = null;
                $fechaFinalLocal = null;
            } else {
                $fechaFinalHistorico = $fechaInicioEvaluacionLocal->copy()->subDay()->endOfDay();
                $fechaInicioLocal = $fechaInicioEvaluacionLocal->copy()->startOfDay();
                $fechaFinalLocal = $fechaFinal->copy()->endOfDay();
            }
        } else {
            $fechaInicioLocal = $fechaInicio->copy()->startOfDay();
            $fechaFinalLocal = $fechaFinal->copy()->endOfDay();
        }
        $this->empleado = $empleado;
        $this->fechaInicio = $fechaInicio->startOfDay();
        $this->fechaFinal = $fechaFinal->endOfDay();
        $this->fechaInicioHistorico = $fechaInicioHistorico;
        $this->fechaFinalHistorico = $fechaFinalHistorico;
        $this->fechaInicioLocal = $fechaInicioLocal;
        $this->fechaFinalLocal = $fechaFinalLocal;
        $this->empleadoExisteEnHistorico = HistoricoEmpleadoCardex::where("numero_empleado", $this->empleado->numero_empleado)
            ->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%{$this->empleado->rfc}%")
            ->exists();
    }

    /**
     * Obtiene las evaluaciones de asistencia detalladas para un rango de fechas.
     *
     * Esta función genera un array asociativo detallando las evaluaciones de asistencia
     * de un empleado para cada fecha dentro de un rango especificado. Cada clave del array representa
     * una fecha en el conjunto consultado, y el valor asociado a cada clave es una evaluación comprensiva
     * de asistencia que incluye:
     *
     * - Horario asignado: El horario de trabajo específico asignado al empleado para esa fecha.
     * - Incidencias aplicadas: Todas las incidencias (como ausencias justificadas, enfermedades, etc.)
     *   que se aplican al empleado en esa fecha.
     * - Eventos válidos: Los registros de checada del empleado capturados por el sistema biométrico
     *   que son relevantes para esa fecha.
     * - Estatus de la evaluación: Un resumen del estatus de asistencia para esa fecha
     *
     * @return array Un array asociativo donde las claves son las fechas consultadas y los valores son las
     * evaluaciones de asistencia detalladas para esas fechas.
     */
    public function getEvaluacionesPorFechas() {
        $evaluacionesHistoricas = [];
        if (!is_null($this->fechaInicioHistorico) && $this->empleadoExisteEnHistorico) {
            $administrarAsistenciasHistoricas = new AdministrarAsistenciaEmpleadoHistorico(
                $this->empleado,
                $this->fechaInicioHistorico,
                $this->fechaFinalHistorico
            );
            $evaluacionesHistoricas = $administrarAsistenciasHistoricas->getEvaluacionesHistoricas();
        }
        $evaluacionesLocales = [];
        if (!is_null($this->fechaInicioLocal)) {
            $evaluacionesLocales = Evaluacion::where([
                    "rfc" => $this->empleado->rfc,
                    "numero_empleado" => $this->empleado->numero_empleado
                ])
                ->whereDate('fecha', '>=', $this->fechaInicioLocal)
                ->whereDate('fecha', '<=', $this->fechaFinalLocal)
                ->with("horario.intervalos")
                ->get()
                ->keyBy(function ($item) {
                    return Carbon::parse($item->fecha)->format('Y-m-d');
                })->toArray();
        }
        $evaluacionesFechas = array_merge($evaluacionesHistoricas, $evaluacionesLocales);
        // SI NO SE CUENTA CON UNA FECHA DE EVALUACIÓN
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $evaluacionesFechas[$fecha->format($this::FORMATO_FECHA)] = [
                    "rfc" => $this->empleado->rfc,
                    "numero_empleado" => $this->empleado->numero_empleado,
                    "fecha" => $fecha->format($this::FORMATO_FECHA),
                    "horario" => null,
                    "estado_eventos_original" => "0000",
                    "estado_eventos_final" => "0000",
                    "evaluacion_original" => $this::SIN_EVALUACION,
                    "evaluacion_final" => $this::SIN_EVALUACION,
                    "horas_extra" => 0,
                    "incidencias" => [],
                    "eventos" => [],
                    "eventos_validos" => [
                        "ENTRADA" => null,
                        "RETARDO_LEVE" => null,
                        "RETARDO_GRAVE" => null,
                        "SALIDA" => null,
                    ]
                ];
            }
        }
        return $evaluacionesFechas;
    }

    /**
     * Recupera todas las fecha dentro de un rango y especifica si cada fecha es festiva o no.
     *
     * Esta función consulta y determina si las fechas dentro del rango proporcionado son
     * consideradas días festivos. Devuelve un array asociativo en el que cada clave corresponde
     * a una fecha dentro del rango especificado, y el valor asociado es un valor booleano que indica
     * si la fecha es un día festivo (true) o no (false).
     *
     * @return array Un array asociativo donde las claves son fechas
     * y los valores son booleanos, indicando si la fecha es un día festivo (true) o no (false).
     */
    public function getDiasFestivosPorFechas() {
        $diasFestivosFechas = [];
        if (!is_null($this->fechaInicioHistorico) && $this->empleadoExisteEnHistorico) {
            $diasFestivos = HistoricoDiaFestivoFecha::whereDate('fecha', '>=', $this->fechaInicioHistorico)
                ->whereDate('fecha', '<=', $this->fechaFinalHistorico)->get();
            foreach ($diasFestivos as $diaFestivo) {
                $fecha = Carbon::parse($diaFestivo->fecha);
                $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)] = true;
            }
        }
        if (!is_null($this->fechaInicioLocal)) {
            $diasFestivos = DiaFestivoFecha::whereDate('fecha', '>=', $this->fechaInicioLocal)
                ->whereDate('fecha', '<=', $this->fechaFinalLocal)->get();
            foreach ($diasFestivos as $diaFestivo) {
                $fecha = Carbon::parse($diaFestivo->fecha);
                $diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)] = true;
            }
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

    /**
     * Recupera los horarios asignados a un empleado en un rango de fechas.
     *
     * Esta función consulta los horarios asociados a un empleado basándose en un rango de fechas.
     * Devuelve un array asociativo donde cada clave es una fecha dentro del rango especificado
     * y el valor asociado es el horario asignado al empleado para esa fecha.
     *
     * @return array Array asociativo donde las claves son fechas y los
     * valores son los horarios asignados al empleado para esas fechas.
     */
    public function getHorariosPorFechas() {
        $horariosFechas = [];
        if (!is_null($this->fechaInicioHistorico) && $this->empleadoExisteEnHistorico) {
            $horarioBase = HistoricoHorario::where("id", 4)->with("intervalos")->first();
            $horariosEmpleado = HistoricoHorarioEmpleado::where([
                    "id_empleado" => $this->empleado->numero_empleado,
                    ["fecha_inicio", "<=", $this->fechaFinalHistorico],
                    ["fecha_fin", ">=", $this->fechaInicioHistorico]
                ])
                ->orderBy("id", "DESC")
                ->with("horario.intervalos")
                ->get();
            foreach ($horariosEmpleado as $horarioEmpleado) {
                $perdiodoHorario = CarbonPeriod::create($horarioEmpleado->fecha_inicio, $horarioEmpleado->fecha_fin);
                foreach ($perdiodoHorario as $fecha) {
                    if ($fecha->lt($this->fechaInicioHistorico)) continue;
                    if ($fecha->gt($this->fechaFinalHistorico)) break;
                    $horariosFechas[$fecha->format($this::FORMATO_FECHA)] = $horarioEmpleado->horario;
                }
            }
            $periodo = CarbonPeriod::create($this->fechaInicioHistorico, $this->fechaFinalHistorico);
            foreach ($periodo as $fecha) {
                if (!isset($horariosFechas[$fecha->format($this::FORMATO_FECHA)])) {
                    $horariosFechas[$fecha->format($this::FORMATO_FECHA)] = $horarioBase;
                }
            }
        }
        if (!is_null($this->fechaInicioLocal)) {
            $horarioBase = Horario::activo()->where([
                "es_horario_base" => true,
                "tipo_empleado" => $this->empleado->tipo_empleado,
            ])->with("intervalos")->first();
            $horariosEmpleado = HorarioEmpleado::where([
                "rfc" => $this->empleado->rfc,
                "numero_empleado" => $this->empleado->numero_empleado,
                ["fecha_inicio", "<=", $this->fechaFinalLocal],
                ["fecha_final", ">=", $this->fechaInicioLocal]
            ])
            ->orderBy("horario_empleado_id", "DESC")
            ->with("horario.intervalos")
            ->get();
            foreach ($horariosEmpleado as $horarioEmpleado) {
                $perdiodoHorario = CarbonPeriod::create($horarioEmpleado->fecha_inicio, $horarioEmpleado->fecha_final);
                foreach ($perdiodoHorario as $fecha) {
                    if ($fecha->lt($this->fechaInicioLocal)) continue;
                    if ($fecha->gt($this->fechaFinalLocal)) break;
                    $horariosFechas[$fecha->format($this::FORMATO_FECHA)] = $horarioEmpleado->horario;
                }
            }
            $periodo = CarbonPeriod::create($this->fechaInicioLocal, $this->fechaFinalLocal);
            foreach ($periodo as $fecha) {
                if (!isset($horariosFechas[$fecha->format($this::FORMATO_FECHA)])) {
                    $horariosFechas[$fecha->format($this::FORMATO_FECHA)] = $horarioBase;
                }
            }
        }
        uksort($horariosFechas, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        return $horariosFechas;
    }

    /**
     * Obtiene las horas extras realizadas por un empleado dentro de un rango de fechas.
     *
     * Esta función consulta la base de datos para recopilar las horas extras registradas por un empleado
     * Devuelve un array asociativo donde cada clave es una fecha dentro del rango especificado
     * y el valor asociado son las horas extra que el empleado realizó.
     *
     * @return array Array asociativo donde las claves son fechas y los
     * valores son las horas extras realizadas por el empleado para esas fechas.
     */
    public function getHorasExtraPorFechas() {
        $horasExtraFechas = [];
        if (!is_null($this->fechaInicioHistorico) && $this->empleadoExisteEnHistorico) {
            $evaluaciones = HistoricoEvaluacion::where("id_empleado", $this->empleado->numero_empleado)
                ->whereDate("fecha", ">=", $this->fechaInicioHistorico)
                ->whereDate("fecha", "<=", $this->fechaFinalHistorico)
                ->get();
            foreach ($evaluaciones as $evaluacion) {
                $fecha = Carbon::parse($evaluacion->fecha);
                $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)] = intval(substr($evaluacion->overtime, 1, 2));
            }
        }
        if (!is_null($this->fechaInicioLocal)) {
            $evaluaciones = Evaluacion::where([
                    "numero_empleado" => $this->empleado->numero_empleado,
                    "rfc" => $this->empleado->rfc,
                ])
                ->whereDate("fecha", ">=", $this->fechaInicioLocal)
                ->whereDate("fecha", "<=", $this->fechaFinalLocal)
                ->get();
            foreach ($evaluaciones as $evaluacion) {
                $fecha = Carbon::parse($evaluacion->fecha);
                $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)] = $evaluacion->horas_extra;
            }
        }
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);
        foreach ($periodo as $fecha) {
            if (!isset($horasExtraFechas[$fecha->format($this::FORMATO_FECHA)])) {
                $horasExtraFechas[$fecha->format($this::FORMATO_FECHA)] = 0;
            }
        }
        uksort($horasExtraFechas, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        return $horasExtraFechas;
    }

    /**
     * Obtiene las incidencias agrupadas por fecha dentro de un rango.
     *
     * Esta función consulta las incidencias basándose en un rango de fechas proporcionado
     * y opcionalmente filtra por tipos de incidencias específicas si se proporciona un conjunto
     * de identificadores de tipos de incidencias. Devuelve un array asociativo donde cada
     * clave es una fecha dentro del rango especificado, y el valor asociado es un array que
     * contiene todas las incidencias que ocurrieron en esa fecha.
     *
     * @param array|null $tiposIncidencias (opcional) Un array de identificadores de tipos de incidencias
     *
     * @return array Un array asociativo donde las claves son fechas y los valores son arrays
     * de incidencias que ocurrieron en esas fechas.
     */
    public function getIncidenciasPorFechas($tiposIncidencias = null) {
        $incidenciasFechas = [];
        $this->diasFestivosFechas = $this->diasFestivosFechas ?? $this->getDiasFestivosPorFechas();
        $this->horariosFechas = $this->horariosFechas ?? $this->getHorariosPorFechas();
        // INCIDENCIAS HISTÓRICAS
        $incidenciasHistorico = [];
        if ($this->empleadoExisteEnHistorico) {
            $incidenciasHistorico = HistoricoIncidenciaEmpleado::where([
                "numero_empleado" => $this->empleado->numero_empleado,
                "status" => "ACTIVO",
                ["tipo_justificacion", "!=", "Cambio de horario"],
                ["fecha_inicio_justificacion", "<=", $this->fechaFinal],
                ["fecha_fin_justificacion", ">=", $this->fechaInicio]
            ])
            ->where(function ($query) use ($tiposIncidencias) {
                if ($tiposIncidencias) {
                    $query->whereIn("id_justificacion", $tiposIncidencias);
                }
            })
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
                        $horario = $this->horariosFechas[$fecha->format($this::FORMATO_FECHA)];
                        $diasFestivosSonLaborales = $horario->dias_festivos_son_laborales ?? false;
                        $esDiaFestivo = $this->diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
                        $esDiaLaboral = $horario->dias[$fecha->dayOfWeek] && ($diasFestivosSonLaborales || !$esDiaFestivo);
                        if ($esDiaLaboral) {
                            $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)][] = $incidencia;
                        }
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
            ->where(function ($query) use ($tiposIncidencias) {
                if ($tiposIncidencias) {
                    $query->whereIn("tipo_incidencia_id", $tiposIncidencias);
                }
            })
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
            ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion")
            ->get();

        foreach ($incidenciasLocal as $incidencia) {
            foreach($incidencia->fechas as $fecha) {
                $fecha = Carbon::parse($fecha);
                if ($fecha->lt($this->fechaInicio)) continue;
                if ($fecha->gt($this->fechaFinal)) break;
                if ($incidencia->tipoIncidencia->tipo_dias == "NATURALES") {
                    $incidenciasFechas[$fecha->format($this::FORMATO_FECHA)][] = $incidencia;
                } else {
                    $horario = $this->horariosFechas[$fecha->format($this::FORMATO_FECHA)];
                    $diasFestivosSonLaborales = $horario->dias_festivos_son_laborales ?? false;
                    $esDiaFestivo = $this->diasFestivosFechas[$fecha->format($this::FORMATO_FECHA)];
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
        uksort($incidenciasFechas, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        return $incidenciasFechas;
    }

    /**
     * Obtiene los días acumulados por tipo de incidencia para un empleado.
     *
     * Esta función calcula los días acumulados que un empleado ha tenido por cada tipo de incidencia
     * dentro de un periodo específico. Devuelve un array asociativo donde cada clave
     * corresponde a un tipo de incidencia. El valor asociado a cada clave es otro array asociativo que
     * contiene información detallada del tipo de incidencia, incluyendo un campo adicional que representa
     * la suma total de días acumulados para ese tipo de incidencia por el empleado.
     *
     * La función acepta un parámetro opcional `$tiposIncidencias` que permite filtrar los resultados
     * por tipos de incidencia específicos.
     *
     * @param array|null $tiposIncidencias (opcional) Un array con los identificadores de los tipos de incidencias
     *
     * @return array Un array asociativo donde cada clave es un identificador de tipo de incidencia y cada valor
     * es un array asociativo que incluye los detalles del tipo de incidencia y el total de días acumulados
     * para ese tipo de incidencia por el empleado.
     */
    public function getDiasAcumuladosPorTiposIncidencias($tiposIncidencias = null) {
        $incidenciasEmpleado = $this->getIncidenciasPorFechas($tiposIncidencias);
        $incidenciasEmpleado = collect($incidenciasEmpleado)->flatMap(function ($items) {
                return collect($items);
            })
            ->groupBy("tipoIncidencia.tipo_incidencia_id")
            ->map(function ($items) {
                return [
                    "tipo_justificacion" => $items->first()->tipoIncidencia->tipoJustificacion->nombre,
                    "articulo" => $items->first()->tipoIncidencia->articulo,
                    "subarticulo" => $items->first()->tipoIncidencia->subarticulo,
                    "descripcion" => $items->first()->tipoIncidencia->descripcion,
                    "dias_acumulados" => count($items),
                ];
            })
            ->sortBy("tipo_justificacion")
            ->values();
        return $incidenciasEmpleado;
    }

    /**
     * Evalúa y asigna un estatus a cada fecha dentro de un rango específico para un empleado.
     *
     * Esta función analiza un rango de fechas y determina el estatus de cada fecha para un empleado,
     * basándose en criterios específicos que definen si una fecha es considerada como válida, inválida,
     * festiva o inhábil.
     *
     * Los estatus se determinan según las condiciones predefinidas que pueden incluir, entre otros,
     * si la fecha cae en un día laborable, si es un día festivo oficial.
     *
     * @return array Un array asociativo que incluye tanto el resumen de fechas por estatus ('fechas_por_estatus') como
     * el detalle de estatus por cada fecha ('fechas'), ofreciendo una visión completa sobre la evaluación de fechas.
     */
    public function getFechasPorEstatus($tipoDias) {
        $fechas = collect();
        $periodo = CarbonPeriod::create($this->fechaInicio, $this->fechaFinal);

        if ($tipoDias == "NATURALES") {
            foreach ($periodo as $fecha) {
                $fechas->add([
                    "fecha" => $fecha->toDateString(),
                    "estatus" => "VALIDO"
                ]);
            }
        } else {
            $this->diasFestivosFechas = $this->diasFestivosFechas ?? $this->getDiasFestivosPorFechas();
            $this->horariosFechas = $this->horariosFechas ?? $this->getHorariosPorFechas();
            foreach ($periodo as $fecha) {
                $horario = $this->horariosFechas[$fecha->format("Y-m-d")];
                $esDiaFestivo = $this->diasFestivosFechas[$fecha->format("Y-m-d")];
                if (!$horario->dias[$fecha->dayOfWeek]) {
                    $fechas->add([
                        "fecha" => $fecha->format("Y-m-d"),
                        "estatus" => "INHABIL"
                    ]);
                } else if ($esDiaFestivo && !$horario->dias_festivos_son_laborales) {
                    $fechas->add([
                        "fecha" => $fecha->format("Y-m-d"),
                        "estatus" => "FESTIVO"
                    ]);
                } else {
                    $fechas->add([
                        "fecha" => $fecha->format("Y-m-d"),
                        "estatus" => "VALIDO"
                    ]);
                }
            }
        }

        $fechasPorEstatus = $fechas->groupBy("estatus")->map(function ($item) {
            return $item->pluck("fecha");
        })->toArray();
        $arrayEstatus = ["VALIDO", "INHABIL", "FESTIVO", "INVALIDO"];
        foreach ($arrayEstatus as $estatus) {
            if (!isset($fechasPorEstatus[$estatus])) {
                $fechasPorEstatus[$estatus] = [];
            }
        }
        return [
            "fechas_por_estatus" => $fechasPorEstatus,
            "fechas" => $fechas,
        ];
    }

    /* public function getFechasRetardosFaltasEmpleado($empleado) {
        $fechaActual = Carbon::now()->subDay();
        $fechaAñoAtras = $fechaActual->copy()->subYear()->addMonthsNoOverflow()->startOfMonth();
        $periodoAnual = CarbonPeriod::create($fechaAñoAtras, "1 month", $fechaActual);

        // SOLICITAR EVALUACIÓNES EN RANGOS DE 3 MESES
        $mesesPeriodo = [];
        foreach ($periodoAnual as $mes) {
            $mesesPeriodo[] = $mes;
        }

        $grupoMesesPeriodo = collect($mesesPeriodo)->chunk(3);

        $periodosTrimestrales = [];
        foreach ($grupoMesesPeriodo as $indice => $grupo) {
            $grupo = $grupo->values();

            if ($indice < $grupoMesesPeriodo->count() - 1) {
                $periodosTrimestrales[] = [
                    "fecha_inicio" => $grupo->first()->copy()->startOfMonth(),
                    "fecha_final" => $grupo->last()->copy()->endOfMonth(),
                ];
            } else {
                $periodosTrimestrales[] = [
                    "fecha_inicio" => $grupo->first()->copy()->startOfMonth(),
                    "fecha_final" => $fechaActual,
                ];
            }
        }

        $evaluaciones = [];
        foreach ($periodosTrimestrales as $periodo) {
            $evaluaciones = array_merge($evaluaciones,
                $this->getEvaluacion($empleado, $periodo["fecha_inicio"], $periodo["fecha_final"]));
        }

        $fechasRetardosFaltas = [
            $this::RETARDO_LEVE => [],
            $this::RETARDO_GRAVE => [],
            $this::FALTA => [],
        ];
        foreach ($evaluaciones as $fecha => $evaluacion) {
            if ($evaluacion["evaluacion"]["final"] == $this::RETARDO_LEVE) {
                $fechasRetardosFaltas[$this::RETARDO_LEVE][] = $fecha;
            } else if ($evaluacion["evaluacion"]["final"] == $this::RETARDO_GRAVE) {
                $fechasRetardosFaltas[$this::RETARDO_GRAVE][] = $fecha;
            } else if ($evaluacion["evaluacion"]["final"] ==  $this::FALTA) {
                $fechasRetardosFaltas[$this::FALTA][] = $fecha;
            }
        }
        return $fechasRetardosFaltas;
    } */
}
