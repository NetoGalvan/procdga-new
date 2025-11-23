<?php

namespace App\Models\historico\lbpm_sica;

use Illuminate\Database\Eloquent\Model;

class HistoricoBiometrico extends Model
{
    protected $connection = "lbpm_sica";
    protected $table = "catalogo_biometrico";
    protected $appends = [
        "nombre",
        "acceso",
        "ip",
        "ubicacion",
        "tipo"
    ];

    public function eventos()
    {
        return $this->hasMany(HistoricoEvento::class, "tip", "ip_biometrico");
    }

    public function getNombreAttribute()
    {
        return $this->ubicacion_biometrico;
    }

    public function getAccesoAttribute()
    {
        return null;
    }
    
    public function getIpAttribute()
    {
        return $this->ip_biometrico;
    }
    
    public function getUbicacionAttribute()
    {
        return $this->ubicacion_biometrico;
    }
    public function getTipoAttribute()
    {
        return "DACTILAR";
    }
}
