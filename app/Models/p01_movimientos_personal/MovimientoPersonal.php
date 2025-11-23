<?php

namespace App\Models\p01_movimientos_personal;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoPersonal extends Model
{
    use HasFactory;

    protected $table = "p01_movimientos_personal";
    protected $primaryKey = "movimiento_personal_id";
    protected $fillable = [
        "area_id", 
        "estatus", 
        "estatus_issste"
    ];
    protected $appends = [
        "ruta_descargar_alimentario",
        "usuario_iniciador"
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }

    public function nivelEstudio()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\NivelEstudio', 'nivel_estudio_id');
    }

    public function estadoCivil()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\EstadoCivil', 'estado_civil_id');
    }

    public function entidadFederativaNacimiento()
    {
        return $this->belongsTo('App\Models\EntidadFederativa', 'entidad_federativa_nacimiento_id', 'entidad_federativa_id');
    }

    public function entidadFederativaDomicilio()
    {
        return $this->belongsTo('App\Models\EntidadFederativa', 'entidad_federativa_domicilio_id', 'entidad_federativa_id');
    }

    public function turno()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\Turno', 'turno_id');
    }

    public function situacionEmpleado()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\SituacionEmpleado', 'situacion_empleado_id');
    }

    public function regimenIssste()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\RegimenIssste', 'regimen_issste_id');
    }

    public function zonaPagadora()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\ZonaPagadora', 'zona_pagadora_id');
    }

    public function tipoPago()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\TipoPago', 'tipo_pago_id');
    }

    public function banco()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\Banco', 'banco_id');
    }

    public function situacionPlaza()
    {
        return $this->belongsTo('App\Models\SituacionPlaza', 'situacion_plaza_id');
    }

    public function nivelSalarial()
    {
        return $this->belongsTo('App\Models\NivelSalarial', 'nivel_salarial_id');
    }

    public function universo()
    {
        return $this->belongsTo('App\Models\Universo', 'universo_id');
    }

    public function calificacionPsicometrico()
    {
        return $this->hasOne('App\Models\p01_movimientos_personal\CalificacionPsicometrico', 'movimiento_personal_id');
    }

    public function sexo()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\Sexo', 'sexo_id');
    }

    public function usuarioAutorizador()
    {
        return $this->belongsTo('App\Models\User', 'autorizador');
    }

    public function usuarioTitular()
    {
        return $this->belongsTo('App\Models\User', 'titular');
    }

    public function getUsuarioIniciadorAttribute()
    {
        return $this->instancia
            ->instanciasTareas()
            ->orderBy("instancia_tarea_id")
            ->first()
            ->creadoPorUsuario;
    }
   
    public function getRutaDescargarAlimentarioAttribute()
    {
        return route("movimiento.personal.reportes.descargar.alimentario", $this);
    }

    public function getFechaSolicitudAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaNacimientoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaAltaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaBajaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaPropuestaInicioAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaFinContratoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaFinAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getFechaElaboracionAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

}
