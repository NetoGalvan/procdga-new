<?php

namespace App\Models\historico\lbpm_dga\p02_tramites_issste;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\HistoricoMovimientoPersonal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoTramiteIsssteDetalle extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p02_issste_detalle";

    protected $appends = ["anio", "nombre_unidad", "tipo_movimiento_issste_nombre"];

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function tramiteIssste()
    {
        return $this->belongsTo(HistoricoTramiteIssste::class, 'p02_id');
    }

    public function getAnioAttribute() {
        $year = date('Y', strtotime($this->instancia->created_on));
        return $year;
    }

    public function movimientoPersonal() {
        return $this->hasOne(HistoricoMovimientoPersonal::class, "folio", "folio_p01");
    }

    public function getNombreUnidadAttribute() {
        return $this->movimientoPersonal->unidad_administrativa;
    }

    public function getTipoMovimientoIsssteNombreAttribute() {
        return $this->tipo_movimiento_issste;
    }

}
