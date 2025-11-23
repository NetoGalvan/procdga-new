<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Illuminate\Database\Eloquent\Model;

class HistoricoPrograma extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p06_programas";
    protected $appends = ['programa_id'];


    public function getProgramaIdAttribute()
    {
        return $this->id_p06_prog;
    }
}
