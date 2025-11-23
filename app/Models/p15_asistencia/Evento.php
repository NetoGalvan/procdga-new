<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'p15_eventos';
    protected $primaryKey = 'evento_id';
    protected $fillable = [
        "numero_empleado",
        "fecha",
        "biometrico_id",
        "biometrico_archivo_id"
    ];

    function biometrico() {
        return $this->belongsTo(Biometrico::class, 'biometrico_id');
    }
}
