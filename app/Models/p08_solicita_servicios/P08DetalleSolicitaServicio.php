<?php

namespace App\Models\p08_solicita_servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P08DetalleSolicitaServicio extends Model
{
    protected $table = "p08_detalle_solicita_servicios";
    protected $primaryKey = "p08_detalle_solicita_servicio_id";
    protected $appends = ['nombre_servicio'];

    public function solicitudServicio()
    {
        return $this->belongsTo(P08SolicitaServicio::class, 'p08_solicita_servicio_id', 'p08_solicita_servicio_id');
    }

    public function servicio()
    {
        return $this->hasOne(Servicio::class, 'servicio_id', 'servicio_id');
    }

    public function getNombreServicioAttribute()
    {
        return $this->servicio->nombre_servicio;
    }

}
