<?php

namespace App\Models\historico\lbpm_dga\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoricoTramiteIncidencia extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p12_justificaciones";
    protected $primaryKey = "id_p12_justificaciones";
    protected $fillable = [
        'id_proc',
        'id_instance',
        'id_p12_justificaciones',
        'folio',
        'work_status',
        'tipo_captura',
        'modalidad_captura',
        'grupo_numeros_empleado',
        'grupo_ous',
        'numero_empleado',
        'apellido_paterno',
        'apellido_materno',
        'nombre_empleado',
        'fecha_alta_empleado',
        'rfc',
        'homoclave',
        'sexo_empleado',
        'id_unidad_administrativa',
        'unidad_administrativa',
        'id_business_category',
        'business_category',
        'id_sindicato',
        'sit_emp',
        'id_puesto',
        'id_zona_pagadora',
        'id_turno',
        'id_empleado_cardex',
        'id_justificacion',
        'ley',
        'tipo_justificacion',
        'articulo',
        'sub_articulo',
        'descripcion',
        'dias',
        'anio',
        'cada_cuantos_dias',
        'fecha_inicio',
        'fecha_fin',
        'gasta',
        'tipo_empleado',
        'status',
        'tipo_dias',
        'antiguedad',
        'sexo',
        'fecha_prescribe',
        'unica_vez',
        'fecha_inicio_justificacion',
        'fecha_fin_justificacion',
        'id_horario_justificacion',
        't_start_justificacion',
        't_end_justificacion',
        'texto_horario_justificacion',
        'dias_justificacion',
        'observaciones_justificacion',
        'id_cardex_detalle_cancelar',
        'folio_a_cancelar',
        'numero_documento',
        'created_by',
        'created_by_ou',
        'created_by_bc',
        'created_by_cn',
        'created_by_title',
        'created_by_area',
        'aprobado_on',
        'aprobado_por',
        'aprobado_por_ou',
        'aprobado_por_cn',
        'aprobado_por_title',
        'aprobado_por_area',
        'revisado_on',
        'revisado_por',
        'revisado_por_ou',
        'revisado_por_cn',
        'revisado_por_title',
        'revisado_por_area',
        'firmas',
        'comentarios_rechazo',
        'created_on',
        'last_modified',
        'status_solicitud',
        'intervalo_evaluacion',
        'debio',
        'razon_debio',
        'json_nota_buena',
    ];
    protected $appends = [
        "tipo_captura",
        "tipo_tramite"
    ];
    public $timestamps = false;

    public function tramiteAsociado()
    {
        return $this->belongsTo(HistoricoTramiteIncidencia::class, "folio_a_cancelar", "folio");
    }

    public function incidenciasEmpleado()
    {
        return $this->hasMany(HistoricoIncidenciaEmpleado::class, "folio_aprobacion", "folio");
    }
    
    public function incidenciasEmpleadoCancelacion()
    {
        return $this->hasMany(HistoricoIncidenciaEmpleado::class, "folio_de_cancelacion", "folio");
    }

    public function getTipoTramiteAttribute()
    {
        $tiposTramites = [
            "INDIVIDUAL" => "INCIDENCIA_INDIVIDUAL",  
            "GRUPAL" => "INCIDENCIA_GRUPAL"
        ];
        return $tiposTramites[$this->modalidad_captura];
    }
    public function getTipoCapturaAttribute()
    {
        if ($this->attributes["tipo_captura"] == "ALTA") {
            return (object) [
                "nombre" => "ALTA",
                "identificador" => "alta"
            ];
        } else if ($this->attributes["tipo_captura"]  == "ALTA NB") {
            return (object) [
                "nombre" => "APLICACIÓN DE NOTAS BUENAS",
                "identificador" => "alta_nb"
            ];
        } 
        return (object) [
            "nombre" => "CANCELACIÓN",
            "identificador" => "cancelacion"
        ];
    }
}
