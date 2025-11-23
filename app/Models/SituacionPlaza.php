<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionPlaza extends Model
{
    use HasFactory;

    protected $table = 'situaciones_plazas';
    protected $primaryKey = 'situacion_plaza_id';

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function plazas()
    {
        return $this->hasMany('App\Models\p01_movimientos_personal\Plazas', 'situacion_plaza_id');
    }

    public function getSituacionPlazaAttribute($value)
    {
        return mb_strtoupper($value);
    }
}
