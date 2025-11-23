<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginCredencializacionController extends Controller
{
    // Este metodo envía "cliente_id" y "redirect_uri" para verificar que se tenga la Autorización de la App Servidor (Credencialización) y regresar respuesta, el login.
    // Debe haber sido previamente registrada por la App Servidor y esta debe proporcionar ese id y uri a la App Cliente (PROCDGA)
    public function login(Request $request) {
        $request->session()->put("state", $state = Str::random(40)); // El random state bloquea ataques CSRF
        $query = http_build_query([
            "client_id"     => config("services.credencializacion.client_id"),
            "redirect_uri"  => route("credencializacion.callback"),
            "response_type" => "code",
            "scope"         => "",
            "state"         => $state,
        ]);
        return redirect(config("services.credencializacion.url_authorize") . "?$query");
    }

    // Si la App Servidor (Credencialización) Autoriza devuelve un code a la App Cliente (PROCDGA).
    // Con este code se hace una segunda petición con "client_id", "client_secret", "redirect_uri" (Otorgados prviamnete por la App Servidor) y "code" respuesta.
    // Si es exitosa devuelve el "access_token" y "refresh_token", estos permitiran acceder a los servicios y datos que la App Servidor exponga
    public function callback(Request $request) {
        $state = $request->session()->pull('state', '');
        throw_unless(strlen($state) > 0 && $state == $request->state, InvalidArgumentException::class);
        $response = Http::asForm()->post(config("services.credencializacion.url_token"), [
            "grant_type"    => "authorization_code",
            "client_id"     => config("services.credencializacion.client_id"),
            "client_secret" => config("services.credencializacion.client_secret"),
            "redirect_uri"  => route("credencializacion.callback"),
            "code"          => $request->code,
        ]);
        $request->session()->put($response->json());
        return redirect(route("credencializacion.getUser"));
        // return $response->json();
    }

    // Este método hace la petición para obtener los datos de usuario logueado de App Servidor (Credencialización)
    public function getUser(Request $request) {
        // Obtenemos el access_token
        $access_token = $request->session()->get("access_token");
        // Lanzamo la petición
        $response = Http::withHeaders([
            "Accept"        => "application/json",
            "Authorization" => "Bearer " . $access_token
        ])->get(config("services.credencializacion.url_user"));

        // Obtenemos al usuario devuelto por la App Servidor (Credencialización)
        $userCredencializacion = (object) $response->json();

        // Validamos si el Usuario devuelto ya existe en la BD de la App Cliente (PROCDGA).
        $user = User::where([
            "rfc" => $userCredencializacion->rfc,
            "curp" => $userCredencializacion->curp,
        ])->first();

        // Si no existe el usuario en el PROCDGA lo creamos
        if (!$user) {
            $mensaje = "El empleado con el RFC: <strong>{$userCredencializacion->rfc}</strong> no está habilitado para usar el sistema <strong>PROCDGA</strong>. Comuníquese con el administrador.";
            return redirect('/login')->withErrors(["user_no_habilitado" => $mensaje]);
        }
        // Si existe se loguea en el PROCDGA
        Auth::login($user);
        session(['tipo_sesion' => 'CREDENCIALIZACION']);
        return redirect()->route('tareas');
    }
}
