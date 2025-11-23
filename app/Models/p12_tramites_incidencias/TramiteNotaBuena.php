<?php

namespace App\Models\p12_tramites_incidencias;

use App\Models\Area;
use App\Models\Instancia;
use Illuminate\Database\Eloquent\Model;

class TramiteNotaBuena extends Model
{
    protected $table = 'p12_tramites_notas_buenas';
    protected $primaryKey = 'tramite_nota_buena_id';
    protected $fillable = [
        "estatus", 
        "folio",
        "area_id",
        "tramite_incidencia_id"
    ];

    public function instancia()
    {
        return $this->morphOne(Instancia::class, 'model');
    }
    
    function area() 
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }
}
