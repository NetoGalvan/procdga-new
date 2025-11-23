<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06NominaDetalle extends Model
{
    use HasFactory;

    protected $table = "p06_nomina_detalle";
    protected $primaryKey = "nomina_detalle_id";

    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio'
    ];

    public function nomina(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06Nomina', 'nomina_id', 'nomina_id');
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
        return $this->belongsTo('App\Models\Instancia', 'instancia_id');
    }

    public function servicioSocial() {
        return $this->belongsTo(P06ServicioSocial::class, 'servicio_social_id', 'servicio_social_id');
    }
}
