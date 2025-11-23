<?php

namespace App\Http\Controllers\p06_servicio_social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\p06_servicio_social\ManejadorTareas;
use App\Http\Controllers\p06_servicio_social\ValidacionFormularios;

use App\Models\InstanciaTarea;
use App\Models\p06_servicio_social\P06DetalleArchivos;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Prestador;
use App\Models\p06_servicio_social\P06Detalle;
use App\Models\p06_servicio_social\P06Instituciones;
use App\Models\p06_servicio_social\P06AreasAdscripcion;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControlNotificacionesController extends Controller
{
    public function citaEntrevista(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia = $servicioSocial->instancia;

        // Actualizar estatus a LEIDO  de TANOTA01
        //if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        //}

        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO de TANOTA01
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Se ha eliminado la notificación';
            return redirect()->route('notificaciones')->with('mensaje', $mensaje);
        }

        return view('p06_servicio_social.Notificaciones.TANOTA01_notificacionCitaExamenCandidato', compact('servicioSocial', 'instanciaTarea'));
    }

    public function tiempoFaltanteCartaInicio(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia = $servicioSocial->instancia;

        $fecha_cadena = Carbon::parse($servicioSocial->fecha_inicio);
        $fecha_para_contador = $servicioSocial->fecha_inicio;

        //if ($servicioSocial->fecha_carta_inicio != null) {
            // Actualizar estatus a LEIDO
            //if (!Auth::user()->hasRole("SUPER_ADMIN")) {
                $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
            //}
        //}

        if ( $servicioSocial->fecha_inicio_monitoreo < $servicioSocial->fecha_inicio ) {
            $dentroDelTiempo = true;
        } else {
            $dentroDelTiempo = false;
        }


        $meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio",
            "08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");

        $cadenaFecha= $fecha_cadena->format('d') . ' de ' . $meses[$fecha_cadena->format('m')] . ' de ' . $fecha_cadena->format('Y');

        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Se ha eliminado la notificación';
            return redirect()->route('notificaciones')->with('mensaje', $mensaje);
        }

        return view('p06_servicio_social.Notificaciones.TANOTA06_monitoreoCartaInicio', compact('servicioSocial', 'instanciaTarea', 'cadenaFecha', 'fecha_para_contador', 'dentroDelTiempo'));
    }


    public function cartaAceptacion(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia = $servicioSocial->instancia;
        // Actualizar estatus a LEIDO  de TANOTA02
        //if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        //}

        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO de TANOTA02
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Se ha eliminado la notificación';
            return redirect()->route('notificaciones')->with('mensaje', $mensaje);
        }

        return view('p06_servicio_social.Notificaciones.TANOTA02_notificacionCartaInicio', compact('servicioSocial', 'instanciaTarea'));
    }

    public function cartaTermino(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia = $servicioSocial->instancia;
        // Actualizar estatus a LEIDO  de TANOTA03
        //if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        //}

        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO de TANOTA03
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Se ha eliminado la notificación';
            return redirect()->route('notificaciones')->with('mensaje', $mensaje);
        }

        return view('p06_servicio_social.Notificaciones.TANOTA03_notificacionCartaTermino', compact('servicioSocial', 'instanciaTarea'));
    }

    public function bajaDelCandidato(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia = $servicioSocial->instancia;

        // Actualizar estatus a LEIDO  de TANOTA04
        //if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        //}

        $motivo = $servicioSocial->prestador->estatus_prestador;
        $cadenaConvert = str_replace("_", " ", $motivo);

        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO de TANOTA04
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Se ha eliminado la notificación y se ha finalizado el proceso.';
            return redirect()->route('notificaciones')->with('mensaje', $mensaje);
        }

        return view('p06_servicio_social.Notificaciones.TANOTA04_notificacionBajaCandidato', compact('servicioSocial', 'instanciaTarea', 'cadenaConvert'));
    }

    public function nuevoSeguimiento(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea)
    {
        $instancia = $servicioSocial->instancia;

        $getSeguimientos = P06Detalle::select('*')
        ->where('servicio_social_id', $servicioSocial->servicio_social_id)
        ->orderBy('detalle_id')
        ->get();

        foreach ($getSeguimientos as $key => $value) {
        $cadenaConvert = mb_strtoupper(str_replace("_", " ", $value->informe));

        $value->informe_mayus = $cadenaConvert;
        }

        // Actualizar estatus a LEIDO
        //if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        //}

        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Se ha eliminado la notificación';
            return redirect()->route('notificaciones')->with('mensaje', $mensaje);
        }

        return view('p06_servicio_social.Notificaciones.TANOTA05_notificacionNuevoSeguimiento', compact('servicioSocial', 'instanciaTarea', 'getSeguimientos'));
    }
}
