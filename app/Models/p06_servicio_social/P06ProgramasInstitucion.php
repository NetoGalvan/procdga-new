<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06ProgramasInstitucion extends Model
{
    use HasFactory;

    protected $table = "p06_programas_instituciones";
    protected $primaryKey = "programa_id";

    protected $fillable = [
        'institucion_id',
        'nombre_programa',
        'clave_programa',
        'activo',
        'created_at',
        'updated_at'
    ];
/*
    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio'
    ];
*/
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
    
    public function servicioSocial()
    {
        return $this->hasOne('App\Models\p06_servicio_social\P06ServicioSocial', 'programa_id');
    }

    public function institucion(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06Instituciones', 'programa_id');
    }

    public function prestador() {
        return $this->hasMany('App\Models\p06_servicio_social\P06Prestador', 'programa_id');
    }
    #BEGIN::SCOPES
    public function scopeProgramasPorInstitucion($query, $institucion_id){
        return $query->where('institucion_id', $institucion_id)->where('activo', true)->orderBy('clave_programa')->get();
    }
    #END::SCOPES
}
