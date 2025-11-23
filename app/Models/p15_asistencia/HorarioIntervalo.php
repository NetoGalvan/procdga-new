<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Model;

class HorarioIntervalo extends Model
{
    protected $table = 'p15_horarios_intervalos';
    protected $primaryKey = 'horario_intervalo_id';
    protected $fillable = [
        'inicio',
        'final',
        'tipo',
        'horario_id'
    ];
}
