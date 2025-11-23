<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P20SubprocesoNomina extends Model
{
    use HasFactory;

    protected $table = "p20_subproceso";
    protected $primaryKey = "p20_subproceso_id";

    protected $fillable = [
        'instancia_id', 'folio'
    ];

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function unidadAdministrativa() {
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }

    public function premio()
    {
        return $this->belongsTo('App\Models\p20_premio_puntualidad_asistencia\P20Premio', 'p20_premio_id');
    }

    public function subareas(){
        return $this->hasMany('App\Models\p20_premio_puntualidad_asistencia\P20Subareas', 'p20_subareas_id');
    }

    public function nomina(){
        return $this->hasMany('App\Models\p20_premio_puntualidad_asistencia\P20Nomina', 'p20_nomina_id');
    }
}
