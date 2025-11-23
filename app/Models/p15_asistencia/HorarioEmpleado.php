<?php

namespace App\Models\p15_asistencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HorarioEmpleado extends Model
{
    protected $table = 'p15_horarios_empleados';
    protected $primaryKey = 'horario_empleado_id';
    protected $fillable = [
        "horario_id",
        "rfc",
        "numero_empleado",
        "fecha_inicio",
        "fecha_final",
        "activo"
    ];

    public function horario()
    {
        return $this->belongsTo(Horario::class, "horario_id");
    }

    public function getFechaInicioAttribute($value) {
        return $value ? Carbon::parse($value) : null;
    }

    public function getFechaFinalAttribute($value) {
        return $value ? Carbon::parse($value) : null;
    }
}
