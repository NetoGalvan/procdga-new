<?php

namespace App\Models\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoJustificacion extends Model
{
    use HasFactory;
    
    protected $table = 'p12_tipos_justificaciones';
    protected $primaryKey = 'tipo_justificacion_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
