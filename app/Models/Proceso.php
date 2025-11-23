<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Proceso extends Model
{
    use HasFactory;
    
    protected $table = 'procesos';
    protected $primaryKey = 'proceso_id';
    protected $fillable = [
        'nombre', 'descripcion'
    ];

    public function scopeActivo($query) {
        return $query->where('activo', 1);
    }
    
    public function tareas() {
        return $this->hasMany('App\Models\Tarea', 'proceso_id' , 'proceso_id');
    }

    public function catalogos() {
        return $this->hasMany('App\Models\Catalogo', 'proceso_id' , 'proceso_id');
    }

    public function roles()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'proceso_role', 'proceso_id', 'role_id');
    }

    public function syncRoles(array $roleIds)
    {
        return $this->roles()->sync($roleIds);
    }

    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $roleName = $role["name"] ?? $role;
            $roleId = Role::where("name", $roleName)->first()->id;
            $this->roles()->attach($roleId, ['inicializa_proceso' => $role["inicializa_proceso"] ?? false]);
        } 
    }

    public function areasProceso() {
        return $this->hasMany('App\Models\p16_pago_tiempo_extraordinario_excedente', 'proceso_id');
    }
}
