<?php

namespace App\Models\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Instancia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TramiteIncidencia extends Model
{
    use HasFactory;

    protected $table = "p12_tramites_incidencias";
    protected $primaryKey = "tramite_incidencia_id";
    protected $fillable = [
        "tipo_tramite",
        "tramite_incidencia_asociado_id",
        "folio",
        "estatus",
        "area_id",
        "tipo_captura_id",
        "tipo_cancelacion",
        "numero_documento",
        "firmas",
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
        "observaciones",
        "motivo_rechazo",
        "motivo_cancelacion",
        "aprobado_at",
        "aprobado_por",
        "autorizado_at",
        "autorizado_por",
        "creado_por",
        "rechazado_por", 
        "rechazado_at"
    ];
    protected $appends = [
        "role_iniciador_tramite",
        "user_iniciador_tramite",
        "observaciones_reporte"
    ];

    public function instancia()
    {
        return $this->morphOne(Instancia::class, 'model');
    }

    function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function tramiteAsociado()
    {
        return $this->belongsTo(TramiteIncidencia::class, 'tramite_incidencia_asociado_id');
    }

    public function tramitesCancelaciones()
    {
        return $this->hasMany(TramiteIncidencia::class, 'tramite_incidencia_asociado_id');
    }

    public function incidenciasEmpleado()
    {
        return $this->hasMany(IncidenciaEmpleado::class, 'tramite_incidencia_id');
    }

    public function incidenciasEmpleadoCancelacion()
    {
        return $this->belongsToMany(IncidenciaEmpleado::class, 'p12_incidencias_cancelacion', 'tramite_incidencia_id', 'incidencia_empleado_id');
    }

    public function tipoCaptura()
    {
        return $this->belongsTo(TipoCaptura::class, 'tipo_captura_id');
    }

    public function tramiteNotaBuena()
    {
        return $this->hasOne(TramiteNotaBuena::class, 'tramite_incidencia_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    public function aprobadoPor()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
    
    public function autorizadoPor()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }

    public function rechazadoPor()
    {
        return $this->belongsTo(User::class, 'rechazado_por');
    }

    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }

    public function getFechaInicioAttribute($value) {
        return $value ? Carbon::parse($value) : null;
    }

    public function getFechaFinalAttribute($value) {
        return $value ? Carbon::parse($value) : null;
    }

    public function getRoleIniciadorTramiteAttribute() {
        if ($this->tipo_tramite == "AUTOINCIDENCIA") {
            return "EMPLEADO_GRAL";
        }
        if ($this->tipo_tramite == "INCIDENCIA_INDIVIDUAL") {
            return "INI_JUST";
        }
        if ($this->tipo_tramite == "INCIDENCIA_INDIVIDUAL_ADMIN") {
            return "CAPT_KDX";
        }
        if ($this->tipo_tramite == "INCIDENCIA_GRUPAL") {
            return "CAPT_KDX";
        }
    }

    public function getUserIniciadorTramiteAttribute() {
        if ($this->tipo_tramite == "AUTOINCIDENCIA") {
            $primerTarea = $this->instancia
                ->instanciasTareas()
                ->where("es_primer_tarea", true)
                ->first();
            if ($primerTarea) {
                return $primerTarea->asignadoAlUsuario;
            }
            return Auth::user();
        }
        return null;
    }

    public function getObservacionesReporteAttribute()
    {
        if ($this->tipoCaptura) {
            return $this->tipoCaptura->identificador == "cancelacion" ? 
                $this->motivo_cancelacion : 
                $this->observaciones;
        }
        return null;
    }
}
