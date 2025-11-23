<?php

namespace App\Models\historico\lbpm_dga\p21_premio_administracion;

use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoInscripcion;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoCandidatosPremio;

class HistoricoPremio extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p21_premio";
    protected $appends = ['p21_premio_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja


    public function getP21PremioIdAttribute()
    {
        return $this->id_p21_premio;   // Este es el campo de la base vieja, hay que indicar como se llama
    }

    public function inscripcion(){
        return $this->hasMany(HistoricoInscripcion::class, 'id_p21_premio', 'id_p21_premio');
    }
    
    public function candidatosPremio(){
        return $this->hasMany(HistoricoCandidatosPremio::class, 'id_p21_premio', 'id_p21_premio');  // se hace la relacion con el ID de la base vieja
    }
    
    public function candidatosPremioEstatusSolicitado(){
        return $this->hasMany(HistoricoCandidatosPremio::class, 'id_p21_premio', 'id_p21_premio')->where('status_declinacion', 'SOLICITADO');  // se hace la relacion con el ID de la base vieja
    }

}
