<?php

namespace App\Models\historico\lbpm_dga\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p16_pago_tiempo_extraordinario_excedente\HistoricoP16Nominas;

class HistoricoP16TiempoExtraExcedente extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p16_17_tiempo_extra_excedente";
    protected $appends = ['pago_tiempo_extra_excedente_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p16_17_tiempo;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function nomina(){
        return $this->hasMany(HistoricoP16Nominas::class, 'id_p16_17_tiempo', 'id_p16_17_tiempo');
    }

}
