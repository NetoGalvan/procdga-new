<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plaza extends Model
{
    use HasFactory;

    protected $table = "plazas";
    protected $primaryKey = "plaza_id";
    protected $fillable = [
        'numero_plaza',
        'unidad_administrativa',
        'subunidad',
        'direccion_administrativa',
        'subdireccion',
        'jud',
        'oficina',
        'codigo_puesto',
        'nivel_salarial',
        'codigo_universo',
        'puesto',
        'desc_puesto',
        'codigo_situacion_empleado',
        'folio',
        'oficio_dictaminacion',
        'last_modified',
        'activo',
    ];

    public function plaza()
    {
        return $this->belongsTo(Empleado::class, 'plaza_id', 'plaza_id');
    }
}
