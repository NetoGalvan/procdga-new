<?php

namespace App\Models\p12_tramites_incidencias;

use Illuminate\Database\Eloquent\Model;

class NotaBuena extends Model
{
    protected $table = 'p12_notas_buenas';
    protected $primaryKey = 'nota_buena_id';
    protected $fillable = [
        "periodo", 
        "tipo",
        "incidencia_empleado_id"
    ];

    public function incidenciaEmpleado()
    {
        return $this->belongsTo(IncidenciaEmpleado::class, 'incidencia_empleado_id');
    }
}
