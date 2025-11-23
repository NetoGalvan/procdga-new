<?php

namespace App\Models\p15_asistencia;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'p15_horarios';
    protected $primaryKey = 'horario_id';
    protected $fillable = [
        'entrada',
        'salida',
        'dias',
        'es_horario_base',
        'aplica_retardos',
        'dias_festivos_son_laborales',
        'tipo_empleado',
        'tipo_asignacion',
        'activo'
    ];
    protected $appends = ['dias_formato_string', 'ruta_editar', 'ruta_detalle'];

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    function intervalos() {
        return $this->hasMany(HorarioIntervalo::class, 'horario_id')->orderBy("horario_intervalo_id");
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'p15_horarios_users', 'horario_id', 'user_id');
    }

    public function getRutaEditarAttribute()
    {       
        return route("asistencia.catalogo.horarios.edit", $this);
    }
    
    public function getRutaDetalleAttribute()
    {       
        return route("asistencia.catalogo.horarios.show", $this);
    }
    
    public function getDiasFormatoStringAttribute()
    {       
        $arrayDias = ["DOMINGO", "LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO"];
        $diasHorario = [];
        foreach (str_split($this->dias) as $indice => $dia) {
            if ($dia) {
                $diasHorario[] = $arrayDias[$indice];
            }
        }
        return $diasHorario;
    }
}
