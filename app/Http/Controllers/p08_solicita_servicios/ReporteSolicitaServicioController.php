<?php

namespace App\Http\Controllers\p08_solicita_servicios;

use App\Exports\p08_solicitud_servicios\SolicitudServiciosExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\p08_solicita_servicios\P08SolicitaServicio;
use App\Models\p08_solicita_servicios\P08Vehiculo;
use App\Models\p08_solicita_servicios\Servicio;
use App\Models\p08_solicita_servicios\ServicioGeneral;
use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p08_solicita_servicios\HistoricoSolicitaServicio;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;
use App\User;
use DateTime;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

class ReporteSolicitaServicioController extends Controller
{

    var $roles = ['JUD_MTTO' => 'JUD_MTTO', 'JUD_TRANSPORTE' => 'JUD_TRANSPORTE', 'JUD_RM' => 'JUD_RM'];
    var $estatus = [
        "EN_PROCESO" => "EN_PROCESO",
        "RECHAZADO" => "RECHAZADO",
        "COMPLETADO" => "COMPLETADO",
        "CANCELADO" => "CANCELADO",
    ];
    /* var $estatus = [
        "NEW" => "NUEVO",
        "PROPOSED" => "PROPUESTO",
        "REJECTED" => "RECHAZADO",
        "ACCEPTED" => "COMPLETADO",
        "DELIVERY_FAIL" => "ENVIO_RECHAZADO",
        "DELIVERY_OK" => "COMPLETADO",
    ]; */
    /**
     * REPORTE DE SOLICITUD DE SERVICIOS
     * Método encargado de generar los reportes de las solicitudes de servicios hechos al área.
     */
    public function reporteSolicitudServicio(Request $request)   {
        $servicioGeneral = ServicioGeneral::activo()->where("clave", last(request()->segments()))->first();
        $servicios = $servicioGeneral->servicios;
        $areas = Area::where('activo', true)
                    ->whereNull('area_principal_id')
                    ->get();

        if ($request->ajax()) {

            // Valido si existe connexión a la 'OLD_DATABASE'
            /* $database_old_connected = false;
            try {
                DB::connection('lbpm_dga')->getPdo();
                $database_old_connected = true;
            } catch (\Exception $e) {

            } */

            // Número de elementos por página
            $pageSize = $request->pageSize;

            // Página actual
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            // Índice de inicio
            $offset = ($currentPage - 1) * $pageSize;

            $serviciosSolicitadosQuery = P08SolicitaServicio::activo()
                ->where('servicio_general_id', $servicioGeneral->servicio_general_id)
                ->where(function ($query) use ($request) {
                    if (!is_null($request->area_id)) {
                        $query->where("area_id", $request->area_id);
                    }
                    if (!is_null($request->estatus)) {
                        $query->where("estatus", $request->estatus);
                    }
                    if (!is_null($request->anio)) {
                        $query->whereBetween('created_at', ["$request->anio/01/01 00:00:00", "$request->anio/12/31 23:59:59"]);
                    }
                    if (!is_null($request->especialidad)) {
                        $query->whereHas('detalles.servicio', function ($query) use ($request) {
                            $query->where(DB::raw('upper("nombre_servicio")'), "like", "%" . mb_strtoupper($request->especialidad) . "%")
                                ->orWhere(DB::raw('upper("nombre_servicio")'), "like", "%" . mb_strtoupper(unaccent($request->especialidad)) . "%");
                        });
                    }
                })
                ->orderBy('p08_solicita_servicio_id', 'desc');

            // Total servicios solicitados
            $serviciosSolicitadosTotal = $serviciosSolicitadosQuery->count();

            /* if ( $database_old_connected ) {

                $serviciosSolicitadosHistoricoQuery = HistoricoSolicitaServicio::
                    where("tipo_solicitud", $servicioGeneral->clave)
                    ->where(function ($query) use ($request) {
                        if (!is_null($request->area_id)) {
                            $area = Area::find($request->area_id);
                            $query->where("id_unidad_admva", $area->identificador);
                        }
                        if (!is_null($request->estatus) ) {
                            $query->where("status_solicitud", array_search($request->estatus, $this->estatus));
                        }
                        if (!is_null($request->anio)) {
                            $query->whereHas('instancia', function ($query) use ($request) {
                                $query->whereBetween("created_on", ["$request->anio/01/01 00:00:00", "$request->anio/12/31 23:59:59"]);
                            });
                        }
                        if (!is_null($request->especialidad)) {
                            $query->whereHas('detalles', function ($query) use ($request) {
                                $query->where(DB::raw('upper("tipo_servicio")'), "like", "%" . mb_strtoupper($request->especialidad) . "%")
                                    ->orWhere(DB::raw('upper("tipo_servicio")'), "like", "%" . mb_strtoupper(unaccent($request->especialidad)) . "%");
                            });
                        }
                    })
                    ->orderBy('id_solicitud', 'desc');

                // Total servicios solicitados históricos
                $serviciosSolicitadosHistoricoTotal = $serviciosSolicitadosHistoricoQuery->count();

            } else {

                $serviciosSolicitadosHistoricoTotal = 0;

            } */


            // Traer servicios solicitados actuales
            $serviciosSolicitados = $serviciosSolicitadosQuery
                ->limit($pageSize)
                ->offset($offset)
                ->get();

            $serviciosSolicitadosHistorico = [];
            if ($serviciosSolicitados->count() < $pageSize) {
                $pageSizeHistorico = $pageSize - $serviciosSolicitados->count();
                $offsetHistorico = $serviciosSolicitados->count() > 0 ? 0 : $offset - $serviciosSolicitadosTotal;

                // Elementos servicios solicitados historicos
                /* if ( $database_old_connected ) {
                    $serviciosSolicitadosHistorico = $serviciosSolicitadosHistoricoQuery
                        ->limit($pageSizeHistorico)
                        ->offset($offsetHistorico)
                        ->get();
                } */

            }
            // Total elemntos actuales e históricos
            $total = $serviciosSolicitadosTotal;
            // $total = $serviciosSolicitadosTotal + $serviciosSolicitadosHistoricoTotal;

            // Totos los servicios solicitados, tanto actuales como históricos
            /* if ( $database_old_connected ) {
                $currentPageSearchResults = $serviciosSolicitados->concat($serviciosSolicitadosHistorico);
            } else {
            } */
            $currentPageSearchResults = $serviciosSolicitados;

            // Create our paginator and pass it to the view
            $paginatedSearchResults = new LengthAwarePaginator($currentPageSearchResults, $total, $pageSize);

            // Set current path
            $paginatedSearchResults->setPath($request->url());

            return $paginatedSearchResults;
        }

        return view('p08_solicita_servicios.reportes.reporte_solicita_servicio')->with([
            'servicioGeneral' => $servicioGeneral,
            'servicios' => $servicios,
            'estatus' => $this->estatus,
            'areas' => $areas
        ]);
    }

    // Funcion Ajax para Ver del Detalle del Servicio
    public function verDetalleReporteSolicitudServicio(Request $request) {

        try {
            // Se consulta del Servicio de Mantenimiento solicitado a traves del Folio en la DB actual
            $servicioSolicitado = P08SolicitaServicio::where('folio', $request->folio)->first();
            if ( isset($servicioSolicitado) ) {
                // Despues se obtiene los datos del Detalle del Servicio
                $servicioSolicitado->detalles;
            } else {
                // Se consulta del Servicio de Mantenimiento solicitado a traves del Folio en la DB Historica
                $servicioSolicitado = HistoricoSolicitaServicio::where("folio", $request->folio)->first();
                // Despues se obtiene los datos del Detalle del Servicio
                $servicioSolicitado->detalles;
            }

            $respuesta = [  'estatus' => true,
                            'servicioSolicitado' => $servicioSolicitado,
                            'msj' => '¡Datos del Servicio encontrados exitosamente!' ];

            return response()->json($respuesta);
        } catch (\Throwable $th) {

            $respuesta = [  'estatus' => false,
                            'msj' => '¡Surgió un error, intente más tarde!',
                            'error' => $th ];

            return response()->json($respuesta);
        }
    }

    // Función para Generar el PDF Individual del Detalle del Servicio
    public function imprimirDetalleReporteSolicitudServicio($solicitudServicio, $folio) {

        // Uso el metodo general para crear la fecha
        $cadenaFecha = convertirFechaFormatoMX(Carbon::now());

        // Se consulta del Servicio Solicitado a traves del Id y Folio
        $servicioSolicitado = P08SolicitaServicio::where('folio', $folio)->first();
        if ( isset($servicioSolicitado) ) {
            // Despues se obtiene los datos del Detalle del Servicio
            $servicioSolicitado->detalles;
        } else {
            // Se consulta del Servicio de Mantenimiento solicitado a traves del Folio en la DB Historica
            $servicioSolicitado = HistoricoSolicitaServicio::where("folio", $folio)->first();
            // Despues se obtiene los datos del Detalle del Servicio
            $servicioSolicitado->detalles;
        }

        // Se mandan a la vista para generar el PDF
        $pdf = \PDF::loadView('p08_solicita_servicios.reportes.pdf_reportes_solicita_servicios.pdf_solicita_servicios', compact('servicioSolicitado','cadenaFecha') )->setPaper('a4', 'portrait')->output();

        $pdf = base64_encode($pdf);
        return response()->json([
            "estatus" => true,
            "pdf" => $pdf,
            "nombre" => "Formato-Comprobante-Servicio-".$folio.".pdf"
        ]);
    }


    // Método para GENERAR EXCEL de las SOLICITUDES SERVICIO
    public function generarExcelReporteSolicitudServicio( Request $request, $tipo_servicio, $anio, $area_id, $estatus, $especialidad ) {

        $servicioGeneral = ServicioGeneral::activo()->where("servicio_general_id", $tipo_servicio)->first();

        // Valido si existe connexión a la 'OLD_DATABASE'
        /* $database_old_connected = false;
        try {
            DB::connection('lbpm_dga')->getPdo();
            $database_old_connected = true;
        } catch (\Exception $e) {

        } */

        $serviciosSolicitados = P08SolicitaServicio::activo()
            ->where('servicio_general_id', $servicioGeneral->servicio_general_id)
            ->where(function ($query) use ($area_id, $estatus, $anio, $especialidad) {
                if ( $area_id !== 'null' ) {
                    $query->where("area_id", $area_id);
                }
                if ( $estatus !== 'null' ) {
                    $query->where("estatus", $estatus);
                }
                if ( $anio !== 'null' ) {
                    $query->whereBetween('created_at', ["$anio/01/01 00:00:00", "$anio/12/31 23:59:59"]);
                }
                if ( $especialidad !== 'null' ) {
                    $query->whereHas('detalles.servicio', function ($query) use ($especialidad) {
                        $query->where(DB::raw('upper("nombre_servicio")'), "like", "%" . mb_strtoupper($especialidad) . "%")
                            ->orWhere(DB::raw('upper("nombre_servicio")'), "like", "%" . mb_strtoupper(unaccent($especialidad)) . "%");
                    });
                }
            })
            ->orderBy('p08_solicita_servicio_id', 'desc')
            ->get();

        $servicios = $serviciosSolicitados;
        /* if ( $database_old_connected ) {

            $serviciosSolicitadosHistorico = HistoricoSolicitaServicio::
                    where("tipo_solicitud", $servicioGeneral->clave)
                    ->where(function ($query) use ($area_id, $estatus, $anio, $especialidad) {
                        if ( $area_id !== 'null' ) {
                            $area = Area::find($area_id);
                            $query->where("id_unidad_admva", $area->identificador);
                        }
                        if ( $estatus !== 'null' ) {
                            $query->where("status_solicitud", array_search($estatus, $this->estatus));
                        }
                        if ( $anio !== 'null' ) {
                            $query->whereHas('instancia', function ($query) use ($anio) {
                                $query->whereBetween("created_on", ["$anio/01/01 00:00:00", "$anio/12/31 23:59:59"]);
                            });
                        }
                        if ( $especialidad !== 'null' ) {
                            $query->whereHas('detalles', function ($query) use ($especialidad) {
                                $query->where(DB::raw('upper("tipo_servicio")'), "like", "%" . mb_strtoupper($especialidad) . "%")
                                    ->orWhere(DB::raw('upper("tipo_servicio")'), "like", "%" . mb_strtoupper(unaccent($especialidad)) . "%");
                            });
                        }
                    })
                    ->orderBy('id_solicitud', 'desc')
                    ->get();

            $servicios = $serviciosSolicitados->concat($serviciosSolicitadosHistorico);

        } else {

            $servicios = $serviciosSolicitados;

        } */

        return Excel::download(new SolicitudServiciosExport( $servicios ), 'reporte_solicitud_servicio.xlsx');
    }

}
