<?php

namespace App\Models\historico\lbpm_dga\p04_comprobantes_servicio;

use Illuminate\Database\Eloquent\Model;

class HistoricoDetalle extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p04_detalle";
    protected $appends = ['detalle_id', 'comentario_detalle', 'fecha_detalle'];

    public function getDetalleIdAttribute()
    {
        return $this->p04_det_id;
    }

    public function comprobanteServicio()
    {
        return $this->belongsTo(HistoricoComprobanteServicio::class, 'p04_id');
    }

    public function getComentarioDetalleAttribute()
    {
        return $this->texto_comentario;
    }

    public function getFechaDetalleAttribute()
    {
        return $this->fecha_modificacion;
    }

}
