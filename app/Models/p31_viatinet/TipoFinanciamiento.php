<?php

namespace App\Models\p31_viatinet;

use Illuminate\Database\Eloquent\Model;

class TipoFinanciamiento extends Model
{
    protected $table = 'tipos_financiamientos';
    protected $primaryKey = 'tipo_financiamiento_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function viaticos() {
        return $this->hasMany('App\Models\SolicitudViatico', 'tipo_financiamiento_id');
    }

}
