<?php

namespace App\Models\historico\lbpm_dga\p21_premio_administracion;

use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoPremio;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoInscripcion;

class HistoricoCandidatosPremio extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p21_candidatos_premio";
    protected $appends = ['p21_candidatos_premio_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja


    public function getCandidatosPremioIdAttribute()
    {
        return $this->id_p21_candidatos_premio;   // Este es el campo de la base vieja, hay que indicar como se llama
    }

    public function candidatosPremio()
    {
        return $this->belongsTo(HistoricoPremio::class, 'id_p21_premio', 'id_p21_premio');
    }

}
