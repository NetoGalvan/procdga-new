<?php

namespace App\Models\historico\lbpm_dga\p21_premio_administracion;

use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoPremio;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoCandidatosPremio;

class HistoricoInscripcion extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p21_inscripcion";
    protected $appends = ['p21_inscripcion_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja


    public function getInscripcionIdAttribute()
    {
        return $this->id_p21_inscripcion;   // Este es el campo de la base vieja, hay que indicar como se llama
    }

    public function inscripcion()
    {
        return $this->belongsTo(HistoricoPremio::class, 'id_p21_premio', 'id_p21_premio');
    }

}
