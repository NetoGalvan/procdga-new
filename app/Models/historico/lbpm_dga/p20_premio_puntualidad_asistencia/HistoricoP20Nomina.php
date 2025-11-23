<?php

namespace App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20Premio;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20SubprocesoNomina;

class HistoricoP20Nomina extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p20_nomina";
    protected $appends = ['p20_nomina_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja


    public function getInscripcionIdAttribute()
    {
        return $this->id_p20_nomina;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function premio()
    {
        return $this->belongsTo(HistoricoP20Premio::class, 'id_p20_premio_pa', 'id_p20_premio_pa');
    }
}
