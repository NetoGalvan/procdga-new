<?php

namespace App\Models\historico\lbpm_dga\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23DetalleDigitalizacion;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Indice;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Solicitud;

class HistoricoP23Digitalizacion extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p23_digitalizacion";
    protected $appends = ['p23_digitalizacion_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p23_digitalizacion;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function indice()
    {
        return $this->belongsTo(HistoricoP23Indice::class, 'id_p23_digitalizacion', 'id_p23_digitalizacion');
    }

    public function detalleDigitalizacion(){
        return $this->hasMany(HistoricoP23DetalleDigitalizacion::class, 'id_p23_digitalizacion', 'id_p23_digitalizacion');
    }
}
