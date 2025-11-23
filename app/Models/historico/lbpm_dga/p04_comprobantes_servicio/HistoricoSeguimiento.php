<?php

namespace App\Models\historico\lbpm_dga\p04_comprobantes_servicio;

use Illuminate\Database\Eloquent\Model;

class HistoricoSeguimiento extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p04_seguimiento";
    protected $appends = ['seguimiento_id', 'fecha_seguimiento', 'comentario_seguimiento'];

    public function getSeguimientoIdAttribute()
    {
        return $this->p04_seguimiento_id;
    }

    public function comprobanteServicio()
    {
        return $this->belongsTo(HistoricoComprobanteServicio::class, 'p04_id');
    }

    public function getFechaSeguimientoAttribute()
    {
        return $this->fecha;
    }

    public function getComentarioSeguimientoAttribute()
    {
        return $this->comentario;
    }
}
