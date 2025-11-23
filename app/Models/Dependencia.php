<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'dependencia_id';
    
    function unidadesAdministrativas() {
        return $this->hasMany('App\Models\UnidadAdministrativa', 'dependencia_id', 'dependencia_id');
    }

    function lugarCitaPsicometrico() {
        return $this->hasOne('App\Models\p01_movimientos_personal\LugarCitaPsicometrico', 'dependencia_id', 'dependencia_id');
    }
}
