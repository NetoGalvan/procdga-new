<?php

namespace App\Models\historico\lbpm_dga\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23DetalleDigitalizacion;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Solicitud;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Digitalizacion;

class HistoricoP23Indice extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p23_indice";
    protected $appends = ['nombre_empleado_completo'];    // Estos son los campos de la nueva base, se ponen aquí los campos que no se llamen igual que en la vieja

    public function getP21PremioIdAttribute()
    {
        return $this->id_p23_indice;   // Este es el id de la tabla de la base vieja, hay que indicar como se llama
    }

    public function solicitud(){
        return $this->hasMany(HistoricoP23Solicitud::class, 'id_p23_indice', 'id_p23_indice');
    }

    public function digitalizacion(){
        return $this->hasMany(HistoricoP23Digitalizacion::class, 'id_p23_indice', 'id_p23_indice');
    }

    public function getNombreEmpleadoCompletoAttribute()
    {
        return $this->apellido_paterno.' '.$this->apellido_materno.' '.$this->nombre_empleado;
    }
}
