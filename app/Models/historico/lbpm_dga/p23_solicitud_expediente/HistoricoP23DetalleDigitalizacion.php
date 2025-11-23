<?php

namespace App\Models\historico\lbpm_dga\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Solicitud;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Indice;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Digitalizacion;

class HistoricoP23DetalleDigitalizacion extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p23_detalle_digitalizacion";
    protected $appends = ['p23_detalle_digitalizacion_id'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p23_detalle_digitalizacion;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function digitalizacion()
    {
        return $this->belongsTo(HistoricoP23Digitalizacion::class, 'id_p23_digitalizacion', 'id_p23_digitalizacion');
    }
}
