<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Illuminate\Database\Eloquent\Model;

class HistoricoPrestador extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p06_prestadores";
    protected $appends = ['prestador_id', 'estatus_prestador', 'primer_apellido', 'segundo_apellido'];

    public function getPrestadorIdAttribute()
    {
        return $this->id_p06_pres;
    }

    public function getPrimerApellidoAttribute()
    {
        return $this->apellido_paterno;
    }

    public function getSegundoApellidoAttribute()
    {
        return $this->apellido_materno;
    }

    public function getEstatusPrestadorAttribute()
    {
        return $this->status_prestador;
    }

    public function escuela()
    {
        return $this->belongsTo(P06Escuela::class, 'id_p06_esc', 'id_p06_esc');
    }

}
