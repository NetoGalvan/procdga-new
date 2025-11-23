<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        foreach($roles as $role) {        
            $role['ruta_editar'] = route("roles.edit", $role);
        }
        return view('administrador.roles.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        return view('administrador.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        return redirect()
            ->back()
            ->with('mensaje', 'El rol se ha actualizado correctamente');
    }    
}
