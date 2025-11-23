<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoricoHorarioIntervalo extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_intervalos";
    protected $appends = [
        "inicio", "final", "tipo"
    ];
    public function getInicioAttribute()
    {
        return $this->t_start;
    }
    public function getFinalAttribute()
    {
        return $this->t_end;
    }
    public function getTipoAttribute()
    {
        return str_replace(" ", "_", $this->intervalo);
    }
}
