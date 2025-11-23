<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoricoHorarioEmpleado extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_trabajadores_horarios";

    public function horario()
    {
        return $this->belongsTo(HistoricoHorario::class, "id_horario", "id");
    }

}
