<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06Instituciones extends Model
{
    use HasFactory;

    protected $table = "p06_instituciones";
    protected $primaryKey = "institucion_id";
    protected $fillable = [
        'nombre_institucion',
        'acronimo_institucion',
        'clave_institucion',
        'activo',
        'created_at',
        'updated_at'
    ];
/*
    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio'
    ];
*/
    public function escuela(){
        return $this->hasMany('App\Models\p06_servicio_social\P06Escuela', 'institucion_id');
    }

    public function instancia()
    {
        return $this->belongsTo('App\Models\Instancia', 'instancia_id');
    }

    public function programas(){
        return $this->hasMany('App\Models\p06_servicio_social\P06Programa', 'institucion_id');
    }
}
