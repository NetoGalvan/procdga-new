<?php

namespace App\Http\Controllers\p02_tramites_issste;

use App\Exports\p02_tramites_issste\DetallesArchivoIsssteExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EntidadFederativa;
use App\Models\InstanciaTarea;
use App\Models\p01_movimientos_personal\MovimientoPersonal;
use App\Models\p02_tramites_issste\TipoMovimientoIssste;
use App\Models\p02_tramites_issste\TramiteIssste;
use App\Models\p02_tramites_issste\TipoNombramiento;
use App\Models\p02_tramites_issste\TramiteIsssteDetalle;
use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TramitesIsssteController extends Controller
{
    use ManejadorTareas;

    /**
     * Muestra la descripción del proceso Trámites Issste
     */
    public function descripcion()   {
        // En la descripción mostrar si hay folios existente para enviar
        $foliosParaEnviar = MovimientoPersonal::where('estatus_issste', 'LISTO')->get();

        return view('p02_tramites_issste.tareas.descripcion', compact('foliosParaEnviar') );
    }

    /**
     * Inicializa el proceso Trámites Issste
     * Crea la instancia, el folio del proceso, el registro de la tabla principal y la primer tarea.
     */
    public function inicializarProceso() {
        $tramiteIssste = TramiteIssste::create([
            "estatus" => "EN_PROCESO"
        ]);
        $instancia = $this->crearInstancia("tramites_issste", $tramiteIssste, Auth::user()->area);
        $instanciaTarea = $instancia->crearInstanciaTarea("T01", "NUEVO");
        // Asignar los datos que estan en la tabla de movimientos de personal con estatus 'LISTO' a la tabla de detalle del Proceso de ISSSTE
        $this->agregarDatosDeMovimientosPersonalAlProcesoTramitesIssste($tramiteIssste);
        return redirect()->route("tramites.issste.revision.folios", [$tramiteIssste, $instanciaTarea])
            ->with("success", "Se ha iniciado correctamente el proceso Tramite ISSSTE");
    }

    /*
     * T01 - Revisión de folios
    */
    public function revisarFolios(Request $request, TramiteIssste $tramiteIssste, InstanciaTarea $instanciaTarea) {
        $instancia = $tramiteIssste->instancia;
        $detallesIssste = $tramiteIssste->detalles;
        if ($request->isMethod('post')) {
            $this->guardarTareaT01($tramiteIssste, $request);
            $instanciaTarea->updateEstatus('COMPLETADO');
            $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02", "NUEVO");
            return redirect()->route('tareas')->with("success", "¡La tarea finzalizo exitosamente!");
        }
        $entidades = EntidadFederativa::orderBy('entidad_federativa_id')->get();
        $tiposNombramientos = TipoNombramiento::get();
        $tiposMovimientosIssste = TipoMovimientoIssste::get();
        return view('p02_tramites_issste.tareas.T01_revisionFolios', compact(
            "instanciaTarea",
            "tramiteIssste",
            "detallesIssste",
            "entidades",
            "tiposNombramientos",
            "tiposMovimientosIssste"
        ));
    }

    /*
     * T02 - Respuesta del ISSSTE
    */
    public function respuestaDelIssste(Request $request, TramiteIssste $tramiteIssste, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIssste->instancia;
        $detallesIssste = $tramiteIssste->detalles;
        if ($request->isMethod('post')) {
            $this->guardarTareaT02($tramiteIssste, $request);
            $instanciaTarea->updateEstatus('COMPLETADO');
            // Si algún Folio fue Rechazado se crea la T03, Si No, Se Finaliza aquí el Proceso
            // Crear T03 - Corrección de folios rechazados por el ISSSTE
            $foliosRechazados = $tramiteIssste->detallesRechazados;
            // Si hubo uno o más expediente(s) rechazado(s) de los folios se crea la T03 - Corrección de folios rechazados por el ISSSTE
            if ( count($foliosRechazados) > 0 ) {
                $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("TR03", "NUEVO");
            } else {
                $tramiteIssste->update(['estatus' => 'COMPLETADO']);
            }
            return redirect()->route('tareas')->with("success", "¡La tarea finzalizo exitosamente!");
        }

        return view('p02_tramites_issste.tareas.T02_respuestaIssste', compact(
            "instanciaTarea",
            "tramiteIssste",
            "detallesIssste" 
        ));
    }

    /**
     * TR03 - Corrección de folios rechazados por el ISSSTE
    */
    public function corregirFoliosRechazadosPorIssste(Request $request, TramiteIssste $tramiteIssste, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIssste->instancia;
        $detallesIssste = $tramiteIssste->detallesRechazados;
        if ($request->isMethod('post')) {
            $this->guardarTareaTR03($tramiteIssste, $request);
            $instanciaTarea->updateEstatus('COMPLETADO');
            $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02", "NUEVO");
            return redirect()->route('tareas')->with("success", "¡La tarea finzalizo exitosamente!");
        }
        // Datos que se usan en la vista
        $entidades = EntidadFederativa::select('entidad_federativa_id', 'nombre')->orderBy('entidad_federativa_id')->get();
        $tiposNombramientos = TipoNombramiento::get();
        $tiposMovimientosIssste = TipoMovimientoIssste::get();
        return view('p02_tramites_issste.tareas.TR03_correccionFolioRechazadosPorIssste', compact(
            "instanciaTarea",
            "tramiteIssste", 
            "detallesIssste",
            "entidades", 
            "tiposNombramientos",
            "tiposMovimientosIssste"
        ));
    }

    // TR03 - Guarda Avance en la Corrección de folios via Ajax
    public function guardarAvanceEnCorreccionDeFolios(Request $request, TramiteIssste $tramiteIssste, InstanciaTarea $instanciaTarea) {

        $detallesIssste = $tramiteIssste->detallesRechazados;

        DB::beginTransaction();
        try {

            foreach( $detallesIssste as $key => $detalle ) {

                // Obtener tipo de movimiento Issste
                $tipoMovientoIssste = TipoMovimientoIssste::where( 'tipo_movimiento_issste_id', $request->tipo_movimiento_issste[$key] )->first();
                // Obtener la Entidad Federativa
                $entidadFederativa = EntidadFederativa::where( 'entidad_federativa_id', $request->entidad_id[$key] )->first();
                // Obtener Tipo de Nombramiento
                $tipoNombramiento = TipoNombramiento::where( 'tipo_nombramiento_id', $request->tipo_nombramiento_id[$key] )->first();

                $detalle->update([
                                // Datos Generales
                                'qna_issste' => $request->qna_issste,
                                'tipo_movimiento_issste_id' => $tipoMovientoIssste ? $tipoMovientoIssste->tipo_movimiento_issste_id : null,
                                'listo' => $request->listo[$key] == "LISTO" ? true : false ,
                                // Dirección del Empleado
                                'cp' => $request->cp[$key],
                                'colonia' => $request->colonia[$key],
                                'ciudad' => $request->ciudad[$key],
                                'municipio_alcaldia' => $request->municipio_alcaldia[$key],
                                'entidad_federativa_domicilio_id' => $entidadFederativa ? $entidadFederativa->entidad_federativa_id : null,
                                'calle' => $request->calle[$key],
                                'numero_exterior' => $request->numero_exterior[$key],
                                'numero_interior' => $request->numero_interior[$key],
                                // Datos Salariales
                                'clave_cobro' => $request->clave_cobro[$key],
                                'clave_ramo' => $request->clave_ramo[$key],
                                'pagaduria' => $request->pagaduria[$key],
                                'sueldo_cotizable' => $request->sueldo_cotizable[$key],
                                'sueldo_sar' => $request->sueldo_sar[$key],
                                'sueldo_total' => $request->sueldo_total[$key],
                                'tipo_nombramiento_id' => $tipoNombramiento ? $tipoNombramiento->tipo_nombramiento_id : null,
                            ]);

            }
        DB::commit();

        return response()->json([ 'estatus' => true, 'mensaje' => '¡Los cambios se guardaron exitosamente!', 'code' => 200]);

        } catch (\Throwable $th) {

            DB::rollback();
            return response()->json([ 'estatus' => false, 'mensaje' => '¡Los cambios no se guardaron, intente más tarde!', 'code' => 200]);

        }

    }

    // T01 - Guarda Avance en la Revisión de folios via Ajax
    public function guardarAvanceEnrevisarFolios(Request $request, TramiteIssste $tramiteIssste, InstanciaTarea $instanciaTarea) {
        DB::beginTransaction();
        try {
            $tramiteIssste->quincena = $request->qna_issste;
            $tramiteIssste->save();

            foreach($request->movimientos as $movimiento) {
                $detalle = TramiteIsssteDetalle::find($movimiento["detalle_id"]);
                $detalle->update([
                    // Datos Generales
                    'qna_issste' => $request->qna_issste,
                    'tipo_movimiento_issste_id' => $movimiento["tipo_movimiento_issste_id"],
                    // Dirección del Empleado
                    'cp' => $movimiento["cp"],
                    'colonia' => $movimiento["colonia"],
                    'ciudad' => $movimiento["ciudad"],
                    'municipio_alcaldia' => $movimiento["municipio_alcaldia"],
                    'entidad_federativa_domicilio_id' => $movimiento["entidad_federativa_domicilio_id"],
                    'calle' => $movimiento["calle"],
                    'numero_exterior' => $movimiento["numero_exterior"],
                    'numero_interior' => $movimiento["numero_interior"],
                    // Datos Salariales
                    'clave_cobro' => $movimiento["clave_cobro"],
                    'clave_ramo' => $movimiento["clave_ramo"],
                    /* 'pagaduria' => $movimiento["pagaduria"], */
                    'sueldo_cotizable' => $movimiento["sueldo_cotizable"],
                    'sueldo_sar' => $movimiento["sueldo_sar"],
                    'sueldo_total' => $movimiento["sueldo_total"],
                    'tipo_nombramiento_id' => $movimiento["tipo_nombramiento_id"],
                ]);
            }
        DB::commit();

        return response()->json([ 'estatus' => true, 'mensaje' => '¡Los avances se guardaron exitosamente!', 'code' => 200]);

        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return response()->json([ 'estatus' => false, 'mensaje' => '¡Los avances no se guardaron, intente más tarde!', 'code' => 200]);

        }

    }

    // Método para mostrar los Archivos de Excel para mandar al ISSSTE
    public function archivosParaIssste() {
        $usuario = Auth::user();

        // Se obtienen los Tramites de Issste que estan en estatus 'LISTO'
        $tramitesIssste = TramiteIssste::select( 'p02_tramites_issste.tramite_issste_id')
        ->with('instancia')
        ->join( 'p02_detalles', 'p02_tramites_issste.tramite_issste_id', '=', 'p02_detalles.tramite_issste_id' )
        ->where('p02_detalles.estatus_issste', 'LISTO')
        ->orderBy('p02_tramites_issste.tramite_issste_id', 'desc')
        ->groupBy('p02_tramites_issste.tramite_issste_id')
        ->get();

        $tramitesIsssteSeparados = [];
        // Se recorren para verificar si tienen detalles de alta o baja
        foreach ($tramitesIssste as $key => $tramite) {

            if ( count($tramite->detallesAlta) > 0 ) {
                $tramite->setAttribute('tipo_movimiento_issste_id', $tramite->detallesAlta[0]->tipo_movimiento_issste_id);
                $tramite->setAttribute('tipo_movimiento_issste', $tramite->detallesAlta[0]->nombre);
                $tramite->setAttribute('qna_issste', $tramite->detallesAlta[0]->qna_issste);
                $tramite->setAttribute('registros', count($tramite->detallesAlta));
                $tramite->setAttribute('instancia_id', $tramite->instancia->instancia_id);
                $tramite->setAttribute('folio', $tramite->instancia->folio);
                $tramitesIsssteSeparados[] = $tramite->getAttributes();
            }
            if ( count($tramite->detallesBaja) > 0 ) {
                $tramite->setAttribute('tipo_movimiento_issste_id', $tramite->detallesBaja[0]->tipo_movimiento_issste_id);
                $tramite->setAttribute('tipo_movimiento_issste', $tramite->detallesBaja[0]->nombre);
                $tramite->setAttribute('qna_issste', $tramite->detallesBaja[0]->qna_issste);
                $tramite->setAttribute('registros', count($tramite->detallesBaja));
                $tramite->setAttribute('instancia_id', $tramite->instancia->instancia_id);
                $tramite->setAttribute('folio', $tramite->instancia->folio);
                $tramitesIsssteSeparados[] = $tramite->getAttributes();
            }
            if ( count($tramite->detallesModificacion) > 0 ) {
                $tramite->setAttribute('tipo_movimiento_issste_id', $tramite->detallesModificacion[0]->tipo_movimiento_issste_id);
                $tramite->setAttribute('tipo_movimiento_issste', $tramite->detallesModificacion[0]->nombre);
                $tramite->setAttribute('qna_issste', $tramite->detallesModificacion[0]->qna_issste);
                $tramite->setAttribute('registros', count($tramite->detallesModificacion));
                $tramite->setAttribute('instancia_id', $tramite->instancia->instancia_id);
                $tramite->setAttribute('folio', $tramite->instancia->folio);
                $tramitesIsssteSeparados[] = $tramite->getAttributes();
            }
        }

        return view('p02_tramites_issste.archivos_issste.archivos_issste', compact('tramitesIsssteSeparados', 'usuario'));
    }

    // Método encargado de descargar el Excel para enviar el ISSSTE
    public function descargarArchivosParaIssste (Request $request, TramiteIssste $tramiteIssste, TipoMovimientoIssste $tipoMovimientoIssste) {

        // Se usa la librería para Exportar los datos de la tabla que queremos, utiliza una representación del modelo de TramiteIsssteDetalle para generar el Archivo
        return Excel::download(new DetallesArchivoIsssteExport($tramiteIssste, $tipoMovimientoIssste), 'archivo_issste_'.$tramiteIssste->instancia_id.'_'.strtolower($tipoMovimientoIssste->identificador).'.xlsx');

    }

}
