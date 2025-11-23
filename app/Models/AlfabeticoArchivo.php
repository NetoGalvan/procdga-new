<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\User;

class AlfabeticoArchivo extends Model
{
    use HasFactory;

    protected $table = "alfabeticos_archivos";
    protected $primaryKey = "archivo_id";
    protected $fillable = [
        "empleados",
        "alfabetico_id",
        "nombre_archivo",
        "cantidad_empleados",
        "fecha_carga",
        'cargado_por_usuario',
        'area_id',
    ];

    function directorio() {
        return $this->belongsTo(Directorio::class, 'alfabetico_id', 'alfabetico_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function cargadoPorUsuario()
    {
        return $this->hasOne(User::class, 'id', 'cargado_por_usuario');
    }

}
