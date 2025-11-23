<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "areas";
    protected $primaryKey = 'area_id';
    protected $fillable = [
        "nombre",
        "identificador",
        "area_principal_id",
        "unidad_administrativa_id",
        "tipo",
        "activo"
    ];
    protected $appends = ["ruta_editar", "nombre_completo"];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function areaPrincipal()
    {
        if ($this->area_principal_id == null) {
            return $this->belongsTo(Area::class, 'area_id', 'area_id');
        }
        return $this->belongsTo(Area::class, 'area_principal_id', 'area_id');
    }

    public function subAreas()
    {
        return $this->hasMany(Area::class, "area_principal_id", "area_id");
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'area_id');
    }

    public function unidadAdministrativa()
    {
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }

    public function vehiculos()
    {
        return $this->hasMany('App\Models\p08_solicita_servicios\P08Vehiculo', 'area_id');
    }

    public function bitacoras()
    {
        return $this->hasMany('App\Models\p08_solicita_servicios\P08BitacoraRutaGas', 'area_id');
    }

    public function solicitaServicios()
    {
        return $this->hasMany('App\Models\p08_solicita_servicios\P08SolicitaServicio', 'area_id');
    }

    public function getRutaEditarAttribute()
    {
        if (strpos($this->identificador, '.')) {
            return route('unidades.areas.edit', [$this->unidadAdministrativa, $this]);
        }
        return null;
    }

    public function areasProcesos()
    {
        return $this->hasMany('App\Models\p16_pago_tiempo_extraordinario_excedente', 'area_id');
    }

    public function getNombreCompletoAttribute()
    {
        return "$this->identificador - $this->nombre";
    }

    public function scopeTodasLasAreas($query, $search) //Consulta por medio de area_id
    {
      return $query->whereIn('area_principal_id', $search)->orWhereIn('area_id', $search)->get();
    }
}
