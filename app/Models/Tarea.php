<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Tarea extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'tarea_id';
    protected $fillable = [
        'nombre', 
        'identificador', 
        'descripcion', 
        'proceso_id', 
        'role_id'
    ];

    public function proceso()
    {
        return $this->belongsTo('App\Models\Proceso', 'proceso_id');
    }
    
    public function instancias()
    {
        return $this->belongsToMany('App\Models\Instancia', 'instancia_tarea', 'tarea_id', 'instancia_id')
            ->withPivot('ultima_modificacion_por', 'creado_por_usuario', 'asignado_al_usuario', 'creado_por_area', 'asignado_al_area', 'estatus');
    }

    public function areas()
    {
        return $this->belongsToMany('App\Models\Area', 'area_tarea', 'tarea_id', 'area_id');
    }

    public function syncAreas(array $areasIds)
    {
        return $this->areas()->sync($areasIds);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_tarea', 'tarea_id', 'role_id');
    }

    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $roleId = Role::where("name", $role)->first()->id;
            $this->roles()->attach($roleId);
        } 
    }
    
}
