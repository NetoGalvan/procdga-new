<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionEmpleado extends Model
{
    use HasFactory;

    protected $table = 'situaciones_empleados';
    protected $primaryKey = 'situacion_empleado_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
