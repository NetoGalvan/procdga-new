<?php

namespace App\Models\p31_viatinet;

use Illuminate\Database\Eloquent\Model;

class TipoPartida extends Model
{
    protected $table = 'tipos_partidas';
    protected $primaryKey = 'tipo_partida_id';
    protected $fillable = ['nombre_partida','descripcion_partida','identificador_partida'];

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
    
}
