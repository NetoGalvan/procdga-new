<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarCitaPsicometrico extends Model
{
    use HasFactory;
    
    protected $table = 'lugares_citas_psicometricos';
    protected $primaryKey = 'lugar_cita_psicometrico_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
