<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
namespace App\Models\historico\lbpm_dga\p03_hojas_servicio;

use Illuminate\Database\Eloquent\Model;

class HistoricoSeguimiento extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p03_seguimiento";
    protected $appends = ['seguimiento_id'];

    public function getSeguimientoIdAttribute()
    {
        return $this->p03_seguimiento_id;
    }

    public function hojaServicio()
    {
        return $this->belongsTo(HistoricoHojaServicio::class, 'p03_id');
    }
}
