<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    use HasFactory;
    
    protected $table = 'estados_civiles';
    protected $primaryKey = 'estado_civil_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
