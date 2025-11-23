<?php

namespace App\Models\historico\lbpm_dga\p12_tramites_incidencias;

use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorario;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class HistoricoIncidenciaEmpleado extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p12_14_empleados_cardex_detalle";
    protected $primaryKey = "id_cardex_detalle";
    protected $appends = [
        "tipo_captura",
        "fecha_inicio",
        "fecha_final",
        "fechas",
        "total_dias",
        "nombre",
        "apellido_paterno",
        "apellido_materno",
        "nombre_completo",
        "notas_buenas",
        "estatus",
        "folio_autorizacion",
        "folio_cancelacion",
        "observaciones_reporte",
        "created_at"
    ];
    public $timestamps = false;

    public function cardex()
    {
        return $this->belongsTo(HistoricoEmpleadoCardex::class, "id_empleado_cardex");
    }

    public function tipoIncidencia()
    {
        return $this->belongsTo(HistoricoTipoIncidencia::class, "id_justificacion");
    }

    public function tramiteIncidencia()
    {
        return $this->belongsTo(HistoricoTramiteIncidencia::class, "folio_aprobacion", "folio");
    }

    public function tramiteIncidenciaCancelacion()
    {
        return $this->belongsTo(HistoricoTramiteIncidencia::class, "folio_de_cancelacion", "folio");
    }

    public function horario()
    {
        return $this->belongsTo(HistoricoHorario::class, "id_horario_justificacion", "id");
    }

    public function getTipoCapturaAttribute()
    {
        if (in_array($this->tipo_justificacion, ["Nota buena - RL", "Nota buena - RG", "Nota buena - Inasistencia"])) {
            return (object) [
                "nombre" => "APLICACIÓN DE NOTAS BUENAS",
                "identificador" => "alta_nb"
            ];
        } else {
            return (object) [
                "nombre" => "ALTA",
                "identificador" => "alta"
            ];
        }
    }

    public function getFechaInicioAttribute()
    {
        return $this->fecha_inicio_justificacion;
    }

    public function getFechaFinalAttribute()
    {
        return $this->fecha_fin_justificacion;
    }
    
    public function getFechasAttribute()
    {
        return in_array($this->tipo_justificacion, ["Nota buena - RL", "Nota buena - RG", "Nota buena - Inasistencia"]) ? [$this->fecha_inicio_justificacion] : null;
    }

    public function getTotalDiasAttribute()
    {
        return $this->dias_justificacion ?? $this->dias;
    }

    public function getNombreAttribute()
    {
        return $this->cardex->nombre_empleado;
    }

    public function getApellidoPaternoAttribute()
    {
        return $this->cardex->apellido_paterno;
    }

    public function getApellidoMaternoAttribute()
    {
        return $this->cardex->apellido_materno;
    }

    public function getNombreCompletoAttribute()
    {
        return trim("{$this->cardex->apellido_paterno} {$this->cardex->apellido_materno} {$this->cardex->nombre_empleado}");
    }

    public function getNotasBuenasAttribute()
    {
        if (in_array($this->tipo_justificacion, ["Nota buena - RL", "Nota buena - RG", "Nota buena - Inasistencia"])) {
            $incidenciasEmpleadoTramite = [];
            if ($this->status == "ACTIVO") {
                $notasBuenasIncidenciaEmpleado = explode(" -- ", $this->observaciones_justificacion);
                $notasBuenasIncidenciaEmpleado = collect($notasBuenasIncidenciaEmpleado)->filter(function ($item) {
                    return !empty(trim($item));
                })->map(function ($item) {
                    $item = trim($item);
                    $partes = explode(" ", $item); 
                    $periodo = implode(" ", array_slice($partes, -2)); 
                    $tipo = implode(" ", array_slice($partes, 0, -2)); 
                    return [
                        "tipo" => mb_strtoupper($tipo),
                        "periodo" => mb_strtoupper($periodo),
                    ];
                })->toArray();
                return $notasBuenasIncidenciaEmpleado;
            } else {
                if (is_null($this->tramiteIncidencia)) {
                    return [];
                }
                $incidenciasEmpleadoTramite = json_decode($this->tramiteIncidencia->json_nota_buena);
                foreach ($incidenciasEmpleadoTramite as $incidenciaEmpleado) {
                    $fechaIncidenciaEmpleado = Carbon::createFromFormat('d/m/Y', $incidenciaEmpleado->fecha_inicio_justificacion)->format("Y-m-d");
                    if ($this->fecha_inicio_justificacion == $fechaIncidenciaEmpleado) {
                        $notasBuenasIncidenciaEmpleado = explode(" -- ", $incidenciaEmpleado->observaciones_justificacion);
                        $notasBuenasIncidenciaEmpleado = collect($notasBuenasIncidenciaEmpleado)->filter(function ($item) {
                            return !empty(trim($item));
                        })->map(function ($item) {
                            $item = trim($item);
                            $partes = explode(" ", $item); 
                            $periodo = implode(" ", array_slice($partes, -2)); 
                            $tipo = implode(" ", array_slice($partes, 0, -2)); 
                            return [
                                "tipo" => mb_strtoupper($tipo),
                                "periodo" => mb_strtoupper($periodo),
                            ];
                        })->toArray();

                        return $notasBuenasIncidenciaEmpleado;
                    }   
                }
            }
        } else {
            return [];
        }
    }

    public function getFolioAutorizacionAttribute()
    {
        return $this->folio_aprobacion;
    }

    public function getFolioCancelacionAttribute()
    {
        return $this->folio_de_cancelacion;
    }

    public function getEstatusAttribute()
    {
        $relacionEstatus = [
            "ACTIVO" => "AUTORIZADO",
            "CANCELADO" => "CANCELADO"
        ];
        return $relacionEstatus[$this->status];
    }

    public function getCreatedAtAttribute()
    {
        return $this->created_on;
    }

    public function getObservacionesReporteAttribute()
    {
        return $this->observaciones_justificacion;
    }
}



