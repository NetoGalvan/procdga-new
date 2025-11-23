<?php

namespace App\Models\historico\lbpm_dga\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use Carbon\Carbon;

class HistoricoLogDetail extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p15_log_detail";

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function registroAsistencia()
    {
        return $this->belongsTo(HistoricoRegistroAsistencia::class, 'id_p15_registro', 'id_p15_registro');
    }

}
