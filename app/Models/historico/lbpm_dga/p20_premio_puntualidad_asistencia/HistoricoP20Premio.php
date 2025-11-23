<?php

namespace App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20Nomina;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20SubprocesoNomina;

class HistoricoP20Premio extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p20_premio_pa";
    protected $appends = ['p20_premio_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p20_premio_pa;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function nomina(){
        return $this->hasMany(HistoricoP20Nomina::class, 'id_p20_premio_pa', 'id_p20_premio_pa');
    }

    public function subproceso(){
        return $this->hasMany(HistoricoP20SubprocesoNomina::class, 'id_p20_premio_pa', 'id_p20_premio_pa');
    }
}
