<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Illuminate\Database\Eloquent\Model;


class HistoricoInstituciones extends Model
{
    // protected $connection = "lbpm_dga";
    // protected $table = "p06_prestadores";
    // protected $appends = ['prestador_id', 'estatus_prestador', 'primer_apellido', 'segundo_apellido'];

    public function escuela(){
        return $this->hasMany('App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoEscuela', 'escuela_id', 'escuela_id');
    }

}
