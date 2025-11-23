<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\p15_asistencia\Evento;

class BiometricoArchivo extends Model
{
    use HasFactory;

    protected $table = "p15_biometricos_archivos";
    protected $primaryKey = "biometrico_archivo_id";
    protected $fillable = [
        "biometrico_id",
        "fecha",
        "total_eventos",
        "eventos",
        "nombre",
        "ruta",
        "disco",
    ];

    function biometrico() {
        return $this->belongsTo(Biometrico::class, 'biometrico_id');
    }
}
