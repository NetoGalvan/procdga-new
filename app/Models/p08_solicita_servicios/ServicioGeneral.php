<?php

namespace App\Models\p08_solicita_servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioGeneral extends Model
{
    protected $table = 'servicios_generales';
    protected $primarykey = 'servicio_general_id';

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    function servicios() {
        return $this->hasMany(Servicio::class, 'servicio_general_id', 'servicio_general_id')->where("activo", true);
    }

    function solicitudesServicios() {
        return $this->belongsTo(P08SolicitaServicio::class, 'servicio_general_id', 'servicio_general_id');
    }

}
