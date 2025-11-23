<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P20PremioPuntualidadEmpleados extends Model
{
    use HasFactory;

    protected $table = "p20_premio_puntualidad_empleados";
    protected $primaryKey = "premio_puntualidad_empleado_id";

    protected $fillable = [
        'premio_puntualidad_area_id',
        'premio_puntualidad_inscripcion_id',
        'folio',
        'activo',
        'numero_empleado',
        'nombre_empleado',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'nivel_salarial',
        'seccion_sindical',
        'area_empleado',
        'fecha_inicio_evaluacion',
        'fecha_fin_evaluacion',
        'json_detalle_evaluacion',
        'fecha_inicio_siden',
        'fecha_fin_siden',
        'area_empleado',
        'area_identificador_empleado',
        'creado_por',
        'creado_por_area',
        'creado_por_titulo',

    ];

    public function inscripcion()
    {
        return $this->belongsTo(P20PremioPuntualidadInscripcion::class, 'premio_puntualidad_inscripcion_id');
    }

    public function areaPremio()
    {
        return $this->belongsTo(P20PremioPuntualidadAreas::class, 'premio_puntualidad_area_id');
    }


}
