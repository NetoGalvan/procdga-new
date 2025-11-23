<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class InstanciaTarea extends Model
{
    use HasFactory;

    protected $table = 'instancia_tarea';
    protected $primaryKey = 'instancia_tarea_id';
    protected $fillable = [
        "instancia_id",
        "instancia_tarea_principal_id",
        "tarea_id",
        "es_primer_tarea",
        "pertenece_al_area",
        "pertenece_unidad_administrativa",
        "pertenece_dependencia",
        "asignado_al_rol",
        "asignado_al_usuario",
        "creado_por_area",
        "creado_por_usuario",
        "autorizado_por_usuario",
        "autorizado_por_area",
        "estatus"
    ];
    protected $appends = ['ruta_tarea'];

    public function perteneceAlArea()
    {
        return $this->belongsTo(Area::class, 'pertenece_al_area');
    }

    public function asignadoAlRol()
    {
        return $this->belongsTo(Role::class, 'asignado_al_rol');
    }

    public function asignadoAlUsuario()
    {
        return $this->belongsTo(User::class, 'asignado_al_usuario');
    }

    public function creadoPorArea()
    {
        return $this->belongsTo(Area::class, 'creado_por_area');
    }

    public function creadoPorUsuario()
    {
        return $this->belongsTo(User::class, 'creado_por_usuario');
    }

    public function autorizadoPorArea()
    {
        return $this->belongsTo(Area::class, 'autorizado_por_area');
    }

    public function autorizadoPorUsuario()
    {
        return $this->belongsTo(User::class, 'autorizado_por_usuario');
    }

    public function instancia()
    {
        return $this->belongsTo(Instancia::class, 'instancia_id', 'instancia_id');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function setUsuarioAutorizador($user)
    {
        $this->autorizado_por_usuario = $user->id;
        $this->autorizado_por_area = $user->area_id;
        return $this->save();
    }

    public function updateEstatus($estatus, $motivoRechazo = null)
    {
        if (in_array($estatus, ["COMPLETADO", "CANCELADO", "RECHAZADO"])) {
            $this->autorizado_por_usuario = Auth::user()->id;
            $this->autorizado_por_area = Auth::user()->area->area_id;
            if ($estatus == "RECHAZADO") {
                $this->motivo_rechazo = $motivoRechazo;
            }
        }
        $this->estatus = $estatus;
        return $this->save();
    }

    public function getRutaTareaAttribute()
    {
        return route($this->tarea->ruta, [$this->instancia->model, $this->instancia_tarea_id]);
    }

}
