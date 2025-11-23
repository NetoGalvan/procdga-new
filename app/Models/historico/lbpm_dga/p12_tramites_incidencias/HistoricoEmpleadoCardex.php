<?php

namespace App\Models\historico\lbpm_dga\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Model;

class HistoricoEmpleadoCardex extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p12_14_empleados_cardex";
    protected $primaryKey = "id_empleado_cardex";
}
