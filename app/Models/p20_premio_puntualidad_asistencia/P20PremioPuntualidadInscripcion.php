<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use App\Models\Area;
use App\Models\Instancia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P20PremioPuntualidadInscripcion extends Model
{
    use HasFactory;

    protected $table = "p20_premio_puntualidad_inscripcion";
    protected $primaryKey = "premio_puntualidad_inscripcion_id";

    protected $fillable = [
        'premio_puntualidad_id',
        'folio',
        'area_id',
        'estatus',
        'quincena',
        'creado_por',
        'creado_por_area',
        'creado_por_titulo',
        'instrucciones',
        'activo',
    ];

    public function instancia(){
        return $this->morphOne(Instancia::class, 'model');
    }

    public function premioPuntialidad()
    {
        return $this->belongsTo(P20PremioPuntualidad::class, 'premio_puntualidad_id');
    }

    public function area(){
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function areasPremio(){
        return $this->hasMany(P20PremioPuntualidadAreas::class, 'premio_puntualidad_inscripcion_id');
    }

    public function empleadosPremio(){
        return $this->hasMany(P20PremioPuntualidadEmpleados::class, 'premio_puntualidad_inscripcion_id');
    }

}
