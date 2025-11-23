<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turnos';
    protected $primaryKey = 'turno_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
