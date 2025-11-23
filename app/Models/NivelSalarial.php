<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelSalarial extends Model
{
    use HasFactory;

    protected $table = 'niveles_salariales';
    protected $primaryKey = 'nivel_salarial_id';
    protected $fillable = ['nombre', 'identificador', 'tipo_personal', 'sueldo_cotizable', 'sueldo_sar', 'sueldo_total'];

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function plazas() {
        return $this->belongsTo('App\models\Plaza', 'nivel_salarial_id');
    }
}
