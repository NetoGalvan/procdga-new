<?php

namespace App\Http\Controllers\p14_historial_kardex;

use App\Http\Controllers\Controller;
use App\Http\Traits\RegistroInstancias;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\p12_tramites_incidencias\P1214EmpleadoKardexDetalle;
use App\Models\p12_tramites_incidencias\P1214EmpleadoKardex;
use App\Models\p12_tramites_incidencias\P14HistorialKardex;
use App\Models\p12_tramites_incidencias\TramiteIncidencia;
use App\Models\Instancia;
use App\Models\Proceso;
use App\Models\InstanciaTarea;
use Illuminate\Http\Request;

class HistorialKardexController extends Controller{

    use ManejadorTareas;
    //Método que muestra la descripcion del P14
    public function descripcion()   {
        return view('p14_historial_kardex.tareas.descripcion');
    }
    //Inicializamos la instancia, así como el modelo y la tarea, para posteriormente redirigir a la página de búsqueda de historial
    public function inicializarProceso(){
        //Creamos el historial
        $historialKardex= $this->crearHistorialKardex();
        //creamos la instancia
        $instancia = $this->crearInstanciaCapturaKardex($historialKardex);
        //creamos la tarea T01 y la finalizamos
        $instanciaTarea = $this->crearTarea($instancia, 'T01', 'COMPLETADO');
        // Crear folio del proceso
        //cambia rpara evitar tanta herencia
        $folio= $this->crearFolioProceso($instancia, $instanciaTarea);
        //almacenamos el folio en p14_historial_kardex
        $historialKardex->folio = $folio;
        $historialKardex->save();
        //almacenamos el folio en la instancia
        $instancia->folio = $folio;
        $instancia->save();
        //por último creamos la tarea T02 de busqueda de historial
        $instanciaTarea = $this->crearTarea($instancia, 'T02', 'NUEVO');
        //los redirigimos a la ruta que muestra el formulario de busqueda (T02)
        return redirect()->route('historial.kardex.t02',compact('historialKardex'));
    }

    public function vistaBusquedaHistorial(P14HistorialKardex $historialKardex){
        return view('p14_historial_kardex.tareas.T01_busquedaHistorial',['folio'=>$historialKardex->folio]);
    }


}
