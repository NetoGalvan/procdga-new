<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use App\Models\Area;
use App\Models\Instancia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P20PremioPuntualidad extends Model
{
    use HasFactory;

    protected $table = "p20_premio_puntualidad";
    protected $primaryKey = "premio_puntualidad_id";

    protected $fillable = [
        'estatus', 'folio', 'area_id', 'quincena',
        'instrucciones', 'activo', 'fecha_inicio_pago',
        'fecha_fin_pago', 'firmas', 'estructura_concurrente',
        'subproceso_inicio', 'subproceso_fin', 'creado_por',
        'creado_por_area', 'creado_por_titulo'
    ];

    public function instancia(){
        return $this->morphOne(Instancia::class, 'model');
    }

    public function inscripciones(){
        return $this->hasMany(P20PremioPuntualidadInscripcion::class, 'premio_puntualidad_id', 'premio_puntualidad_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

}
