<?php

namespace App\Http\Controllers\p31_viatinet;

use App\Http\Controllers\Controller;
use App\Http\Traits\RegistroInstancias;
use App\Models\Documento;
use App\Models\EntidadFederativa;
use App\Models\Municipio;
use App\Models\p31_viatinet\Comisionado;
use App\Models\p31_viatinet\SolicitudViatico;
use App\Models\p31_viatinet\TipoPartida;
use App\Models\Pais;
use App\Models\Proceso;
use App\Models\TipoAmbito;
use App\Models\TipoDocumento;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\InstanciaTarea;

class SolicitudViaticoController extends Controller
{
    use RegistroInstancias;
    use ManejadorTareas;

    public function descripcion() {
        return view("p31_viatinet.tareas.descripcion");
    }

    public function inicializarProceso() {
        $solicitudViatico =  SolicitudViatico::create([
            "estatus" => "EN_PROCESO",
            "area_id" => Auth::user()->area->area_id
        ]);
        $instancia = $this->crearInstancia("viatinet", $solicitudViatico, Auth::user()->area);
        $instanciaTarea = $instancia->crearInstanciaTarea('T01', 'NUEVO');
        return redirect()->route('viatinet.solicitud.viatico', [$solicitudViatico, $instanciaTarea])
            ->with("success", "El proceso se creó correctamente.");
    }

    public function solicitudViatico(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            // Guardar T01 - solcitud de viático
            if ($this->guardarTareaT01($solicitudViatico, $request)) {
                // Actualizar estatus de TO1
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la siguiente tarea
                $instanciaTarea = $instancia->crearInstanciaTarea("T02", 'NUEVO');
                return redirect()->route("viatinet.agregar.comisionados", [$solicitudViatico, $instanciaTarea])
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $tiposAmbitos = TipoAmbito::activo()->get();
        $paises = Pais::activo()->get();
        $entidadesFederativas = EntidadFederativa::activo()->get();
        $tiposDocumentos = TipoDocumento::activo()->grupo("viatinet_solicitud")->get();
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T01_solicitudViatico', compact(
            'instanciaTarea',
            'solicitudViatico',
            'tiposDocumentos',
            'tiposAmbitos',
            'paises',
            'entidadesFederativas',
            'documentosSolicitud'
        ));
    }

    public function agregarComisionados(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instanciaTarea = $instancia->crearInstanciaTarea("T03", 'NUEVO');
            return redirect()->route("viatinet.consultar.terminos", [$solicitudViatico, $instanciaTarea])->with("success", "La tarea finalizó correctamente.");
        }
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T02_agregarComisionados', compact(
            'instanciaTarea',
            'solicitudViatico',
            'documentosSolicitud'
        ));
    }

    public function consultarTerminos(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea("T04", 'NUEVO');
            return redirect()->route("tareas")->with("success", "La tarea finalizó correctamente.");
        }
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T03_terminos_condiciones', compact(
            'instanciaTarea',
            'solicitudViatico',
            'documentosSolicitud'
        ));
    }

    public function validarSolicitudTitularOrgano(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea("T05", 'NUEVO');
            return redirect()->route("tareas")->with("success", "La tarea finalizó correctamente.");
        }
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T04_validar_solicitud_organo', compact(
            'instanciaTarea',
            'solicitudViatico',
            'documentosSolicitud'
        ));
    }

    public function validarSolicitudTitularSAF(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea("T06", 'NUEVO');
            return redirect()->route("tareas")->with("success", "La tarea finalizó correctamente.");
        }
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T05_validar_solicitud_saf', compact(
            'instanciaTarea',
            'solicitudViatico',
            'documentosSolicitud'
        ));
    }

    public function autorizarSolicitud(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            if ($request->select_respuesta == "autorizar") { 
                $this->guardarTareaT06($solicitudViatico, $request);
                $instanciaTarea->updateEstatus("COMPLETADO");
                $solicitudViatico->updateEstatus("COMPLETADO");
            } else {
                $instanciaTarea->estatus = "RECHAZADO";
                $instanciaTarea->motivo_rechazo = $request->motivo_rechazo;
                $instanciaTarea->save();
                $solicitudViatico->estatus = "RECHAZADO";
                $solicitudViatico->motivo_rechazo = $request->motivo_rechazo;
                $solicitudViatico->save();
            }
            $instancia->crearInstanciaTarea("T07", 'NUEVO');
            return redirect()->route("tareas")->with("success", "La tarea finalizó correctamente.");
        }
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T06_autorizar_solicitud', compact(
            'instanciaTarea',
            'solicitudViatico',
            'documentosSolicitud'
        ));
    }

    public function comprobarGastos(Request $request, SolicitudViatico $solicitudViatico, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitudViatico->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus("COMPLETADO");
            return redirect()->route("tareas")->with("success", "El proceso finalizó correctamente.");;
        }
        $documentosSolicitud = $solicitudViatico->documentos()
            ->whereHas("tipoDocumento", function($query) {
                $query->where("nombre_grupo", "viatinet_solicitud");
            })
            ->with("tipoDocumento")
            ->get();
        return view('p31_viatinet.tareas.T07_comprobacion_gastos', compact(
            'instanciaTarea',
            'solicitudViatico',
            'documentosSolicitud'
        ));
    }

    public function guardarDocumentos(Request $request, SolicitudViatico $solicitudViatico) {
        $tipoDocumento = TipoDocumento::find($request->tipo_documento_id);
        $nombreOriginalDocumento = $request->file("file")->getClientOriginalName();
        $nombreDocumento = createSlug(pathinfo($nombreOriginalDocumento, PATHINFO_FILENAME)) . ".pdf";
        $carpeta = "documentos/{$solicitudViatico->folio}";
        $ruta = Storage::putFileAs($carpeta, $request->file("file"), $nombreDocumento);

        // Comprobar si ya existe el documento
        if ($solicitudViatico
            ->documentos()
            ->where("nombre", $nombreDocumento)
            ->exists()) {
            return response()->json([
                "estatus" => false,
                "mensaje" => "Ya existe el documento, intente con otro."
            ]);
        }

        $documento = new Documento();
        $documento->nombre_original = $nombreOriginalDocumento;
        $documento->nombre = $nombreDocumento;
        $documento->disco = "local";
        $documento->ruta = $ruta;
        $documento->fecha_subida = Carbon::now();
        $documento->tipo_documento_id = $tipoDocumento->tipo_documento_id;
        $documento->model()->associate($solicitudViatico);
        $documento->save();

        $documento->tipoDocumento;
        return response()->json([
            "estatus" => true,
            "documento" => $documento
        ]);
    }

    public function guardarComisionados(Request $request, SolicitudViatico $solicitudViatico) {
        try {
            DB::beginTransaction();

            $empleado = json_decode($request->datos_empleado);

            $comisionado = new Comisionado();
            $comisionado->solicitud_viatico_id = $solicitudViatico->solicitud_viatico_id;
            $comisionado->numero_empleado = $empleado->numero_empleado;
            $comisionado->rfc = $empleado->rfc;
            $comisionado->nombre = $empleado->nombre;
            $comisionado->apellido_paterno = $empleado->apellido_paterno;
            $comisionado->apellido_materno = $empleado->apellido_materno;
            $comisionado->puesto = $empleado->puesto;
            $comisionado->nivel_salarial = $empleado->nivel_salarial;
            $comisionado->save();

            $tipoAmbito = $solicitudViatico->lugarZonaTarifaria->tipoZonaTarifaria->tipoAmbito;
            // Comprobar si están activados los viáticos terrestres
            if ($request->has('viaticos_terrestres')) {
                $tipoPartida = TipoPartida::activo()
                    ->where("tipo_ambito_id", $tipoAmbito->tipo_ambito_id)
                    ->where(function($query) {
                        $query->where("identificador", "pasajes_terrestres_nacionales")
                            ->orWhere("identificador", "pasajes_terrestres_internacionales");
                    })->first();
                $comisionado->tiposPartidas()->attach([
                    $tipoPartida->tipo_partida_id => [
                        "importe" => $request->importe_terrestres
                    ]
                ]);
            }
            // Comprobar si están activados los viáticos aereos
            if ($request->has('viaticos_aereos')) {
                $tipoPartida = TipoPartida::activo()
                    ->where("tipo_ambito_id", $tipoAmbito->tipo_ambito_id)
                    ->where(function($query) {
                        $query->where("identificador", "pasajes_aereos_nacionales")
                            ->orWhere("identificador", "pasajes_aereos_internacionales");
                    })->first();
                $comisionado->tiposPartidas()->attach([
                    $tipoPartida->tipo_partida_id => [
                        "importe" => $request->importe_aereos
                    ]
                ]);
            }
            // Comprobar si están activados los viáticos integrales
            if ($request->has('viaticos_integrales')) {
                $tipoPartida = TipoPartida::activo()
                    ->where("identificador", "servicios_integrales")
                    ->first();
                $comisionado->tiposPartidas()->attach([
                    $tipoPartida->tipo_partida_id => [
                        "importe" => $request->importe_integrales
                    ]
                ]);
            }

            DB::commit();

            $comisionado->tiposPartidas;
            return response()->json([
                "estatus" => true,
                "comisionado" => $comisionado
            ]);

        } catch (Exception $e) {
            dd($e);
            DB::rollback();

            return response()->json([
                "estatus" => false,
                "mensaje" => "Ocurrió un error, intentar más tarde."
            ]);
        }
    }

    public function eliminarComisionados(Request $request, SolicitudViatico $solicitudViatico) {
        $comisionado = Comisionado::find($request->comisionadoId);
        $comisionado->tiposPartidas()->sync([]);
        $comisionado->delete();

        return response()->json([
            "estatus" => true
        ]);

    }

    public function getMunicipios(Request $request) {
        $municipios = Municipio::activo()
            ->where("entidad_federativa_id", $request->entidadFederativaId)
            ->orderBy("nombre")
            ->get();

        return response()->json($municipios);
    }
}
