<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Model;

class DiaFestivoFecha extends Model 
{
    protected $table = 'p15_dias_festivos_fechas';
    protected $primaryKey = 'dia_festivo_fecha_id';
    protected $fillable = ['fecha', 'descripcion'];

    public function setDescripcionAttribute($value)
    {
        $this->attributes['descripcion'] = mb_strtoupper($value);
    }
}
