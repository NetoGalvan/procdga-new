<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoricoDiaFestivoFecha extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_dias_feriados";

}
