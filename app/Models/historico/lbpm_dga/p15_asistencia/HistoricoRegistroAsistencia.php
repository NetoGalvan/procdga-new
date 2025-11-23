<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Models\historico\lbpm_dga\HistoricoInstancia;

class HistoricoRegistroAsistencia extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_registro_asistencia";


    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function evaluaciones()
    {
        return $this->hasMany(HistoricoEvaluacion::class, 'id_p15_registro', 'id_p15_registro');
    }
}
