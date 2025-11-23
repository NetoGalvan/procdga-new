<?php

namespace App\Models\p07_pago_prestaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrestacion extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_prestaciones';
    protected $primaryKey = 'tipo_prestacion_id';

    public function scopeActivo($query)
    {
        return $query->where('activo', 1);
    }

}
