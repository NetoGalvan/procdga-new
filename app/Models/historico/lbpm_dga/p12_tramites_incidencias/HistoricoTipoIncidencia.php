<?php

namespace App\Models\historico\lbpm_dga\p12_tramites_incidencias;

use App\Models\p12_tramites_incidencias\TipoJustificacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoTipoIncidencia extends Model
{
    use HasFactory;

    protected $connection = "lbpm_dga";
    protected $table = "p12_14_catalogo_tipo_justificacion";
    protected $primaryKey = "id_justificacion";
    protected $appends = [
        "tipo_incidencia_id",
        "tipo_justificacion",
        "subarticulo"
    ];
    
    // Accesors
    public function getTipoIncidenciaIdAttribute()
    {
        return $this->id_justificacion;
    }

    public function getIntervaloEvaluacionAttribute($value)
    {
        $intervalosEvaluacion = [
            "0001" => "SALIDA",
            "1000" => "ENTRADA",
            "1001" => "TODO_EL_DIA",
            "1010" => "RETARDO_GRAVE",
            "1100" => "RETARDO_LEVE"
        ];
        return $intervalosEvaluacion[$value];
    }

    public function getTipoJustificacionAttribute()
    {
        $relacionTipoJustificacion = [
            "Baja" => "baja",
            "Cambio de horario" => "cambio_horario",
            "Comisión Oficial" => "comision_oficial",
            "Comisión Sindical" => "comision_sindical",
            "Cuidado materno" => "cuidado_materno",
            "Defunción" => "defuncion",
            "Dia sindical" => "dia_sindical",
            "Excencion de registro de asistencia" => "excencion_registro_asistencia",
            "Horario especial eventos y espectáculos" => "horario_especial_eventos",
            "Licencia médica" => "licencia_medica",
            "Licencias con sueldo" => "licencia_con_sueldo",
            "Licencias sin sueldo" => "licencia_sin_sueldo",
            "Lista de asistencia" => "lista_asistencia",
            "Maternidad" => "maternidad",
            "Nota buena - Inasistencia" => "nota_buena_inasistencia",
            "Nota buena - RG" => "nota_buena_retardo_grave",
            "Nota buena - RL" => "nota_buena_retardo_leve",
            "Oficio" => "oficio",
            "Omisión" => "omision",
            "Otra" => "otra",
            "RD" => "reloj_descompuesto",
            "Suspensión por nombramiento" => "suspension_por_nombramiento",
            "Suspensiones" => "suspensiones",
            "Tolerancia" => "tolerancia",
            "Vacaciones" => "vacaciones"
        ];

        return (object) [
            "nombre" => mb_strtoupper($this->attributes['tipo_justificacion']), 
            "identificador" => $relacionTipoJustificacion[$this->attributes['tipo_justificacion']]
        ];
    }
    
    public function getTipoDiasAttribute($value)
    {
        return mb_strtoupper($value);
    }

    public function getTipoEmpleadoAttribute($value)
    {
        return mb_strtoupper(str_replace(" ", "_", $value));
    }
    
    public function getSubarticuloAttribute()
    {
        return $this->attributes["sub_articulo"];
    }
}