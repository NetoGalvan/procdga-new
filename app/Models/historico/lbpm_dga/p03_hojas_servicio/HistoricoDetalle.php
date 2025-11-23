<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
namespace App\Models\historico\lbpm_dga\p03_hojas_servicio;

use Illuminate\Database\Eloquent\Model;

class HistoricoDetalle extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p03_detalle";
    protected $appends = ['detalle_id'];

    public function getDetalleIdAttribute()
    {
        return $this->p03_det_id;
    }

    public function hojaServicio()
    {
        return $this->belongsTo(HistoricoHojaServicio::class, 'p03_id');
    }
}
