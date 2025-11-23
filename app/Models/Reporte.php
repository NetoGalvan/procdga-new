<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Reporte extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'reporte_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'identificador', 'descripcion', 'proceso_id'
    ];

    public function scopeActivo($query) {
        return $query->where('activo', 1);
    }

    public function roles()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'reporte_role', 'reporte_id', 'role_id');
    }

    public function syncRoles(array $roleIds)
    {
        return $this->roles()->sync($roleIds);
    }

    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $roleId = Role::where("name", $role)->first()->id;
            $this->roles()->attach($roleId);
        } 
    }

    public function proceso()
    {
        return $this->belongsTo('App\Models\Proceso', 'proceso_id');
    }

}
