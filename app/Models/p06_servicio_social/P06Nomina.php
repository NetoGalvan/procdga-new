<?php

namespace App\Models\p06_servicio_social;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06Nomina extends Model
{
    use HasFactory;

    protected $table = "p06_nomina";
    protected $primaryKey = "nomina_id";

    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio', 'tipo_validacion', 'descripcion', 'observaciones'
    ];

    public function nominaDetalle(){
        return $this->hasMany('App\Models\p06_servicio_social\P06NominaDetalle', 'nomina_id', 'nomina_id');
    }

    public function entidad()
    {
        return $this->belongsTo('App\Models\EntidadFederativa', 'entidad_id');
    }

    public function unidadAdministrativa()
    {
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }
    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    // public function instanciaSubProcesosNomina()
    // {
    //     return $this->morphOne('App\Models\InstanciaSubProcesoNomina', 'model');
    // }

    public function servicioSociales() {
        return $this->hasMany(P06ServicioSocial::class, 'nomina_id', 'nomina_id')->where('payment_estatus', 'ACEPTADO');
    }

    public function getFechaCreacionAttribute()
    {
        return Carbon::parse($this->instancia->created_at);
    }

    public function getAnioCreacionAttribute()
    {
        return Carbon::parse($this->instancia->created_at)->format('Y');
    }

}
