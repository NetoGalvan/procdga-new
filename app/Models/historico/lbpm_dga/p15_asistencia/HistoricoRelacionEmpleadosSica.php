<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoRelacionEmpleadosSica extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_relacion_empleados_sica";

}
