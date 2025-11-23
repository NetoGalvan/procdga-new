<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Model;

class AnioDiaFestivo extends Model
{
    protected $table = 'p15_anios_dias_festivos';
    protected $primaryKey = 'anio_dia_festivo_id';
    protected $fillable = ['anio'];
    protected $appends = ['ruta_editar'];

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function getRutaEditarAttribute() {
        return route("asistencia.catalogo.dias.festivos.edit", $this);
    }

    public function diasFestivos() 
    {
        return $this->belongsToMany(DiaFestivo::class, 'p15_fechas_dias_festivos', 'anio_dia_festivo_id', 'dia_festivo_id')
            ->using(FechaDiaFestivo::class)
            ->withPivot("fecha_inicio", "fecha_final");
    }
}
