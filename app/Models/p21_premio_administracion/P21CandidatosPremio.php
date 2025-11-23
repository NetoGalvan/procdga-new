<?php

namespace App\Models\p21_premio_administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P21CandidatosPremio extends Model
{
    use HasFactory;

    protected $table = "p21_candidatos_premio";
    protected $primaryKey = "p21_candidatos_premio_id";

    protected $fillable = [
        'instancia_id', 'folio', 'p21_premio_id', 'creado_por', 'creado_por_area', 'creado_por_area_nombre', 'creado_por_titulo', 'activo', 'comentarios_oper_cap_21', 'area_creadora_id', 'evaluado_por', 'evaluado_por_area', 'evaluado_por_area_nombre', 'evaluado_por_titulo', 'evaluado_fecha', 'validado_por', 'validado_por_area', 'validado_por_area_nombre', 'validado_por_titulo', 'validado_fecha', 'json_cursos', 'estatus_tiempo', 'estatus_origen', 'estatus_declinacion', 'comentarios_declinacion', 'folio_inscripcion', 'estatus_inscripcion', 'comentarios_oper_pa_21', 'numero_empleado', 'nombre_empleado', 'apellido_paterno', 'apellido_materno', 'rfc', 'seccion_sindical', 'nivel_salarial', 'fecha_ingreso', 'codigo_puesto', 'puesto', 'area_inscripcion_id', 'unidad_administrativa_id', 'unidad_administrativa', 'subunidad_id', 'antiguedad_puesto_actual', 'domicilio_laboral', 'telefono_laboral', 'ext_telefono_laboral', 'denominacion_puesto', 'descripcion_actividades', 'nombre_jefe', 'cargo_jefe', 'tipo_nombramiento', 'propuesto_por', 'grupo', 'fecha_evaluacion_desempenio', 'json_desempenio', 'json_puntualidad_asistencia', 'total_art_87'
    ];

    public function premioAdministracion()
    {
        return $this->belongsTo(PremioAdministracion::class, 'p21_candidatos_premio_id');
    }

    public function inscripcion()
    {
        return $this->belongsTo(P21Inscripcion::class, 'p21_candidatos_premio_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
