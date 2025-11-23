<?php

namespace App\Models\historico\lbpm_dga\p08_solicita_servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoSolicitaServicioDetalle extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p080910_servicios_detalle";
    protected $appends = ['p08_detalle_solicita_servicio_id', 'estatus_detalle'];

    public function getP08DetalleSolicitaServicioIdAttribute()
    {
        return $this->id_solicitud_detalle;
    }

    public function getEstatusDetalleAttribute()
    {
        $estatusDetalle = [
            "OK" => "COMPLETADO",
            "PARTIAL" => "PARCIAL",
            "WONT_DELIVER" => "RECHAZADO",
            "" => null
        ];
        return $estatusDetalle[$this->status_detalle];
    }
}
