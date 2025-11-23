<?php

namespace App\Http\Utils\procesos\notas_buenas;

use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoNotaBuena;
use App\Models\p12_tramites_incidencias\NotaBuena;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class AdministrarNotasBuenasEmpleado {

    private $empleado;
    private $fechaInicio;
    private $fechaFinal;

    public function __construct($empleado, $fechaInicio, $fechaFinal) {       
        $this->empleado = $empleado;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFinal = $fechaFinal;
    }

    public function getNotasBuenas() {
        // EVALUACIONES
        $administrarAsistenciaEmpleado = new AdministrarAsistenciaEmpleado($this->empleado, $this->fechaInicio, $this->fechaFinal);
        $evaluaciones = $administrarAsistenciaEmpleado->getEvaluacionesPorFechas();
        // NOTAS BUENAS
        $notasBuenasPorPeriodo = [];
        $periodoPorMesNB = CarbonPeriod::create($this->fechaInicio, "1 month", $this->fechaFinal);
        foreach ($periodoPorMesNB as $mes) {
            $periodoNB = getMesesEnArray()[$mes->month - 1] . " " . $mes->year;
            $tiposNB = [
                "PUNTUALIDAD 1RA. QUINCENA" => [
                    "fecha_inicio" => $mes->copy()->startOfMonth(),
                    "fecha_final" => $mes->copy()->addDays(14)
                ],
                "PUNTUALIDAD 2DA. QUINCENA" => [
                    "fecha_inicio" => $mes->copy()->addDays(15),
                    "fecha_final" => $mes->copy()->endOfMonth()
                ],
                "ASISTENCIA" => [
                    "fecha_inicio" => $mes->copy()->startOfMonth(),
                    "fecha_final" => $mes->copy()->endOfMonth()
                ]
            ];
            // EVALUACIÓN DE NOTAS BUENAS
            foreach ($tiposNB as $tipoNB => $periodoTipoNB) {
                $inasistencias = 0;
                $retardosLeves = 0;
                $retardosGraves = 0;
                $culturaLaboral = 0;
                $periodoTipoNB = CarbonPeriod::create($periodoTipoNB["fecha_inicio"], $periodoTipoNB["fecha_final"]);
                foreach ($periodoTipoNB as $dia) {
                    $evaluacionDia = $evaluaciones[$dia->format('Y-m-d')]["evaluacion_final"];
                    if (in_array($evaluacionDia, ["SIN_EVALUACION", "FALTA"])) {
                        $inasistencias += 1;
                    } else if ($evaluacionDia == "RETARDO_LEVE") {
                        $retardosLeves += 1;
                    } else if ($evaluacionDia == "RETARDO_GRAVE") {
                        $retardosGraves += 1;
                    }
                    $incidencias = $evaluaciones[$dia->format('Y-m-d')]["incidencias"];
                    foreach ($incidencias as $incidencia) {
                        if ($incidencia["tipo_incidencia"]["articulo"] == "NUEVA CULTURA LABORAL VIERNES") {
                            $culturaLaboral += 1;
                        }
                    }
                }
                if ($tipoNB == "PUNTUALIDAD 1RA. QUINCENA" || $tipoNB == "PUNTUALIDAD 2DA. QUINCENA") {
                    if ($inasistencias == 0 && $retardosGraves == 0 && $retardosLeves < 4 && $culturaLaboral == 0) {
                        $notasBuenasPorPeriodo[$periodoNB][$tipoNB] = true;
                    } else {
                        $notasBuenasPorPeriodo[$periodoNB][$tipoNB] = false;
                    }
                } else if ($tipoNB == "ASISTENCIA") {
                    $resultadoNBQ1 = $notasBuenasPorPeriodo[$periodoNB]["PUNTUALIDAD 1RA. QUINCENA"];
                    $resultadoNBQ2 = $notasBuenasPorPeriodo[$periodoNB]["PUNTUALIDAD 2DA. QUINCENA"];
                    if ($resultadoNBQ1 && $resultadoNBQ2) {
                        $notasBuenasPorPeriodo[$periodoNB]["ASISTENCIA"] = true;
                        $notasBuenasValidas[] = "{$periodoNB} ASISTENCIA";
                    } else {
                        $notasBuenasPorPeriodo[$periodoNB]["ASISTENCIA"] = false;
                    } 
                }
            }
        }
        $notasBuenasHistorico = HistoricoNotaBuena::select("periodo_origen as periodo", "tipo_nb as tipo")
            ->where([
                "numero_empleado" => $this->empleado->numero_empleado,
                "status_cancelacion" => NULL,
            ])
            ->where(function($query) use ($notasBuenasPorPeriodo) {
                foreach ($notasBuenasPorPeriodo as $periodo => $tipos) {
                    foreach (array_keys($tipos) as $tipo) {
                        $query->orWhere(function($query) use ($periodo, $tipo) {
                            $query->where(DB::raw('UPPER(periodo_origen)'), mb_strtoupper($periodo))
                                ->where(DB::raw('UPPER(tipo_nb)'), mb_strtoupper($tipo));
                        });
                    }
                }
            })
            ->get()
            ->toArray();

        $notasBuenasLocal = NotaBuena::select("periodo", "tipo")
            ->whereHas("incidenciaEmpleado", function ($query) {
                $query->where([
                    "rfc" => $this->empleado->rfc,
                    "numero_empleado" => $this->empleado->numero_empleado,
                ])
                ->whereIn("estatus", ["EN_PROCESO", "APROBADO"]);
            })
            ->where(function($query) use ($notasBuenasPorPeriodo) {
                foreach ($notasBuenasPorPeriodo as $periodo => $tipos) {
                    foreach (array_keys($tipos) as $tipo) {
                        $query->orWhere(function($query) use ($periodo, $tipo) {
                            $query->where(DB::raw('UPPER(periodo)'), mb_strtoupper($periodo))
                                ->where(DB::raw('UPPER(tipo)'), mb_strtoupper($tipo));
                        });
                    }
                }
            })
            ->get()
            ->toArray();
        // NOTAS BUENAS UTILIZADAS
        $notasBuenasUtilizadas = array_merge($notasBuenasHistorico, $notasBuenasLocal);
        foreach ($notasBuenasUtilizadas as $notaBuenaUtilizada) {
            $periodo = mb_strtoupper($notaBuenaUtilizada["periodo"]);
            $tipo = mb_strtoupper($notaBuenaUtilizada["tipo"]);
            $notasBuenasPorPeriodo[$periodo][$tipo] = false;
        }
        return array_reverse($notasBuenasPorPeriodo);
    }
}