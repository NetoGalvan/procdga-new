<?php

namespace App\Http\Controllers\p06_servicio_social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Proceso;
use App\Models\User;
use App\Models\Area;

use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Nomina;
use App\Models\p06_servicio_social\P06NominaDetalle;
use App\Models\p06_servicio_social\P06Instituciones;
use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06ProgramasInstitucion;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoServicioSocial;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoEscuela;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoPrograma;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoNomina;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoNominaDetalle;

use App\Exports\p06_servicio_social\ReporteNominaExport;
use App\Exports\p06_servicio_social\HistoricoNominaExport;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Maatwebsite\Excel\Facades\Excel;

class ReporteServicioSocialController extends Controller
{
    public $estatus = [
        "WORKING" => "EN CURSO",
        "FREE" => "LIBERADO",
        "BAJA" => "BAJA",
        "ABANDON" => "ABANDONO",
        "EN_PROCESO" => "EN PROCESO"
    ];

    public function fecha($fechaNueva) {
        $fechaNueva = Carbon::parse($fechaNueva);
        $meses= [
            "01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo", "04"=>"Abril",
            "05"=>"Mayo", "06"=>"Junio", "07"=>"Julio", "08"=>"Agosto",
            "09"=>"Septiembre", "10"=>"Octubre", "11"=>"Noviembre", "12"=>"Diciembre"
        ];

        $cadenaFecha= $fechaNueva->format('d') . ' de ' . $meses[$fechaNueva->format('m')] . ' del ' . $fechaNueva->format('Y');
        return $cadenaFecha;
    }
    #BEGIN::REPORTE 01
    public function reporteDatosPersonalesPrestador(Request $request){
        $user = Auth::user();
        if ($request->ajax())
        {
            $queryAreas = $this->areas();
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;

            $servicioSocial = P06ServicioSocial::query()->where('fecha_inicio', '>=', $request->fecha_inicio)->where('fecha_fin', '<=', $request->fecha_fin);

            if( $user->hasRole("SUB_EA") ) $servicioSocial = $servicioSocial->whereIn('area_id', $queryAreas->pluck('area_id'));
            $servicioSocial = $servicioSocial->with('prestador')->get();

            if( $this->connect_db_old() ) {
                $historico_servicioSocial = HistoricoServicioSocial::whereNotIn('folio', $servicioSocial->pluck('folio') )
                                                                   ->where('fecha_inicio', '>=', $fechaInicio)
                                                                   ->where('fecha_fin', '<=', $fechaFin);

                if( $user->hasRole("SUB_EA") ) $historico_servicioSocial = $historico_servicioSocial->whereIn('id_unidad_administrativa', $queryAreas->pluck('identificador'));

                $servicioSocial = $servicioSocial->concat( $historico_servicioSocial->get() );
            }

            $servicioSocial->append(['nombre_prestador_completo']);

            return response()->json($servicioSocial);
        }

        return view('p06_servicio_social.Reportes.reporte_datos_personales_prestador', compact('user'));
    }
    # --> Descargar PDF
    public function descargarReportePrestador($folio){

        $existeLocal = P06ServicioSocial::where('folio', $folio)->exists();

        if ( $existeLocal ) {
            $datosPrestador = P06ServicioSocial::firstWhere('folio', $folio);

        } else {
            $datosPrestador = HistoricoServicioSocial::firstWhere('folio', $folio);
        }

        $datosPrestador->fecha_inicio = date_format(Carbon::parse($datosPrestador->fecha_inicio), 'd/m/Y');
        $datosPrestador->fecha_fin = date_format(Carbon::parse($datosPrestador->fecha_fin), 'd/m/Y');

        return \PDF::loadView('p06_servicio_social.Formatos.pdf_datos_personales_prestador', compact('datosPrestador') )->download();
    }
    #END::REPORTE 01
    #BEGIN::REPORTE 02
    public function reportePrestadoresPorUnidadAdministrativa(Request $request){

        $user = Auth::user();
        $areas = Area::query()->where('tipo', 'AREA_PRINCIPAL')->get();
        if( $user->hasRole("SUB_EA") ) $areas = $areas->where('unidad_administrativa_id', $user->area->unidad_administrativa_id);

        $estatus = $this->estatus;

        if ($request->ajax()) {

            $servicioSocial = P06ServicioSocial::query()->where('estatus', '<>', 'RECHAZADO')->whereYear('fecha_inicio', $request->anio);

            $searchAreas = $areas->pluck('area_id');
            if ( !is_null($request->area_identificador) ) {
                $searchAreas = Area::firstWhere('identificador', $request->area_identificador);
                $searchAreas = [$searchAreas->area_id];
            }

            if ( !is_null($request->estatus) ) {
                $estatus_en_curso = ($request->estatus == 'WORKING') ? 'EN_CURSO' : null;
                if( !is_null($estatus_en_curso) ){
                    $servicioSocial = $servicioSocial->where('estatus', $this->estatus[$request->estatus])->orWhere('estatus', $estatus_en_curso);
                } else {
                    $servicioSocial = $servicioSocial->where('estatus', $this->estatus[$request->estatus]);
                }
            }
            $servicioSocial = $servicioSocial->whereIn('area_id', $searchAreas)->with(['prestador'])->get();

            # --> La otra B.D
            if( $this->connect_db_old() ) {

                $historico_servicioSocial = HistoricoServicioSocial::whereNotIn('folio', $servicioSocial->pluck('folio') )->where('work_status', '<>', 'PREMATURE_END')->whereYear('fecha_inicio', $request->anio);

                $searchAreasHistorico = $areas->pluck('identificador');
                if ( !is_null($request->area_identificador) ) {
                    $searchAreasHistorico = [$request->area_identificador];
                }

                if ( !is_null($request->estatus) ) {
                    $historico_servicioSocial = $historico_servicioSocial->where('work_status', $request->estatus);
                }

                $historico_servicioSocial = $historico_servicioSocial->whereIn('id_unidad_administrativa', $searchAreasHistorico)->get();
                $servicioSocial = $servicioSocial->concat($historico_servicioSocial);

            }

            # --> Descargar PDF
            if( isset($request->descargar_reporte) ){
                return $pdf = \PDF::loadView('p06_servicio_social.Formatos.pdf_prestadores_por_unidades', compact('servicioSocial', 'estatus') )
                                  ->setPaper('a4', 'landscape')->download();
            }

            $servicioSocial->append(['nombre_prestador_completo', 'nombre_unidad_administrativa']);
            return response()->json($servicioSocial);
        }

        return view('p06_servicio_social.Reportes.reporte_prestadores_por_unidad_administrativa', compact('areas', 'estatus', 'user'));
    }
    #END:REPORTE 02
    #BEGIN::REPORTE 05
    public function reporteInstitucionesEscuelasProgramas(Request $request){
        if ( $request->ajax() )
        {
            $informacion = null;
            switch($request->opcion){
                case 'INSTITUCIONES':
                    $infoLocal = P06Instituciones::get();
                    $infoHistorico = null;
                break;
                case 'ESCUELAS':
                    $infoLocal = P06Escuela::get();
                    $infoHistorico = ( $this->connect_db_old() ) ? HistoricoEscuela::get() : null;
                break;
                case 'PROGRAMAS':
                    $infoLocal = P06ProgramasInstitucion::get();
                    $infoHistorico = null;
                break;
            }
            $informacion = ( !is_null($infoHistorico) ) ? $infoLocal->concat($infoHistorico) : $infoLocal;

            # --> Descargar PDF
            if( isset($request->descargar_reporte) ){
                $opcion = $request->opcion;
                return \PDF::loadView('p06_servicio_social.Formatos.pdf_instituciones_escuelas_programas', compact('informacion','opcion'))->download();
            }
            return response()->json($informacion);
        }

        $opciones = ['INSTITUCIONES', 'ESCUELAS', 'PROGRAMAS'];
        return view('p06_servicio_social.Reportes.reporte_instituciones_escuelas_programas', compact('opciones'));
    }
    #END::REPORTE 05
    #BEGIN::REPORTE 06
    public function reimpresionCartaServicio(Request $request){
        if ($request->ajax()) {
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;

            $servicioSocial = P06ServicioSocial::where('fecha_inicio', '>=', $request->fecha_inicio)
                                                ->where('fecha_fin', '<=', $request->fecha_fin)
                                                ->with('prestador')->get();



            # --> La otra B.D
            if( $this->connect_db_old() ) {
                $historico_servicioSocial = HistoricoServicioSocial::whereNotIn('folio', $servicioSocial->pluck('folio') )
                                                                    ->where('fecha_inicio', '>=', $fechaInicio)
                                                                    ->where('fecha_fin', '<=', $fechaFin)
                                                                    ->get();

                $servicioSocial = $servicioSocial->concat($historico_servicioSocial);
            }

            $servicioSocial->append(['nombre_prestador_completo']);
            return response()->json($servicioSocial);
        }
        return view('p06_servicio_social.Reportes.reimpresion_cartas_servicio_social');
    }
    # --> Descargar PDF Carta de aceptación / termino
    public function descargarCartas(Request $request)
    {
        $rol = ( $request->tipo_carta == 'ACEPTACION') ? "AUTORIZADOR_CARTA_INICIO_SS" : "AUTORIZADOR_CARTA_TERMINO_SS";

        $servicioSocial = P06ServicioSocial::firstWhere('folio', $request->folio);

        if( is_null($servicioSocial) ) {
            if( $this->connect_db_old() ) $servicioSocial = HistoricoServicioSocial::firstWhere('folio', $request->folio);
        }

        $firmaCarta = User::whereHas("roles", function($q) use ($rol) {
                                $q->where("name", $rol);
                            })->first(['nombre', 'apellido_paterno', 'apellido_materno', 'puesto']);

        $cadenaFechaInicioSS = $this->fecha( $servicioSocial->fecha_inicio );
        $cadenaFechaFinSS = $this->fecha( $servicioSocial->fecha_fin );

        $arr_compact = ['servicioSocial', 'cadenaFechaInicioSS', 'cadenaFechaFinSS'];
        switch ( $request->tipo_carta ) {
            case 'ACEPTACION':
                $view_pdf = 'p06_servicio_social.Formatos.cartaAceptacion';
                $firmaCartaInicio = $firmaCarta;
                array_push($arr_compact, 'firmaCartaInicio');
            break;

            case 'TERMINO':
                $view_pdf = 'p06_servicio_social.Formatos.cartaTerminacion';
                $firmaCartaFin = $firmaCarta;
                array_push($arr_compact, 'firmaCartaFin');
            break;
        }

        return \PDF::loadView( $view_pdf , compact( $arr_compact ))->download();
    }
    #END::REPORTE 06
    #BEGIN::REPORTE 03
    public function reporteNominaServiciosocial(Request $request){

        $user = Auth::user();
        $queryNomina = P06Nomina::query()->whereHas('nominaDetalle');
        $queryNomina = $this->funct_R03_R04($queryNomina, ['area_id', 'area_id'])->get();

        # --> La otra B.D.
        if( $this->connect_db_old() ){
            $historicoNomina = HistoricoNomina::where('tipo_validacion', '<>', null)->whereHas('nominaDetalle');
            $historicoNomina = $this->funct_R03_R04($historicoNomina, ['id_unidad_administrativa', 'identificador'])->get();

            $queryNomina = $queryNomina->concat($historicoNomina);
        }

        $anioCreacion = $queryNomina->unique('anio_creacion')->pluck('anio_creacion')->toArray();
        arsort($anioCreacion);

        return view('p06_servicio_social.Reportes.reporte_ejecutivo_nomina', compact('anioCreacion','user'));
    }
    # --> Descargar PDF
    public function descargarReporteEjecutivoNomina(Request $request){

        $anio = $request->anio;
        $arrUdAdmin = [];
        $user = Auth::user();

        $datosNominas = P06Nomina::whereYear('created_at', $anio)->whereHas('nominaDetalle');
        $datosNominas = $this->funct_R03_R04($datosNominas, ['area_id', 'area_id'])->get();

        # --> La otra B.D.
        if( $this->connect_db_old() ){
            $historicoNomina = HistoricoNomina::query()->where('tipo_validacion', '<>', null)->whereHas('nominaDetalle')
                                ->whereHas('instancia', function($q) use ($anio) {
                                    $q->whereYear('created_on', $anio);
                                });

            $historicoNomina = $this->funct_R03_R04($historicoNomina, ['id_unidad_administrativa', 'identificador'])->get();
            $datosNominas = $datosNominas->concat($historicoNomina);
        }

        if($user->hasRole("PROG_SS") || $user->hasRole("SUPER_ADMIN")){
            # --> Agregar las unidades administrativas al arreglo $arrUdAdmin
            foreach($datosNominas as $nomina){
                $base_actual = false;
                if ( !is_null($nomina->nominaDetalle->first()->id_p06) ) {
                    $identificador = HistoricoServicioSocial::whereIn('id_p06', $nomina->nominaDetalle->pluck('id_p06'))->get()
                                                        ->unique('id_unidad_administrativa')
                                                        ->pluck('id_unidad_administrativa')->toArray();

                } else {
                    $identificador = P06ServicioSocial::whereIn('nomina_id', $nomina->nominaDetalle->pluck('nomina_id'))->get()
                                                        ->unique('area_id');
                    $base_actual = true;
                }

                foreach ($identificador as $value){
                    if ( $base_actual ) $value = $value->area->identificador;
                    if( !in_array($value, $arrUdAdmin)) array_push($arrUdAdmin, $value);
                }
            }
        }
        $areas = Area::whereIn('identificador', $arrUdAdmin)->get();

        return \PDF::loadView('p06_servicio_social.Formatos.pdf_reporte_ejecutivo_nomina', compact('datosNominas', 'anio', 'areas', 'user'))->download();
    }
    #END::REPORTE 03
    #BEGIN::REPORTE 04
    public function reporteNominaPrestadoresExcel(Request $request){

        $user = Auth::user();
        $nominas = P06Nomina::query()->whereHas('nominaDetalle');
        $nominas = $this->funct_R03_R04($nominas, ['area_id', 'area_id'])->get();

        # --> La otra B.D.
        if( $this->connect_db_old() ){
            $historicoNominas = HistoricoNomina::query()->where('tipo_validacion', '<>', null)->whereHas('nominaDetalle');
            $historicoNominas = $this->funct_R03_R04($historicoNominas, ['id_unidad_administrativa', 'identificador'])->get()->append(['nomina_id']);

            $nominas = $nominas->concat($historicoNominas);
        }

        return view('p06_servicio_social.Reportes.reporte_nomina_prestadores_excel', compact('nominas', 'user'));
    }
    # --> Descargar Excel
    public function descargarReporteNominaPrestadoresExcel(Request $request){
        $nomina = P06Nomina::firstWhere('folio', $request->folio);

        if( is_null($nomina) ){
            if( $this->connect_db_old() )
            {
                $nomina = HistoricoNomina::firstWhere('folio', $request->folio);
                $nominaDetalle = HistoricoNominaDetalle::where('id_p06_nomina', $nomina->id_p06_nomina)->get();
            }
        } else {
            $nominaDetalle = P06NominaDetalle::where('nomina_id', $nomina->nomina_id)->get();
        }

        return Excel::download(new ReporteNominaExport($nomina, $nominaDetalle), 'nomina.xlsx');
    }
    #END::REPORTE 04

    # ------ FROM::REPORTES 01, 03 Y 04
    public function areas() {
        $ud_administrativa_id = Auth::user()->area->unidad_administrativa_id;
        return Area::where('unidad_administrativa_id', $ud_administrativa_id)->get();
    }

    # ------ FROM::REPORTES 03 Y 04
    public function funct_R03_R04($nominas, $campos){
        $areas = $this->areas();
        if( Auth::user()->hasRole("SUB_EA") ){
            $nominas = $nominas->whereHas('nominaDetalle', function($q) use ($areas, $campos){
                            $q->whereHas('servicioSocial', function($q02) use ($areas, $campos)
                            {
                                $q02->whereIn( $campos[0], $areas->pluck( $campos[1] ) );
                            });
                        });
        }
        return $nominas;
    }

    # ------ Conexion con la otra B.D.
    public function connect_db_old() {
        $db_old_connected = false;
        try {
                DB::connection('lbpm_dga')->getPdo();
                $db_old_connected = true;

            } catch (\Exception $e) { }

        return $db_old_connected;
    }
}
