<?php

namespace App\Models\p01_movimientos_personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionPsicometrico extends Model
{
    use HasFactory;

    protected $table = 'calificaciones_psicometricos';
    protected $primaryKey = 'calificacion_psicometrico_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function tipoCalificacionPsicometrico()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\TipoCalificacionPsicometrico', 'tipo_calificacion_psicometrico_id');
    }
}
