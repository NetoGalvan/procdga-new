<?php

namespace App\Models;

use App\Models\p31_viatinet\TipoZonaTarifaria;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $primaryKey = 'pais_id';
    protected $appends = ['tipo_zona_tarifaria'];

    public function scopeActivo($query) {
        return $query->where('activo', 1);
    }

    public function tiposZonasTarifarias()
    {
        return $this->morphToMany(TipoZonaTarifaria::class, 'model', 'lugar_zona_tarifaria', null, 'tipo_zona_tarifaria_id')->wherePivot("activo", true);
    }

    public function getTipoZonaTarifariaAttribute()
    {       
        return $this->tiposZonasTarifarias()->first();
    } 
}
