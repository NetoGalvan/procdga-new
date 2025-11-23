<?php

namespace App\Models\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIncidencia extends Model
{
    use HasFactory;
    protected $table = 'p12_tipos_incidencias';
    protected $primaryKey = 'tipo_incidencia_id';
    protected $fillable = [
        "tipo_incidencia_id",
        "ley",
        "tipo_justificacion_id",
        "articulo",
        "subarticulo",
        "descripcion",
        "dias",
        "anio",
        "cada_cuantos_dias",
        "fecha_inicio",
        "fecha_final",
        "gasta",
        "tipo_empleado",
        "activo",
        "tipo_dias",
        "antiguedad",
        "sexo",
        "fecha_prescribe",
        "observaciones",
        "unica_vez",
        "intervalo_evaluacion",
        "aplica_autoincidencia",
        "json_fechas_inhabiles"
    ];
    protected $appends = ["tipo_justificacion_nombre", "ruta_editar"];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function tipoJustificacion()
    {
        return $this->belongsTo(TipoJustificacion::class, 'tipo_justificacion_id');
    }

    public function getSubarticuloAttribute($value)
    {       
        return is_null($value) || empty(trim($value)) ? null : trim($value);
    }   
    public function getTipoJustificacionNombreAttribute()
    {
        return $this->tipoJustificacion->nombre;
    } 
    public function getRutaEditarAttribute()
    {
        return route('tramite.incidencia.catalogo.tipos.incidencias.edit', $this);
    } 
}
