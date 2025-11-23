<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAmbito extends Model
{
    protected $table = 'tipos_ambitos';
    protected $primaryKey = 'tipo_ambito_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
    
    public function viaticos() {
        return $this->hasMany('App\Models\SolicitudViatiaco', 'tipo_viatico_id');
    }
}
