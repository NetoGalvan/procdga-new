<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class VerifyIfChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session('tipo_sesion') == "CREDENCIALIZACION" || Auth::user()->change_password || $request->route()->uri == 'change-password-first-login')
            return $next($request);
        
        return redirect()->route('change.password.first.login');
    }
}
