<?php

namespace App\Models\historico\lbpm_dga\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23DetalleDigitalizacion;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Indice;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Digitalizacion;

class HistoricoP23Solicitud extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p23_solicitud";
    protected $appends = ['p23_solicitud_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p23_solicitud;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function indice()
    {
        return $this->belongsTo(HistoricoP23Indice::class, 'id_p23_indice', 'id_p23_indice');
    }
}
