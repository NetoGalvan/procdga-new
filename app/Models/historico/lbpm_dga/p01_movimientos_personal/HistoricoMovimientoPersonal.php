<?php

namespace App\Models\historico\lbpm_dga\p01_movimientos_personal;

use App\Models\historico\lbpm_dga\p01_movimientos_personal\HistoricoInstancia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoMovimientoPersonal extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p01_movimientos_de_personal";
    protected $appends = [
        'movimiento_personal_id',
        'usuario_autorizador',
        'usuario_titular',
        'usuario_iniciador',
        'nombre_unidad',
        'identificador_unidad',
        'identificador_situacion_plaza',
        'identificador_situacion_empleado',
        'identificador_turno',
        'identificador_zona_pagadora',
        'nombre_tipo_pago',
        'nombre_banco',
        'municipio_alcaldia',
        'cn',
        'sociedad_id',
        'nombre_area',
        'numero_plaza',
        'estatus'
    ];

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function getMovimientoPersonalIdAttribute()
    {
        return $this->p01_id;
    }

    public function getNombreBancoAttribute()
    {
        return $this->banco;
    }

    public function getIdentificadorTurnoAttribute()
    {
        return $this->turno;
    }

    public function getIdentificadorZonaPagadoraAttribute()
    {
        return $this->zona_pagadora;
    }

    public function getIdentificadorSituacionPlazaAttribute()
    {
        return $this->situacion_plaza;
    }

    public function getIdentificadorSituacionEmpleadoAttribute()
    {
        return $this->situacion_empleado;
    }

    public function getIdentificadorUniversoAttribute()
    {
        return $this->universo;
    }

    public function getUsuarioIniciadorAttribute()
    {
        return (object) [
            "nombre_completo" => $this->instancia->created_by_cn,
            "puesto" => $this->instancia->created_by_title,
            "nombre_area" => $this->instancia->created_by_uas_ou
        ];
    }

    public function getUsuarioAutorizadorAttribute()
    {
        $firmas = $this->firmas;

        if (!is_null($firmas)) {
            $firmas = str_replace("{", "", $firmas);
            $firmas = str_replace("}", "", $firmas);
            $firmas = str_replace('"', "", $firmas);
            $firmas = explode(",", $firmas);

            return (object) [
                "nombre_completo" => $firmas[0],
                "puesto" => $firmas[1]
            ];
        }

        return (object) [
            "nombre_completo" => "",
            "puesto" => "",
        ];
    }

    public function getUsuarioTitularAttribute()
    {
        $firmas = $this->firmas;

        if (!is_null($firmas)) {
            $firmas = str_replace("{", "", $firmas);
            $firmas = str_replace("}", "", $firmas);
            $firmas = str_replace('"', "", $firmas);
            $firmas = explode(",", $firmas);

            return (object) [
                "nombre_completo" => $firmas[2],
                "puesto" => $firmas[3]
            ];
        }

        return (object) [
            "nombre_completo" => "",
            "puesto" => "",
        ];
    }

    public function getIdentificadorUnidadAttribute()
    {
        return  $this->id_business_category;
    }

    public function getNombreUnidadAttribute()
    {
        return $this->business_category;
    }

    public function getMunicipioAlcaldiaAttribute()
    {
        return $this->mpio_delegacion;
    }

    public function getNombreTipoPagoAttribute()
    {
        return $this->modo_pago;
    }

    public function getSociedadIdAttribute()
    {
        return $this->id_sociedad;
    }

    public function getCnAttribute()
    {
        return $this->id_unidad_administrativa;
    }

    public function getNombreAreaAttribute()
    {
        return $this->unidad_administrativa;
    }

    public function getNumeroPlazaAttribute()
    {
        return $this->id_plaza;
    }

    public function getFechaSolicitudAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getEstatusAttribute()
    {
        if (is_null($this->status_cierre))
            return null;

        $estatus = [
            "READY" => "EN_PROCESO",
            "COMPLETED" => "COMPLETADO",
            "PREMATURE_END" => "CANCELADO",
            "RECHAZADO" => "RECHAZADO",
        ];
        return $estatus[$this->status_cierre];
    }
}
