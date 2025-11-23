<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Area;

use App\Models\p06_servicio_social\P06AreasAdscripcion;

class P06ServicioSocial extends Model
{
    use HasFactory;

    protected $table = "p06_servicio_social";
    protected $primaryKey = "servicio_social_id";

    protected $fillable = [
        "area_id", "nombre_area", "estatus"
    ];

    public function escuela() {
        return $this->belongsTo('App\Models\p06_servicio_social\P06Escuela', 'escuela_id', 'escuela_id');
    }

    public function entidad() {
        return $this->belongsTo('App\Models\EntidadFederativa', 'entidad_federativa_id');
    }

    public function unidadAdministrativa() {
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }

    public function prestador() {
        return $this->belongsTo('App\Models\p06_servicio_social\P06Prestador', 'prestador_id');
    }
    // public function prestador() { // Así estaba originalmente, se cambio a belongsTo (por si truena en algo)
    //     return $this->hasOne('App\Models\p06_servicio_social\P06Prestador', 'prestador_id');
    // }

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function prestadorDetalleNomina() {
        return $this->belongsTo('App\Models\p06_servicio_social\P06Prestador', 'prestador_id', 'prestador_id')->select('nombre_prestador', 'primer_apellido', 'segundo_apellido', 'tipo_prestador', 'carrera', 'estatus_prestador');
    }

    public function nomina() {
        return $this->belongsTo('App\Models\p06_servicio_social\P06Nomina', 'nomina_id');
    }


    public function nominaDetalle(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06NominaDetalle', 'servicio_social_id', 'servicio_social_id')->select('fecha_cerrado', 'meses_pagar', 'tipo_pago');
    }

    public function detalle() {
        return $this->hasMany('App\Models\p06_servicio_social\P06Detalle', 'detalle_id');
    }

    public function programa() {
        return $this->belongsTo('App\Models\p06_servicio_social\P06Programa', 'programa_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function areaAdscripcion(){
        return $this->belongsTo(P06AreasAdscripcion::class, 'area_adscripcion_id');
    }

    public function detalleArchivos() {
        return $this->hasMany('App\Models\p06_servicio_social\P06DetalleArchivos', 'detalle_archivo_id');
    }


    public function getNombrePrestadorCompletoAttribute()
    {
        return $this->prestador->primer_apellido.' '.$this->prestador->segundo_apellido.' '.$this->prestador->nombre_prestador;
    }

    public function getNombreUnidadAdministrativaAttribute()
    {
        return $this->area->identificador.' - '.$this->area->nombre;
    }

    public function getClaveProgramAttributea()
    {
        return $this->prestador->programa->clave_programa;
    }

    public function getNombreProgramaAttribute()
    {
        return ($this->prestador->programa->nombre_programa ?? 'S/D');
    }
}
