<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\p22_reportes_dias_efectivamente_laborados\P22ReporteDetalle;

class Empleado extends Model
{
    use HasFactory;

    protected $table = "empleados";
    protected $primaryKey = "empleado_id";
    protected $fillable = [
        'empleado_id',
        'plaza_id',
        'sector',
        'unidad_administrativa',
        'numero_empleado',
        'apellido_paterno',
        'apellido_materno',
        'nombre',
        'nombre_completo',
        'rfc',
        'curp',
        'fecha_nacimiento',
        'sexo',
        'subunidad',
        'direccion_administrativa',
        'subdireccion',
        'jud',
        'oficina',
        'nomina',
        'codigo_universo',
        'nivel_salarial',
        'codigo_puesto',
        'puesto',
        'seccion_sindical',
        'codigo_situacion_empleado',
        'numero_plaza',
        'fecha_alta_empleado',
        'fecha_antiguedad',
        'codigo_turno',
        'zona_pagadora',
        'ssn',
        'dias_trabajados',
        'codigo_regimen_issste',
        'acct_no',
        'banco',
        'sueldo_bruto',
        'deducciones',
        'sueldo_neto',
        'hijos',
        'unidad_administrativa_nombre',
        'activo',
        'quincenas_activo',
        'area_id'
    ];
    protected $appends = [
        "es_sindicalizado",
        "tipo_empleado"
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function getEsSindicalizadoAttribute()
    {
        return $this->seccion_sindical != 0;
    }
    
    public function getTipoEmpleadoAttribute()
    {
        if ($this->es_sindicalizado) {
            return "SINDICALIZADO";
        } else if ($this->nomina == "8") {
            return "NOMINA_8";
        } else if ($this->nivel_salarial >= 20 && $this->nivel_salarial <= 48) {
            return "ESTRUCTURA";
        } 
        return "NO_SINDICALIZADO";
    }

    public function plaza()
    {
        return $this->hasOne(Plaza::class, 'plaza_id', 'plaza_id');
    }

    public function usuario()
    {
        return $this->hasOne(User::class, 'empleado_id', 'empleado_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function udAdministrativa()
    {
        return $this->belongsTo(UnidadAdministrativa::class, 'unidad_administrativa');
    }

    public function empleado()
    {
        return $this->hasMany(Empleado::class, 'empleado_id');
    }
}
