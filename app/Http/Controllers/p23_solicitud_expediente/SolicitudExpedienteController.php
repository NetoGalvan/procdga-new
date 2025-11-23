<?php

namespace App\Http\Controllers\p23_solicitud_expediente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\p23_solicitud_expediente\ManejadorTareasSolicitud;
use App\Models\p23_solicitud_expediente\P23Solicitud;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\InstanciaTarea;
use App\Models\p23_solicitud_expediente\P23Indice;

class SolicitudExpedienteController extends Controller
{
    use ManejadorTareasSolicitud;

    public function descripcion(){
        return view('p23_digitalizacion_archivo.p23_solicitud_expediente.tareas.descripcion');
    }

    public function cancelarProceso(P23Solicitud $solicitud, InstanciaTarea $instanciaTarea){

        $instanciaTarea->updateEstatus('COMPLETADO');
        $solicitud->activo = false;
        $solicitud->estatus = "CANCELADO";
        $solicitud->save();
        $instancia = $solicitud->instancia;
        $instancia->estatus = "CANCELADO";
        $instancia->save();

        return redirect()->route('tareas')->with("success", "La tarea y el proceso finalizaron correctamente.");
    }

    public function iniciarProceso(Request $request){

        try {
            DB::beginTransaction();
                $solicitud = P23Solicitud::create([
                    'estatus' => 'WORKING',
                    'area_creadora_id' => Auth::user()->area_id
                ]);
                $instancia = $this->crearInstancia('solicitud_prestamo_expedientes', $solicitud, Auth::user()->area);
                $instanciaTarea = $instancia->crearInstanciaTarea('TSOL01', 'NUEVO');

                $mensaje = 'Se ha iniciado correctamente el proceso, será dirigido a la primer tarea';
            DB::commit();

            return response()->json([ "estatus" => true, "mensaje" => $mensaje, "ruta" => route('solicitud.expediente.solicitud.prestamo.expediente', [$solicitud, $instanciaTarea])]);

        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error al iniciar el proceso." . $th ]);
        }
    }

    public function solicitudPrestamoExpediente(Request $request, P23Solicitud $solicitud, InstanciaTarea $instanciaTarea) {

        $instancia =  $solicitud->instancia;

        $tipo_prestamo = ['solicitud_expediente' => "SOLICITUD DE EXPEDIENTE", 'solicitud_recibos' => "SOLICITUD DE RECIBOS TIMBRADOS"];
        $tipo_expediente = ['original' => "ORIGINAL", 'copia_fotostatica' => "COPIA FOTOSTÁTICA", 'copia_certificada' => "COPIA CERTIFICADA", 'copia_digitalizada' => "COPIA DIGITALIZADA"];
        $tipo_solicitante = ['autoridad_judicial' => "AUTORIDAD JUDICIAL", 'funcionario_cdmx' => "FUNCIONARIO DE LA CDMX", 'funcionario_otra_dependencia' => "FUNCIONARIO DE OTRA DEPENDENCIA", 'familiar' => "FAMILIAR", 'empleado' => "EMPLEADO / PRESTADOR DE HONORARIOS", 'otro' => "OTRO"];

        if ($request->isMethod('post')) {

            try {

                $user = Auth::user();

                if ( isset($request->indice_id_seleccion) ) {
                    $datos_empleado = P23Indice::where('rfc', $request->rfc)->first();
                }else {
                    $datos_empleado = null;
                }

                $datosCreador = DB::table('areas as a')
                ->join('users as u', 'a.area_id', '=', 'u.area_id')
                ->join('unidades_administrativas as ua', 'a.unidad_administrativa_id', '=', 'ua.unidad_administrativa_id')
                ->where('a.area_id', $user->area_id)
                ->where('u.id', $user->id)
                ->select('a.area_id', 'a.nombre as nombre_area', 'a.cn', 'u.nombre_usuario', 'u.puesto', 'u.nombre as nombre_usu', 'u.apellido_paterno', 'u.apellido_materno', 'ua.unidad_administrativa_id', 'ua.nombre as nombre_unidad', 'ua.identificador as identificador_unidad_ua')
                ->first();

                $ok = $this->guardarTSOL01($request->all(), $datos_empleado, $solicitud, $datosCreador);

                if ($ok['estatus']) {

                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('TSOL02', 'NUEVO');

                    return redirect()->route('tareas')->with("success", $ok['mensaje']);

                }else {
                    return back()->withInput()->withErrors(['mensaje_error' => $ok['mensaje']]);
                }

            } catch (\Throwable $th) {

            }
        }

        return view('p23_digitalizacion_archivo.p23_solicitud_expediente.tareas.TSOL01_solicitudPrestamoExpediente', compact('solicitud', 'instanciaTarea', 'tipo_prestamo', 'tipo_expediente', 'tipo_solicitante'));
    }

    public function buscarExpedienteTrabajador(Request $request){
        try {

            if ($request->tipo_prestamo == "solicitud_expediente") {

                $existeExpediente = P23Indice::where('rfc', $request->rfc)->where('activo', true)->exists();

                if ( $existeExpediente ) {

                    $datos = P23Indice::where('rfc', $request->rfc)->get();
                    return response()->json([ "estatus" => true, "mensaje" => 'Datos encontrados correctamente', 'datos' => $datos]);

                } else {
                    return response()->json([ "estatus" => false, "mensaje" => 'No se encontraron datos de este empleado, por favor llene el campo de COMENTARIOS con los datos de la solicitud' ]);
                }
            } else {
                // Para cuando se haga el otro escenario
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
