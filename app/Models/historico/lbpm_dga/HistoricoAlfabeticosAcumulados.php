<?php

namespace App\Models\historico\lbpm_dga;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoAlfabeticosAcumulados extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "alfabeticos_acumulados";
    protected $appends = [
        'numero_empleado',
        'cn',
    ];

    public function getNumeroEmpleadoAttribute()
    {
        return $this->id_empleado;
    }

    public function getCnAttribute()
    {
        return $this->id_unidad_adm;
    }

}
