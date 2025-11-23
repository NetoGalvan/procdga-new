<?php

namespace App\Models\historico\lbpm_sica;

use Illuminate\Database\Eloquent\Model;

class HistoricoEvento extends Model
{
    protected $connection = "lbpm_sica";
    protected $table = "p15_eventos";
    protected $primaryKey = "id";
    protected $appends = [
        "fecha", 
        "numero_empleado",
        "estatus"
    ];

    public function biometrico()
    {
        return $this->belongsTo(HistoricoBiometrico::class, "tip", "ip_biometrico");
    }

    public function getFechaAttribute()
    {
        return $this->ts_evento;
    }
    
    public function getNumeroEmpleadoAttribute()
    {
        return $this->no_empleado;
    }
      
    public function getEstatusAttribute()
    {
        return "REGISTRO_VERIFICADO";
    }
}