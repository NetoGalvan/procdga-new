<?php

namespace App\Models\historico\lbpm_dga\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p16_pago_tiempo_extraordinario_excedente\HistoricoP16TiempoExtraExcedente;

class HistoricoP16Nominas extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p16_17_nominas";
    protected $appends = ['horas_empleado_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p16_17_nomina;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function tiempo()
    {
        return $this->belongsTo(HistoricoP16TiempoExtraExcedente::class, 'id_p16_17_tiempo', 'id_p16_17_tiempo');
    }
}
