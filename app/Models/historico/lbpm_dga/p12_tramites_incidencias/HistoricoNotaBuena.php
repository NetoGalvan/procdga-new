<?php

namespace App\Models\historico\lbpm_dga\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Model;

class HistoricoNotaBuena extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p18_nb_detalle";
    protected $primaryKey = "id_p18_nb_detalle";
}
