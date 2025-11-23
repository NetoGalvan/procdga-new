<?php

namespace App\Models\p31_viatinet;

use Illuminate\Database\Eloquent\Model;

class Comisionado extends Model
{
    protected $table = 'p31_comisionados';
    protected $primaryKey = 'comisionado_id';
    protected $appends = ['tipo_partida_terreste', 'tipo_partida_aereo', 'tipo_partida_integral'];

    public function solicitudViatico() {
        return $this->belongsTo(SolicitudViatico::class, 'solicitud_viatico_id');
    }

    public function tiposPartidas() {
        return $this->belongsToMany(TipoPartida::class, 'p31_comisionado_tipo_partida', 'comisionado_id', 'tipo_partida_id');
    }

    public function getTipoPartidaTerresteAttribute()
    {       
        return $this->tiposPartidas()
            ->where(function($query) {
                $query->where("identificador", "pasajes_terrestres_nacionales")
                    ->orWhere("identificador", "pasajes_terrestres_internacionales");
            })
            ->withPivot("importe")
            ->first();
    }
    
    public function getTipoPartidaAereoAttribute()
    {       
        return $this->tiposPartidas()
            ->where(function($query) {
                $query->where("identificador", "pasajes_aereos_nacionales")
                ->orWhere("identificador", "pasajes_aereos_internacionales");
            })
            ->withPivot("importe")
            ->first();
    }

    public function getTipoPartidaIntegralAttribute()
    {       
        return $this->tiposPartidas()
            ->where("identificador", "servicios_integrales")
            ->withPivot("importe")
            ->first();
    }
}
