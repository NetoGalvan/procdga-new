<?php

namespace App\Models\historico\lbpm_dga\p02_tramites_issste;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoTramiteIssste extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p02_issste";
    protected $appends = ["created_at"];

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function detalles()
    {
        return $this->belongsTo(HistoricoTramiteIssste::class, 'p02_id');
    }

    public function getCreatedAtAttribute() {
        $year = date('d-m-Y - H:i:s', strtotime($this->instancia->created_on));
        return $year;
    }
}
