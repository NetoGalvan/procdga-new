<?php

namespace App\Models\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Model;

class TipoCaptura extends Model
{
    protected $table = 'p12_tipos_captura';
    protected $primaryKey = 'tipo_captura_id';

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
    
    public function empleadoKardexDetalles()
    {
        return $this->hasOne(P1214EmpleadoKardexDetalle::class, 'tipo_captura_id', 'tipo_captura_id');
    }

}
