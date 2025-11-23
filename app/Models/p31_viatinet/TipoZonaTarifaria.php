<?php

namespace App\Models\p31_viatinet;

use App\Models\Municipio;
use App\Models\Pais;
use App\Models\TipoAmbito;
use Illuminate\Database\Eloquent\Model;

class TipoZonaTarifaria extends Model
{
    protected $table = 'tipos_zonas_tarifarias';
    protected $primaryKey = 'tipo_zona_tarifaria_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function municipios()
    {
        return $this->morphedByMany(Municipio::class, 'model', 'lugar_zona_tarifaria', 'tipo_zona_tarifaria_id')->wherePivot("activo", true);
    }
    
    public function paises()
    {
        return $this->morphedByMany(Pais::class, 'model', 'lugar_zona_tarifaria', 'tipo_zona_tarifaria_id')->wherePivot("activo", true);
    }

    public function tipoAmbito() {
        return $this->belongsTo(TipoAmbito::class, 'tipo_ambito_id');
    }
}
