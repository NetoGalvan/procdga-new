<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06Escuela extends Model
{
    use HasFactory;

    protected $table = "p06_escuelas";
    protected $primaryKey = "escuela_id";

    protected $fillable = [
                'institucion_id',
                'nombre_escuela',
                'acronimo_escuela',
                'direccion_escuela',
                'activo',
                'created_at',
                'updated_at'
            ];
/*
    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio'
    ];
*/
    #BEGIN::RELACIONES
    public function institucion(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06Instituciones', 'institucion_id');
    }

    public function prestador(){
        return $this->hasMany('App\Models\p06_servicio_social\P06Prestador', 'prestador_id', 'prestador_id');
    }

    public function servicio(){
        return $this->hasMany('App\Models\p06_servicio_social\P06ServicioSocial', 'servicio_social_id', 'servicio_social_id');
    }

    public function detalle(){
        return $this->hasMany('App\Models\p06_servicio_social\P06Detalle', 'detalle_id', 'detalle_id');
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
    #END::RELACIONES
    #BEGIN::SCOPES
    public function scopeEscuelasPorInstitucion($query, $institucion_id){
        return $query->where('institucion_id', $institucion_id)->where('activo', true)->orderBy('acronimo_escuela')->get();
    }
    #END::SCOPES
}
