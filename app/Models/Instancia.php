<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Spatie\Permission\Models\Role;

class Instancia extends Model
{
    use HasFactory;

    protected $primaryKey = 'instancia_id';
    protected $fillable = ['proceso_id'];

    // EVENTOS
    protected static function boot()
    {
        parent::boot();

        static::created(function ($instancia) {
            // Generar el folio para este instancia.
            $idHex = dechex($instancia->instancia_id);
            $idHex = mb_strtoupper(str_pad($idHex, 10, "0", STR_PAD_LEFT));
            $folio = sprintf("%s-%d-%s", substr($idHex, 0, 5), date('Y'), substr($idHex, -5));
            $instancia->folio = $folio;
            $instancia->save();
        });
    }

    // RELACIONES

    public function model()
    {
        return $this->morphTo();
    }

    public function proceso()
    {
        return $this->belongsTo('App\Models\Proceso', 'proceso_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }

    public function tareas()
    {
        return $this->belongsToMany('App\Models\Tarea', 'instancia_tarea', 'instancia_id', 'tarea_id')
            ->withPivot(
                "instancia_tarea_id",
                "creado_por_usuario",
                "creado_por_area",
                "estatus");
    }

    public function primerInstanciaTarea()
    {
        return $this->hasOne(InstanciaTarea::class, 'instancia_id')->orderBy('instancia_tarea_id');
    }

    public function syncTareas($tarea)
    {
        return $this->tareas()->syncWithoutDetaching($tarea);
    }

    public function attachTareas($tarea)
    {
        return $this->tareas()->attach($tarea);
    }

    public function instanciasTareas()
    {
        return $this->hasMany('App\Models\InstanciaTarea', 'instancia_id');
    }

    public function subInstancias()
    {
        return $this->hasMany('App\Models\Instancia', 'instancia_padre_id', 'instancia_id');
    }

    public function instanciaPadre()
    {
        return $this->belongsTo('App\Models\Instancia', 'instancia_padre_id', 'instancia_id');
    }

    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }

    public function crearInstanciaTarea($nombreTarea, $estatus, $area = null, $role = null, $user = null, $instanciaTareaPadre = null)
    {
        $tarea = Tarea::where([
            ['identificador', '=', $nombreTarea],
            ['proceso_id', '=', $this->proceso_id]
        ])->first();

        $asignadoAlRol = is_null($role) ? $tarea->roles()->first() : Role::where("name", $role)->first();
        $perteneceAlArea = Area::find($area->area_id ?? $this->area_id);

        return InstanciaTarea::create([
            "instancia_id" => $this->instancia_id,
            "instancia_tarea_principal_id" => $instanciaTareaPadre->instancia_tarea_id ?? null,
            "tarea_id" => $tarea->tarea_id,
            "es_primer_tarea" => $this->instanciasTareas()->count() < 1,
            "pertenece_al_area" => $perteneceAlArea->area_id,
            "pertenece_unidad_administrativa" => $perteneceAlArea->unidadAdministrativa->unidad_administrativa_id,
            "pertenece_dependencia" => $perteneceAlArea->unidadAdministrativa->dependencia->dependencia_id,
            "asignado_al_rol" => $asignadoAlRol->id,
            "asignado_al_usuario" => $user->id ?? null,
            "creado_por_area" => Auth::user()->area->area_id,
            "creado_por_usuario" => Auth::user()->id,
            "estatus" =>  $estatus,
        ]);
    }
}
