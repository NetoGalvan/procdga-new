<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoNomina;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoNominaDetalle;

class HistoricoServicioSocial extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p06_servicio_social";
/*
    protected $appends = [ 'servicio_social_id', 'estatus', 'primer_apellido', 'segundo_apellido', 'fecha_creacion_servicio_social', 'nombre_entidad', 'nombre_area'];
*/
    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function servicioSocialDetalle()
    {
        return $this->hasOne(HistoricoNominaDetalle::class, 'id_p06', 'id_p06');
    }

    public function nomina()
    {
        return $this->belongsTo(HistoricoNomina::class, 'id_nomina', 'descripcion');
    }

    public function getServicioSocialIdAttribute()
    {
        return $this->id_p06;
    }

    public function getEstatusAttribute()
    {
        $estatusServicioSocial = [
            "WORKING" => "WORKING",
            "FREE" => "LIBERADO",
            "ABANDON" => "DADO_DE_BAJA",
            "BLOCKED" => "RECHAZADO",
            "PREMATURE_END" => "RECHAZADO",
        ];
        return $estatusServicioSocial[$this->work_status];
    }

    public function getPrimerApellidoAttribute()
    {
        return $this->apellido_paterno;
    }

    public function getSegundoApellidoAttribute()
    {
        return $this->apellido_materno;
    }

    public function getNombreEntidadAttribute()
    {
        return $this->entidad;
    }

    public function getFechaCreacionServicioSocialAttribute()
    {
        return Carbon::parse($this->instancia->created_on)->format('d-m-Y');
    }

    public function getNombreAreaAttribute()
    {
        return $this->unidad_administrativa;
    }

    public function getNombrePrestadorCompletoAttribute()
    {
        return $this->apellido_paterno.' '.$this->apellido_materno.' '.$this->nombre_prestador;
    }

    public function getNombreUnidadAdministrativaAttribute()
    {
        return $this->id_unidad_administrativa.' - '.$this->unidad_administrativa;
    }
}
