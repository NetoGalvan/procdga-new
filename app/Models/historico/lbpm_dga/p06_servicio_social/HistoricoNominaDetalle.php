<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoNomina;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoServicioSocial;

class HistoricoNominaDetalle extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p06_nomina_detalle";
    protected $appends = ['nomina_detalle_id'];


    public function getNominaDetalleIdAttribute()
    {
        return $this->id_p06_nomina_detalle;
    }

    public function nominaDetalle()
    {
        return $this->belongsTo(HistoricoNomina::class, 'id_p06_nomina', 'id_p06_nomina');
    }

    public function servicioSocial()
    {
        return $this->belongsTo(HistoricoServicioSocial::class, 'id_p06', 'id_p06');
    }
}
