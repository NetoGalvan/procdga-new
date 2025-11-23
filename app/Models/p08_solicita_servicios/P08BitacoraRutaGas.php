<?php

namespace App\Models\p08_solicita_servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P08BitacoraRutaGas extends Model
{
    protected $table = "p08_bitacora_rutas_gas";
    protected $primaryKey = "p08_bitacora_ruta_gas_id";

    public function vehiculo()
    {
        return $this->belongsTo(P08Vehiculo::class, 'p08_vehiculo_id');
    }

}
