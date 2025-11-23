<?php

namespace App\Models\p08_solicita_servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P08Vehiculo extends Model
{
    protected $table = "p08_vehiculos";
    protected $primaryKey = "p08_vehiculo_id";

    public function bitacoraRutaGas()
    {
        return $this->hasMany(P08BitacoraRutaGas::class, 'p08_vehiculo_id', 'p08_vehiculo_id');
    }

}
