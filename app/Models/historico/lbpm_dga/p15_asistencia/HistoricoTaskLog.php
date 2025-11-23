<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoTaskLog extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_task_log";

    public function registroAsistencia()
    {
        return $this->belongsTo(HistoricoRegistroAsistencia::class, 'id_p15_registro', 'id_p15_registro');
    }

}
