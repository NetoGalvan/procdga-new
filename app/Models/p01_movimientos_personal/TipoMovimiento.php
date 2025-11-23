<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_movimientos';
    protected $primaryKey = 'tipo_movimiento_id';
    
    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
