<?php

namespace App\Models;

use App\Models\p31_viatinet\TipoZonaTarifaria;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'municipio_id';
    protected $appends = ['tipo_zona_tarifaria'];

    public function scopeActivo($query) {
        return $query->where('activo', 1);
    }

    public function viaticos() {
        return $this->hasMany('App\Models\SolicitudViatiaco', 'municipio_id');
    }

    public function tiposZonasTarifarias()
    {
        return $this->morphToMany(TipoZonaTarifaria::class, 'model', 'lugar_zona_tarifaria', null, 'tipo_zona_tarifaria_id')->wherePivot("activo", true);
    }

    public function getTipoZonaTarifariaAttribute()
    {       
        return $this->tiposZonasTarifarias()->first();
    } 

    public function entidad()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id');
    }
}
