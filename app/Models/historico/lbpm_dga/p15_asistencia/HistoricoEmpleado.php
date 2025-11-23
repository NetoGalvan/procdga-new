<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoEmpleado extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p24_alfabetico_main";
}
