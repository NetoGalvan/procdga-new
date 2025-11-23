<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Area;

use App\Models\p23_solicitud_expediente\P23Digitalizacion;
use App\Models\p23_solicitud_expediente\P23Indice;
use App\Models\p23_solicitud_expediente\P23DetalleDigitalizacion;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Digitalizacion;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Indice;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23DetalleDigitalizacion;

class DatabaseHistoricoSeederP23 extends Seeder
{
    public function run() {
        $remplazar = ['á' => 'Á', 'é' => 'É', 'í' => 'Í', 'ó' => 'Ó', 'ú' => 'Ú', 'ñ' => 'Ñ'];

        $estatus = [
            'WORKING' => 'EN_PROCESO',
            'COMPLETED' => 'COMPLETADO'
        ];
        
        #Conectar a la B.D. historica
        $db_old_connected = false;
        try {
            DB::connection('lbpm_dga')->getPdo();
            $db_old_connected = true;
        
        } catch (\Exception $e) { }

        if( $db_old_connected ) {
            $historicoIndice = HistoricoP23Indice::orderByDesc('last_modified')->get();

            foreach ($historicoIndice->unique('rfc') as $historico) {
                $area = Area::firstWhere('identificador', $historico->created_by_ou);

                if( !is_null($historico->id_p23_digitalizacion)) {
                    if( $historico->status_devolucion !== 'PERDIDA TOTAL') {
                        $indiceCreado = P23Indice::create([
                            'p23_indice_id' => $historico->id_p23_indice,
                            'area_creadora_id' => $area->area_id,
                            'folio' => $historico->folio,
                            'numero_empleado' => $historico->numero_empleado,
                            'nombre_empleado' => strtr( mb_strtoupper( $historico->nombre_empleado ), $remplazar),
                            'apellido_paterno' => strtr( mb_strtoupper( $historico->apellido_paterno ), $remplazar),
                            'apellido_materno' => strtr( mb_strtoupper( $historico->apellido_materno ), $remplazar),
                            'rfc' => $historico->rfc,
                            'numero_expediente' => $historico->numero_expediente,
                            'disponible' => ($historico->status_devolucion == 'PRESTADO') ? false : true,
                            'estatus_devolucion' => $historico->status_devolucion,
                            'creado_por' => $historico->created_by,
                            'creado_por_nombre' => strtr( mb_strtoupper( $historico->created_by_cn ), $remplazar),
                            'creado_por_puesto' => strtr( mb_strtoupper( $historico->created_by_title ), $remplazar),
                            'created_at' => $historico->created_on,
                            'updated_at' => $historico->last_modified
                        ]);

                        $historicoDigitalizacionEncontrado = HistoricoP23Digitalizacion::where('id_p23_indice', $indiceCreado->p23_indice_id)->whereIn('work_status', ['COMPLETED', 'WORKING'])->orderByDesc('last_modified')->first();

                        if ( $historicoDigitalizacionEncontrado->id_p23_indice !== null ) {
                            
                            $registroCreado = P23Digitalizacion::create([
                                'area_creadora_id' => $area->area_id ,
                                'p23_indice_id' => $indiceCreado->p23_indice_id,
                                'folio' => $indiceCreado->folio,
                                'estatus' => $estatus[$historicoDigitalizacionEncontrado->work_status],
                                'numero_empleado' => $indiceCreado->numero_empleado,
                                'nombre_empleado' => strtr( mb_strtoupper( $indiceCreado->nombre_empleado ), $remplazar),
                                'apellido_paterno' => strtr( mb_strtoupper( $indiceCreado->apellido_paterno ), $remplazar),
                                'apellido_materno' => strtr( mb_strtoupper( $indiceCreado->apellido_materno ), $remplazar),
                                'rfc' => $indiceCreado->rfc,
                                'numero_expediente' => $indiceCreado->numero_expediente,
                                //"nombre_archivo" => $historicoDigitalizacionEncontrado->nombre_archivo,
                                //"fecha_carga" => $historicoDigitalizacionEncontrado->fecha_carga,
                                "version" => $historicoDigitalizacionEncontrado->version,
                                //"archivo_original" => $historicoDigitalizacionEncontrado->archivo_original,
                                "subido_por" => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->uploaded_by ), $remplazar),
                                "subido_por_usuario" => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->uploaded_by_cn ), $remplazar),
                                "subido_por_ip" => $historicoDigitalizacionEncontrado->uploaded_by_ip,
                                'comentarios_eliminacion' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->comentarios_eliminacion ), $remplazar),
                                'creado_por' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->created_by ), $remplazar),
                                'creado_por_nombre' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->created_by_cn ), $remplazar),
                                'creado_por_puesto' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->created_by_title ), $remplazar),
                                'created_at' => $historicoDigitalizacionEncontrado->created_on,
                                'updated_at' => $historicoDigitalizacionEncontrado->last_modified
                            ]);

                            $historicoDetalles = HistoricoP23DetalleDigitalizacion::where('folio', $registroCreado->folio)->get();

                            foreach ($historicoDetalles as $htcDetalles) {

                                if ( !is_null($htcDetalles->folio) ) {
                                    P23DetalleDigitalizacion::create([
                                        'p23_digitalizacion_id' => $registroCreado->p23_digitalizacion_id,
                                        'activo' => false,
                                        'folio' => $registroCreado->folio,
                                        'documento' => $htcDetalles->documento,
                                        'hojas' => $htcDetalles->hojas,
                                        'creado_por' => $htcDetalles->created_by,
                                        'creado_por_nombre' => $htcDetalles->created_by_cn,
                                        'creado_por_puesto' => $htcDetalles->created_by_title,
                                        'area_creadora_id' => $area->area_id,
                                        'created_at' => $htcDetalles->created_on,
                                        'updated_at' => $htcDetalles->last_modified
                                    ]);

                                }
                            }
                        }

                    }
                    //$historicoDigitalizacionEncontrado = HistoricoP23Digitalizacion::where('id_p23_indice', $indiceCreado->p23_indice_id)->whereIn('work_status', ['COMPLETED', 'WORKING'])->orderByDesc('last_modified')->first();
/*
                    if ( $historicoDigitalizacionEncontrado->id_p23_indice !== null ) {
                        
                        $registroCreado = P23Digitalizacion::create([
                            'area_creadora_id' => $area->area_id ,
                            'p23_indice_id' => $indiceCreado->p23_indice_id,
                            'folio' => $indiceCreado->folio,
                            'estatus' => $historicoDigitalizacionEncontrado->work_status,
                            'numero_empleado' => $indiceCreado->numero_empleado,
                            'nombre_empleado' => strtr( mb_strtoupper( $indiceCreado->nombre_empleado ), $remplazar),
                            'apellido_paterno' => strtr( mb_strtoupper( $indiceCreado->apellido_paterno ), $remplazar),
                            'apellido_materno' => strtr( mb_strtoupper( $indiceCreado->apellido_materno ), $remplazar),
                            'rfc' => $indiceCreado->rfc,
                            'numero_expediente' => $indiceCreado->numero_expediente,
                            "nombre_archivo" => $historicoDigitalizacionEncontrado->nombre_archivo,
                            "fecha_carga" => $historicoDigitalizacionEncontrado->fecha_carga,
                            "version" => $historicoDigitalizacionEncontrado->version,
                            "archivo_original" => $historicoDigitalizacionEncontrado->archivo_original,
                            "subido_por" => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->uploaded_by ), $remplazar),
                            "subido_por_usuario" => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->uploaded_by_cn ), $remplazar),
                            "subido_por_ip" => $historicoDigitalizacionEncontrado->uploaded_by_ip,
                            'comentarios_eliminacion' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->comentarios_eliminacion ), $remplazar),
                            'creado_por' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->created_by ), $remplazar),
                            'creado_por_nombre' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->created_by_cn ), $remplazar),
                            'creado_por_puesto' => strtr( mb_strtoupper( $historicoDigitalizacionEncontrado->created_by_title ), $remplazar),
                            'created_at' => $historicoDigitalizacionEncontrado->created_on,
                            'updated_at' => $historicoDigitalizacionEncontrado->last_modified
                        ]);
                        
                    }
/*
                    if ( !is_null($registroCreado->folio) ) {
                        $historicoDetalles = HistoricoP23DetalleDigitalizacion::where('folio', $registroCreado->folio)->orderByDesc('last_modified')->first();

                        P23DetalleDigitalizacion::create([
                            'p23_digitalizacion_id' => $registroCreado->p23_digitalizacion_id,
                            'folio' => $registroCreado->folio ?? null,
                            'documento' => $historicoDetalles->documento ?? null,
                            'hojas' => $historicoDetalles->hojas ?? null,
                            'creado_por' => $historicoDetalles->created_by ?? null,
                            'creado_por_nombre' => $historicoDetalles->created_by_cn ?? null,
                            'creado_por_puesto' => $historicoDetalles->created_by_title ?? null,
                            'area_creadora_id' => $area->area_id,
                            'created_at' => $historicoDetalles->created_on ?? null,
                            'updated_at' => $historicoDetalles->last_modified ?? null
                        ]);

                    }
*/
                }
            }
        }
    }
}
