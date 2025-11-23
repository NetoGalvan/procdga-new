<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'unidades_administrativas';
    protected $primaryKey = 'unidad_administrativa_id';
    protected $fillable = [
        'nombre',
        'identificador',
        'dependencia_id',
    ];
    protected $appends = [
        "nombre_completo", "ruta_editar", "ruta_areas"
    ];

    public function scopeActivo($query) {
        return $query->where('activo', 1);
    }

    public function areas() {
        return $this->hasMany(Area::class, 'unidad_administrativa_id');
    }

    function dependencia() {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'unidades_administrativa');
    }

    public function getNombreCompletoAttribute()
    {
        return "$this->identificador - $this->nombre";
    }

    public function getRutaEditarAttribute()
    {
        return route('unidades.edit', $this);
    }
    
    public function getRutaAreasAttribute()
    {
        return route('unidades.areas.index', $this);
    }
}
