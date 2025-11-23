<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoEmpleadoCardex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoricoEvaluacion extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_evaluacion";

    public function registroAsistencia()
    {
        return $this->belongsTo(HistoricoRegistroAsistencia::class, 'id_p15_registro', 'id_p15_registro');
    }

    public function horario()
    {
        return $this->belongsTo(HistoricoHorario::class, 'horario_evaluado');
    }
    
    public function empleado()
    {
        return $this->belongsTo(HistoricoEmpleado::class, "id_empleado", "employee_number");
    }
}
