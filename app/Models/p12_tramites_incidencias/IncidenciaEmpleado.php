<?php

namespace App\Models\p12_tramites_incidencias;

use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioEmpleado;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IncidenciaEmpleado extends Model
{
    protected $table = "p12_incidencias_empleados";
    protected $primaryKey = "incidencia_empleado_id";
    protected $fillable = [
        "tramite_incidencia_id",
        "tramite_nota_buena_id",
        "tipo_captura_id",
        "estatus",
        "folio_autorizacion",
        "numero_documento",
        "rfc",
        "numero_empleado",
        "nombre",
        "apellido_paterno",
        "apellido_materno",
        "sexo",
        "es_sindicalizado",
        "seccion_sindical",
        "nomina",
        "nivel_salarial",
        "puesto",
        "codigo_puesto",
        "codigo_universo",
        "zona_pagadora", 
        "codigo_situacion_empleado",
        "turno",
        "tipo_empleado",
        "fecha_alta_empleado",
        "unidad_administrativa",
        "unidad_administrativa_nombre",
        "tipo_incidencia_id",
        "horario_id",
        "fecha_inicio",
        "fecha_final",
        "fechas",
        "notas_buenas",
        "total_dias",
        "observaciones",
        "firmas",
        "numero_documento_cancelacion",
        "folio_cancelacion",
        "motivo_cancelacion",
        "firmas_cancelacion"
    ];
    protected $appends = [
        "nombre_completo",
        "observaciones_reporte",
    ];

    public function tramiteIncidencia()
    {
        return $this->belongsTo(TramiteIncidencia::class, "tramite_incidencia_id");
    }

    public function tramiteIncidenciaCancelacion()
    {
        return $this->belongsTo(TramiteIncidencia::class, "folio_cancelacion", "folio");
    }

    public function tramitesIncidenciasCancelacion()
    {
        return $this->belongsToMany(TramiteIncidencia::class, 'p12_incidencias_cancelacion', 'incidencia_empleado_id', 'tramite_incidencia_id');
    }

    public function tipoCaptura()
    {
        return $this->belongsTo(TipoCaptura::class, 'tipo_captura_id');
    }
    
    public function tipoIncidencia()
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }
    
    public function horarioEmpleado()
    {
        return $this->belongsTo(HorarioEmpleado::class, 'horario_empleado_id');
    }
    
    public function notasBuenas()
    {
        return $this->hasMany(NotaBuena::class, 'incidencia_empleado_id');
    }
    
    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }
    
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->apellido_paterno} {$this->apellido_materno} {$this->nombre}");
    }

    public function getFechaInicioAttribute($value) {
        return $value ? Carbon::parse($value) : null;
    }

    public function getFechaFinalAttribute($value) {
        return $value ? Carbon::parse($value) : null;
    }

    public function getFechasAttribute($value)
    {
        return $value ? json_decode($value) : null;
    }
    
    public function getObservacionesReporteAttribute()
    {
        return $this->estatus == "CANCELADO" ? 
            $this->motivo_cancelacion : 
            $this->observaciones;
    }
    
}
