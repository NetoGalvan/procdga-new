<?php

namespace App\Models\p15_asistencia;

use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = "p15_evaluaciones";
    protected $primaryKey = "evaluacion_id";
    protected $fillable = [
        "rfc",
        "numero_empleado",
        "fecha",
        "horario_id",
        "estado_eventos_original",
        "estado_eventos_final",
        "evaluacion_original",
        "evaluacion_final",
        "horas_extra",
        "incidencias",
        "eventos",
        "eventos_validos"
    ];

    public function horario()
    {
        return $this->belongsTo(Horario::class, "horario_id");
    }

    public function getIncidenciasAttribute($value) {
        return json_decode($value, true);
    }
    
    public function getEventosAttribute($value) {
        return json_decode($value, true);
    }
    
    public function getEventosValidosAttribute($value) {
        return json_decode($value, true);
    }
}