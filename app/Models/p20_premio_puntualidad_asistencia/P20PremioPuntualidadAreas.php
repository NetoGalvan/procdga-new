<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P20PremioPuntualidadAreas extends Model
{
    use HasFactory;

    protected $table = "p20_premio_puntualidad_areas";
    protected $primaryKey = "premio_puntualidad_area_id";

    public function empleadosPremio(){
        return $this->hasMany(P20PremioPuntualidadEmpleados::class, 'premio_puntualidad_area_id');
    }

    public function inscripcion(){
        return $this->belongsTo(P20PremioPuntualidadInscripcion::class, 'premio_puntualidad_inscripcion_id');
    }

    public function area(){
        return $this->belongsTo(Area::class, 'area_id');
    }

}
