<?php

namespace App\Models\p31_viatinet;

use Illuminate\Database\Eloquent\Model;

class LugarZonaTarifaria extends Model
{
    protected $table = 'lugar_zona_tarifaria';
    protected $primaryKey = 'lugar_zona_tarifaria_id';

    function tipoZonaTarifaria() 
    {
        return $this->belongsTo(TipoZonaTarifaria::class, 'tipo_zona_tarifaria_id');
    } 

    public function model()
    {
        return $this->morphTo();
    }
}

