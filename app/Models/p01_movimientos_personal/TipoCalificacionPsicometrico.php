<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalificacionPsicometrico extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_calificaciones_psicometricos';
    protected $primaryKey = 'tipo_calificacion_psicometrico_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
