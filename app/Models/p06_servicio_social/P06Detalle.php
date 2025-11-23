<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06Detalle extends Model
{
    use HasFactory;

    protected $table = "p06_detalle";
    protected $primaryKey = "detalle_id";

    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio'
    ];

    public function escuela(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06Escuela', 'escuela_id', 'escuela_id');
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
}
