<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Illuminate\Database\Eloquent\Model;

class HistoricoEscuela extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p06_escuelas";
    protected $appends = ['escuela_id'];


    public function getEscuelaIdAttribute()
    {
        return $this->id_p06_esc;
    }

    public function institucion(){
        return $this->belongsTo('App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoInstituciones', 'institucion_id', 'institucion_id');
    }
}
