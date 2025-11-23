<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoEvaluacionVista extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_vista_evaluacion";

    public function horario()
    {
        return $this->belongsTo(HistoricoHorario::class, 'horario_evaluado');
    }
    
    public function empleado()
    {
        return $this->belongsTo(HistoricoEmpleado::class, "id_empleado", "employee_number");
    }
}
