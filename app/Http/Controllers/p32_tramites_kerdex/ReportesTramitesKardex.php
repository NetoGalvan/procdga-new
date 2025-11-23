<?php

namespace App\Http\Controllers\p32_tramites_kerdex;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\p32_tramites_kardex\TipoTramiteKardex;
use App\Models\p32_tramites_kardex\TramiteKardex;
use App\Models\historico\lbpm_dga\p03_hojas_servicio\HistoricoHojaServicio;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\p32_tramites_kardex\TramitesKardexExportLocal;
use App\Exports\p32_tramites_kardex\TramitesKardexExportHistorico;
use App\Models\historico\lbpm_dga\p04_comprobantes_servicio\HistoricoComprobanteServicio;

class ReportesTramitesKardex extends Controller
{
    public function reportesTramitesKardex( Request $request ) {

        if ($request->ajax()) {

            if ($request->buscar_por == "local") {

                $infoServicioQuery = TramiteKardex::where(function ($query) use ($request) {
                                                if (!is_null($request->folio)) {
                                                    $query->where("folio", $request->folio);
                                                }
                                                if (!is_null($request->fecha_de)) {
                                                    $query->whereBetween('created_at', ["$request->fecha_de 00:00:00", "$request->fecha_a 23:59:59"]);
                                                }
                                                if (!is_null($request->estatus_local)) {
                                                    $query->where('estatus', $request->estatus_local);
                                                }
                                                if (!is_null($request->tipo_tramite)) {
                                                    $tipo = TipoTramiteKardex::where('clave', $request->tipo_tramite)->first();
                                                    $query->where('tipo_tramite_kardex_id', $tipo->tipo_tramite_kardex_id);
                                                }
                                            })
                                    ->orderBy('tramite_kardex_id', 'desc')->get();

                if (count($infoServicioQuery) >= 1) {
                    return response()->json([ "estatus" => true, "mensaje" => "Información encontrada exitosamente.", "infoServicioQuery" => $infoServicioQuery ]);
                } else {
                    return response()->json([ "estatus" => false, "mensaje" => "No hay información que coincida con nuestros registros."]);
                }

            } else {

                $database_old_connected = false;
                try {
                    DB::connection('lbpm_dga')->getPdo();
                    $database_old_connected = true;
                } catch (\Exception $e) {

                }

                if ( $database_old_connected ) {

                    if ( $request->tipo_tramite == "hojas_de_servicio") {

                        $hojasServicioHistoricoQuery = HistoricoHojaServicio::
                        where(function ($query) use ($request) {
                            if (!is_null($request->folio)) {
                                $query->where("folio_contrasena", $request->folio);
                            }
                            if (!is_null($request->fecha_de)) {
                                $query->whereHas('instancia', function ($query) use ($request) {
                                    $query->whereBetween("created_on", ["$request->fecha_de 00:00:00", "$request->fecha_a 23:59:59"]);
                                });
                            }
                            if (!is_null($request->estatus_historico)) {
                                $query->where('work_status', $request->estatus_historico);
                            }
                        })
                        ->orderBy('p03_id', 'desc')->get();

                        if (count($hojasServicioHistoricoQuery) >= 1) {
                            return response()->json([ "estatus" => true, "mensaje" => "Información encontrada exitosamente.", "infoServicioQuery" => $hojasServicioHistoricoQuery ]);
                        } else {
                            return response()->json([ "estatus" => false, "mensaje" => "No hay información que coincida con nuestros registros."]);
                        }

                    } elseif ($request->tipo_tramite == "comprobantes_de_servicio") {

                        $hojasServicioHistoricoQuery = HistoricoComprobanteServicio::
                        where(function ($query) use ($request) {
                            if (!is_null($request->folio)) {
                                $query->where("folio_contrasena", $request->folio);
                            }
                            if (!is_null($request->fecha_de)) {
                                $query->whereHas('instancia', function ($query) use ($request) {
                                    $query->whereBetween("created_on", ["$request->fecha_de 00:00:00", "$request->fecha_a 23:59:59"]);
                                });
                            }
                            if (!is_null($request->estatus_historico)) {
                                $query->where('work_status', $request->estatus_historico);
                            }
                        })
                        ->orderBy('p04_id', 'desc')->get();

                        if (count($hojasServicioHistoricoQuery) >= 1) {
                            return response()->json([ "estatus" => true, "mensaje" => "Información encontrada exitosamente.", "infoServicioQuery" => $hojasServicioHistoricoQuery ]);
                        } else {
                            return response()->json([ "estatus" => false, "mensaje" => "No hay información que coincida con nuestros registross."]);
                        }
                    } elseif ($request->tipo_tramite == null) {

                        $hojasServicioHistoricoQuery = HistoricoHojaServicio::
                        where(function ($query) use ($request) {
                            if (!is_null($request->folio)) {
                                $query->where("folio_contrasena", $request->folio);
                            }
                            if (!is_null($request->fecha_de)) {
                                $query->whereHas('instancia', function ($query) use ($request) {
                                    $query->whereBetween("created_on", ["$request->fecha_de 00:00:00", "$request->fecha_a 23:59:59"]);
                                });
                            }
                            if (!is_null($request->estatus_historico)) {
                                $query->where('work_status', $request->estatus_historico);
                            }
                        })
                        ->orderBy('p03_id', 'desc')->get();

                        $comprobantesServicioHistoricoQuery = HistoricoComprobanteServicio::
                        where(function ($query) use ($request) {
                            if (!is_null($request->folio)) {
                                $query->where("folio_contrasena", $request->folio);
                            }
                            if (!is_null($request->fecha_de)) {
                                $query->whereHas('instancia', function ($query) use ($request) {
                                    $query->whereBetween("created_on", ["$request->fecha_de 00:00:00", "$request->fecha_a 23:59:59"]);
                                });
                            }
                            if (!is_null($request->estatus_historico)) {
                                $query->where('work_status', $request->estatus_historico);
                            }
                        })
                        ->orderBy('p04_id', 'desc')->get();

                        $infoServicioQuery = $hojasServicioHistoricoQuery->concat($comprobantesServicioHistoricoQuery);

                        return response()->json([ "estatus" => true, "mensaje" => "Información encontrada exitosamente.", "infoServicioQuery" => $infoServicioQuery ]);
                    }

                } else {
                    return response()->json([ "estatus" => false, "mensaje" => 'Estamos teniendo problemas al conectar con la base de datos histórica.' ]);
                }
            }

        }

        $tipo_tramite = ["hojas_de_servicio" => "Hojas de servicio", "comprobantes_de_servicio" => "Comprobantes de servicio"];
        $estatusL = ["EN_PROCESO" => "En proceso", "COMPLETADO" => "Completado"];
        $estatusH = ["WORKING" => "En proceso", "PREMATURE_END" => "Prematuramente finalizado", "COMPLETED" => "Completado"];

        return view('p32_tramites_kardex.reportes.reporte_tramites_kardex', compact('tipo_tramite', 'estatusL', 'estatusH'));
    }

    public function descargarDetalles($folio, $tipo)  {

        $fechaCompleta = convertirFechaFormatoMX(Carbon::now());

        if ($tipo == 1 || $tipo == 2) {

            $tramiteKardex = TramiteKardex::where('folio', $folio)->with('tipoTramiteKardex')->first();

            $tramites = TramiteKardex::where('tipo_tramite_kardex_id', $tipo)
                                        ->where('folio', $folio)
                                        ->where('activo', true)
                                        ->get();
            $firmas = json_decode($tramiteKardex->firmas);

            if ($tramiteKardex->tipoTramiteKardex->clave == 'hojas_de_servicio') {

                $detallesBajas = [];
                $detallesAportaciones = [];
                foreach ($tramites as $i => $tramite) {
                    $detalles = json_decode($tramite->detalles);
                    if ( isset($detalles) ) {
                        foreach ($detalles as $key => $detalle) {
                            $detalle->folio = $tramite->folio;
                            $detalle->tipo_tramite = $tramite->tipoTramiteKardex->nombre;
                            $detalle->fecha_elaboracion_tramite = $tramite->fecha_elaboracion_tramite;
                            if ( $detalle->tipo_detalle == 'BAJA' ) {
                                $detallesBajas[] = $detalle;
                            } else {
                                $detallesAportaciones[] = $detalle;
                            }
                        }
                    }
                }

                return $pdf = \PDF::loadView('p32_tramites_kardex.formatos.formatoDetallesHojasServicio', compact('fechaCompleta', 'tramiteKardex', 'detallesBajas', 'detallesAportaciones', 'firmas') )
                    ->setPaper('a4', 'landscape')
                    ->download("detalles_".$tramiteKardex->tramite_kardex_id."_tramite_kardex.pdf");

            } else if ($tramiteKardex->tipoTramiteKardex->clave == 'comprobantes_de_servicio') {

                $camposExtra = json_decode($tramiteKardex->campos_extra);

                $detallesKardex = [];
                foreach ($tramites as $i => $tramite) {
                    $detalles = json_decode($tramite->detalles);
                    if ( isset($detalles) ) {
                        foreach ($detalles as $key => $detalle) {
                            $detalle->folio = $tramite->folio;
                            $detalle->tipo_tramite = $tramite->tipoTramiteKardex->nombre;
                            $detalle->fecha_elaboracion_tramite = $tramite->fecha_elaboracion_tramite;
                            $detallesKardex[] = $detalle;
                        }
                    }
                }

                return $pdf = \PDF::loadView('p32_tramites_kardex.formatos.formatoDetallesComprobantesServicio', compact('fechaCompleta', 'tramiteKardex', 'detallesKardex', 'camposExtra', 'firmas'))
                    ->setPaper('a4', 'portrait')
                    ->download("detalles_".$tramiteKardex->tramite_kardex_id."_tramite_kardex.pdf");
            }
        } elseif ($tipo == "p03" || $tipo == "p04") {

            if ($tipo == "p03") {

                $hojaServicio = HistoricoHojaServicio::where("folio_contrasena", $folio)->first();
                // Despues se obtiene los datos del Detalle
                $detallesBajas = $hojaServicio->detallesBajas;
                $detallesAportacion = $hojaServicio->detallesBajas;
                $entidad = $hojaServicio->nombre_entidad ? $hojaServicio->nombre_entidad : false ;

                return $pdf =  \PDF::loadView('p32_tramites_kardex.formatos.historicoFormatoDetallesHojasServicio', compact('hojaServicio', 'fechaCompleta', 'detallesBajas', 'detallesAportacion', 'entidad'))
                    ->setPaper('a4', 'landscape')
                    ->download("detalles_historico_".$tipo.".pdf");

            } elseif ($tipo == "p04") {

                $comprobanteServicio = HistoricoComprobanteServicio::where("folio_contrasena", $folio)->first();
                // Despues se obtiene los datos del Detalle
                $comprobanteServicio->detalles;
                $entidad = $comprobanteServicio->nombre_entidad;

                return $pdf =  \PDF::loadView('p32_tramites_kardex.formatos.historicoFormatoDetallesComprobantesServicio', compact('comprobanteServicio', 'fechaCompleta', 'entidad'))
                    ->setPaper('a4', 'landscape')
                    ->download("detalles_historico_".$tipo.".pdf");
            }
        }
    }

    public function descargarSeguimientos($folio, $tipo)  {

        $fechaCompleta = convertirFechaFormatoMX(Carbon::now());

        if ($tipo == 1 || $tipo == 2) {

            $tramiteKardex = TramiteKardex::where('folio', $folio)->with('tipoTramiteKardex')->first();

            $tramites = TramiteKardex::where('tipo_tramite_kardex_id', $tipo)
                                        ->where('folio', $folio)
                                        ->where('activo', true)
                                        ->get();

            $seguimientos = [];
            foreach ($tramites as $i => $tramite) {
                $seguimiento = json_decode($tramite->seguimientos);
                if ( isset($seguimiento) ) {
                    foreach ($seguimiento as $key => $seguimientoDetalle) {
                        $seguimientoDetalle->folio = $tramite->folio;
                        $seguimientoDetalle->tipo_tramite = $tramite->tipoTramiteKardex->nombre;
                        $seguimientoDetalle->fecha_elaboracion_tramite = $tramite->fecha_elaboracion_tramite;
                        $seguimientos[] = $seguimientoDetalle;
                    }
                }
            }

            return $pdf = \PDF::loadView('p32_tramites_kardex.formatos.formatoSeguimientosKardex', compact('fechaCompleta', 'tramiteKardex', 'seguimientos'))
                ->setPaper('a4', 'landscape')
                ->download("seguimientos_".$tramiteKardex->tramite_kardex_id."_tramite_kardex.pdf");

        } elseif ($tipo == "p03" || $tipo == "p04") {

            if ($tipo == "p03") {

                $tra = "Hojas de servicio";
                $tramite = HistoricoHojaServicio::where("folio_contrasena", $folio)->first();
                // Obtenemos los seguimientos
                $seguimientos = $tramite->seguimientos;

            } elseif ($tipo == "p04") {

                $tra = "Comprobantes de servicio";
                $tramite = HistoricoComprobanteServicio::where("folio_contrasena", $folio)->first();
                // Obtenemos los seguimientos
                $seguimientos = $tramite->seguimientos;
            }

            return $pdf = \PDF::loadView('p32_tramites_kardex.formatos.historicoFormatoSeguimientos', compact('fechaCompleta', 'tramite', 'seguimientos', 'tra'))
                ->setPaper('a4', 'landscape')
                ->download("seguimientos_".$tipo."_historico.pdf");
        }
    }

    public function generarExcelReporteHojasServicio( Request $request, $fecha_de, $fecha_a, $folio, $tipo_tramite, $estatus_historico, $estatus_local, $buscar_en ) {

        if ($buscar_en == "local") {

            $infoServicioQuery = TramiteKardex::where(function ($query) use ($fecha_de, $fecha_a, $folio, $estatus_local, $tipo_tramite) {
                                if ( $folio !== 'null' ) {
                                    $query->where("folio", $folio);
                                }
                                if ( $fecha_de !== 'null') {
                                    $query->whereBetween('created_at', ["$fecha_de 00:00:00", "$fecha_a 23:59:59"]);
                                }
                                if ($estatus_local != 'null') {
                                    $query->where('estatus', $estatus_local);
                                }
                                if ($tipo_tramite != 'null') {
                                    $tipo = TipoTramiteKardex::where('clave', $tipo_tramite)->first();
                                    $query->where('tipo_tramite_kardex_id', $tipo->tipo_tramite_kardex_id);
                                }
                            })
                    ->orderBy('tramite_kardex_id', 'desc')->get();

            return Excel::download(new TramitesKardexExportLocal( $infoServicioQuery ), 'reporte_tramites_kardex.xlsx');

        } else {

            $database_old_connected = false;
            try {
                DB::connection('lbpm_dga')->getPdo();
                $database_old_connected = true;
            } catch (\Exception $e) {

            }

            if ( $database_old_connected ) {

                if ($tipo_tramite == "hojas_de_servicio") {

                    $infoServicioQuery = HistoricoHojaServicio::
                    where(function ($query) use ($fecha_de, $fecha_a, $folio, $estatus_historico) {
                        if ( $folio !== 'null' ) {
                            $query->where("folio_contrasena", $folio);
                        }
                        if ( $fecha_de !== 'null' ) {
                            $query->whereHas('instancia', function ($query) use ($fecha_de, $fecha_a) {
                                $query->whereBetween("created_on", ["$fecha_de 00:00:00", "$fecha_a 23:59:59"]);
                            });
                        }
                        if ($estatus_historico != 'null') {
                            $query->where('work_status', $estatus_historico);
                        }
                    })
                    ->orderBy('p03_id', 'desc')->get();

                    return Excel::download(new TramitesKardexExportHistorico( $infoServicioQuery ), 'reporte_tramites_kardex_historico.xlsx');

                } elseif ($tipo_tramite == "comprobantes_de_servicio") {

                    $infoServicioQuery = HistoricoComprobanteServicio::
                    where(function ($query) use ($fecha_de, $fecha_a, $folio, $estatus_historico) {
                        if ( $folio !== 'null' ) {
                            $query->where("folio_contrasena", $folio);
                        }
                        if ( $fecha_de !== 'null' ) {
                            $query->whereHas('instancia', function ($query) use ($fecha_de, $fecha_a) {
                                $query->whereBetween("created_on", ["$fecha_de 00:00:00", "$fecha_a 23:59:59"]);
                            });
                        }
                        if ($estatus_historico != 'null') {
                            $query->where('work_status', $estatus_historico);
                        }
                    })
                    ->orderBy('p04_id', 'desc')->get();

                    return Excel::download(new TramitesKardexExportHistorico( $infoServicioQuery ), 'reporte_tramites_kardex_historico.xlsx');

                } elseif ($tipo_tramite == 'null') {

                    $infoServicioQueryHojas = HistoricoHojaServicio::
                    where(function ($query) use ($fecha_de, $fecha_a, $folio, $estatus_historico) {
                        if ( $folio !== 'null' ) {
                            $query->where("folio_contrasena", $folio);
                        }
                        if ( $fecha_de !== 'null' ) {
                            $query->whereHas('instancia', function ($query) use ($fecha_de, $fecha_a) {
                                $query->whereBetween("created_on", ["$fecha_de 00:00:00", "$fecha_a 23:59:59"]);
                            });
                        }
                        if ($estatus_historico != 'null') {
                            $query->where('work_status', $estatus_historico);
                        }
                    })
                    ->orderBy('p03_id', 'desc')->get();

                    $infoServicioQueryComprobantes = HistoricoComprobanteServicio::
                    where(function ($query) use ($fecha_de, $fecha_a, $folio, $estatus_historico) {
                        if ( $folio !== 'null' ) {
                            $query->where("folio_contrasena", $folio);
                        }
                        if ( $fecha_de !== 'null' ) {
                            $query->whereHas('instancia', function ($query) use ($fecha_de, $fecha_a) {
                                $query->whereBetween("created_on", ["$fecha_de 00:00:00", "$fecha_a 23:59:59"]);
                            });
                        }
                        if ($estatus_historico != 'null') {
                            $query->where('work_status', $estatus_historico);
                        }
                    })
                    ->orderBy('p04_id', 'desc')->get();

                    $infoServicioQuery = $infoServicioQueryHojas->concat($infoServicioQueryComprobantes);

                    return Excel::download(new TramitesKardexExportHistorico( $infoServicioQuery ), 'reporte_tramites_kardex_historico.xlsx');
                }

            } else {
                return response()->json([ "estatus" => false, "mensaje" => 'Estamos teniendo problemas al conectar con la base de datos histórica.' ]);
            }
        }
    }
}
