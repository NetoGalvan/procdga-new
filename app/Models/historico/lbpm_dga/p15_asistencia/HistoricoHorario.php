<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoricoHorario extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_horarios";
    protected $appends = [
        "entrada", "salida", "tipo_empleado", "dias_formato_string"
    ];

    public function intervalos()
    {
        return $this->hasMany(HistoricoHorarioIntervalo::class, 'id_horario', 'id');
    }

    public function getEntradaAttribute()
    {
        return $this->t_start;
    }
    public function getSalidaAttribute()
    {
        return $this->t_end;
    }
    public function getTipoEmpleadoAttribute()
    {
        return $this->descripcion == "SINDICALIZADOS" ? "SINDICALIZADO" : "NO_SINDICALIZADO";
    }
    public function getDiasFormatoStringAttribute()
    {       
        $arrayDias = ["DOMINGO", "LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO"];
        $diasHorario = [];
        foreach (str_split($this->dias) as $indice => $dia) {
            if ($dia) {
                $diasHorario[] = $arrayDias[$indice];
            }
        }
        return $diasHorario;
    }
}
