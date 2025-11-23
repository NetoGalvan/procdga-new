<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Log;
use App\Models\User;
use App\Notifications\Administrador\Usuarios\CuentaCreada;
use App\Rules\Lowercase;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('administrador.usuarios.index');
    }

    public function create()
    {
        $areas = Area::activo()->orderByRaw('identificador::FLOAT')->get();
        $roles = Role::orderBy("name")->get();
        return view('administrador.usuarios.create', compact("areas", "roles"));
    }

    public function store(Request $request)
    {
        if ($request->tipo_registro == "EXISTENTE") {
            $datosEmpleado = json_decode($request->datos_empleado);
            if (User::where([
                    "numero_empleado" => $datosEmpleado->numero_empleado,
                    "rfc" => $datosEmpleado->rfc
                ])->doesntExist()) {
                $request->merge(["empleado_id" => $datosEmpleado->empleado_id]);
                $request->merge(["nombre" => $datosEmpleado->nombre]);
                $request->merge(["apellido_paterno" => $datosEmpleado->apellido_paterno]);
                $request->merge(["apellido_materno" => $datosEmpleado->apellido_materno]);
                $request->merge(["rfc" => $datosEmpleado->rfc]);
                $request->merge(["curp" => $datosEmpleado->curp]);
                $request->merge(["numero_empleado" => $datosEmpleado->numero_empleado]);
                $request->merge(["email" => $request->email_creden]);
                $request->merge(["nombre_usuario" => $datosEmpleado->rfc]);
                $request->merge(["puesto" => $datosEmpleado->puesto]);
            } else {
                $mensaje = "¡Ya existe un usuario para este empleado!";
                return redirect()
                    ->back()
                    ->with("error", $mensaje);
            }
        } else {
            $request->merge(["nombre_usuario" => $request->rfc]);
        }
            $password = Str::random(8);
            $request->merge(["password" => Hash::make($password)]);
            $this->validator($request->all())->validate();
            $usuario = User::create($request->all());
            $usuario->syncRoles($request->get('roles'));
            Notification::route("mail", $usuario->email)->notify(new CuentaCreada($request->tipo_registro, $usuario, $password));
        return redirect()
            ->route('usuarios.edit', $usuario)
            ->with('mensaje', 'Usuario creado correctamente');
    }

    public function edit(User $usuario)
    {
        $areas = Area::activo()->orderByRaw('identificador::FLOAT')->get();
        $roles = Role::orderBy("name")->get();
        return view('administrador.usuarios.edit', compact('usuario', 'areas', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->merge(["activo" => $request->has("activo")]);
        $request->merge(["nombre_usuario" => $request->rfc]);
        $this->validator($request->all(), $usuario)->validate();
        $usuario->update($request->all());
        $usuario->syncRoles($request->get('roles'));
        return redirect()
            ->route('usuarios.edit', $usuario)
            ->with('mensaje', 'Usuario actualizado correctamente');
    }

    protected function validator(array $data, $usuario = null)
    {
        $messages = [
            'curp.unique' => 'La CURP ya está registrada',
            'rfc.unique' => 'El RFC ya está registrado',
            'email.unique' => 'El correo ya está registrado',
        ];

        $rulesGenerales =  [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:30'],
            'area_id' =>  ['required', 'integer'],
        ];

        $rulesEmail = ['required', 'string', 'email', 'max:255', new Lowercase($usuario)];
        $rulesRfc =  ['required', 'string', 'max:30'];
        $rulesCurp =  ['required', 'string', 'max:30'];

        if (!is_null($usuario)) {
            $rulesGenerales["email"] = $rulesEmail[] = Rule::unique('users')->ignore($usuario);
            $rulesGenerales["rfc"] = $rulesRfc[] = Rule::unique('users')->ignore($usuario);
            $rulesGenerales["curp"] = $rulesCurp[] = Rule::unique('users')->ignore($usuario);
        } else {
            $rulesGenerales["email"] = $rulesEmail = 'unique:users';
            $rulesGenerales["rfc"] = $rulesRfc[] = 'unique:users';
            $rulesGenerales["curp"] = $rulesCurp[] = 'unique:users';
        }
        return Validator::make($data, $rulesGenerales, $messages);
    }

    public function getUsuarios(Request $request) {
        $usuarios = User::where(function ($query) use ($request) {
                $query->where(DB::raw("upper(concat_ws(' ', nombre, apellido_paterno, apellido_materno))"), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                    ->orWhere(DB::raw('upper("curp")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                    ->orWhere(DB::raw('upper("rfc")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                    ->orWhere(function ($query) use ($request) {
                        if (is_numeric($request->searchText)) {
                            $query->orWhere("numero_empleado", "LIKE", "%$request->searchText%");
                        }
                    })
                    ->orWhereHas("roles", function ($query) use ($request) {
                        $query->where(DB::raw('upper("name")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%');
                    });

            })
            ->with("area", "roles")
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombre')
            ->paginate($request->pageSize);

        return $usuarios;
    }
}
