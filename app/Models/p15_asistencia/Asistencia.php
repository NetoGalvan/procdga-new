<?php

namespace App\Models\p15_asistencia;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instancia;
use App\Models\User;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'p15_asistencias';
    protected $primaryKey = 'asistencia_id';
    protected $fillable = [
        "estatus",
        "folio",
        "fecha",
        "numero_evaluacion",
    ];

    public function scopeActivo($query) 
    {
        return $query->where('activo', true);
    }

    public function instancia()
    {
        return $this->morphOne(Instancia::class, 'model');
    }
}
