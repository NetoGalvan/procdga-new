<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimientoHonorarios extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_movimientos_honorarios';
    protected $primaryKey = 'tipo_movimiento_honorarios_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
