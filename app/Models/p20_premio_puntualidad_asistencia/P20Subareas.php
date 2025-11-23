<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P20Subareas extends Model
{
    use HasFactory;

    protected $table = "p20_subareas";
    protected $primaryKey = "p20_subareas_id";

    public function nomina(){
        return $this->hasMany('App\Models\p20_premio_puntualidad_asistencia\P20Nomina', 'p20_nomina_id');
    }
}
