<?php

namespace App\Models\historico\lbpm_dga\p06_servicio_social;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoNominaDetalle;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoServicioSocial;

class HistoricoNomina extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p06_nomina";
    //protected $appends = ['nomina_id'];


    public function getNominaIdAttribute()
    {
        return $this->id_p06_nomina;
    }

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function nominaDetalle()
    {
        return $this->hasMany(HistoricoNominaDetalle::class, 'id_p06_nomina', 'id_p06_nomina');
    }
/*
    public function servicioSocial()
    {
        return $this->hasMany(HistoricoServicioSocial::class, 'id_nomina', 'descripcion');
    }
*/
    public function getFechaCreacionAttribute()
    {
        return Carbon::parse($this->instancia->created_on);
    }

    public function getAnioCreacionAttribute()
    {
        return Carbon::parse($this->instancia->created_on)->format('Y');
    }
}
