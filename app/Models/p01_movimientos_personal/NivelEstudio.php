<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEstudio extends Model
{
    use HasFactory;
    
    protected $table = 'niveles_estudios';
    protected $primaryKey = 'nivel_estudio_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
