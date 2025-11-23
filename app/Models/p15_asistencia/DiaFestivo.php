<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Model;

class DiaFestivo extends Model
{
    protected $table = 'p15_dias_festivos';
    protected $primaryKey = 'dia_festivo_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
