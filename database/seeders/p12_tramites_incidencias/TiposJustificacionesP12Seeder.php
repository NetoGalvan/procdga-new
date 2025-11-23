<?php

namespace Database\Seeders\p12_tramites_incidencias;

use App\Models\p12_tramites_incidencias\TipoJustificacion;
use Illuminate\Database\Seeder;

class TiposJustificacionesP12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoJustificacion::create(['nombre' => 'BAJA', 'descripcion' =>'BAJA', 'identificador' => "baja"]);
        TipoJustificacion::create(['nombre' => 'CAMBIO DE HORARIO', 'descripcion' => 'CAMBIO DE HORARIO', 'identificador' => "cambio_horario"]);
        TipoJustificacion::create(['nombre' => 'COMISIÓN OFICIAL', 'descripcion' => 'COMISIÓN OFICIAL', 'identificador' => "comision_oficial"]);
        TipoJustificacion::create(['nombre' => 'COMISIÓN SINDICAL', 'descripcion' => 'COMISIÓN SINDICAL', 'identificador' => "comision_sindical"]);
        TipoJustificacion::create(['nombre' => 'CUIDADO MATERNO', 'descripcion' => 'CUIDADO MATERNO', 'identificador' => "cuidado_materno"]);
        TipoJustificacion::create(['nombre' => 'DEFUNCIÓN', 'descripcion' => 'DEFUNCIÓN', 'identificador' => "defuncion"]);
        TipoJustificacion::create(['nombre' => 'DIA SINDICAL', 'descripcion' => 'DIA SINDICAL', 'identificador' => "dia_sindical"]);
        TipoJustificacion::create(['nombre' => 'EXCENCION DE REGISTRO DE ASISTENCIA', 'descripcion' => 'EXCENCION DE REGISTRO DE ASISTENCIA', 'identificador' => "excencion_registro_asistencia"]);
        TipoJustificacion::create(['nombre' => 'HORARIO ESPECIAL EVENTOS Y ESPECTÁCULOS', 'descripcion' => 'HORARIO ESPECIAL EVENTOS Y ESPECTÁCULOS', 'identificador' => "horario_especial_eventos"]);
        TipoJustificacion::create(['nombre' => 'INCIDENCIA DRH', 'descripcion' => 'INCIDENCIA DRH', 'identificador' => "incidencia_drh"]);
        TipoJustificacion::create(['nombre' => 'LICENCIA MÉDICA', 'descripcion' => 'LICENCIA MÉDICA', 'identificador' => "licencia_medica"]);
        TipoJustificacion::create(['nombre' => 'LICENCIAS CON SUELDO', 'descripcion' => 'LICENCIAS CON SUELDO', 'identificador' => "licencia_con_sueldo"]);
        TipoJustificacion::create(['nombre' => 'LICENCIAS SIN SUELDO', 'descripcion' => 'LICENCIAS SIN SUELDO', 'identificador' => "licencia_sin_sueldo"]);
        TipoJustificacion::create(['nombre' => 'LISTA DE ASISTENCIA', 'descripcion' => 'LISTA DE ASISTENCIA', 'identificador' => "lista_asistencia"]);
        TipoJustificacion::create(['nombre' => 'MATERNIDAD', 'descripcion' => 'MATERNIDAD', 'identificador' => "maternidad"]);
        TipoJustificacion::create(['nombre' => 'NOTA BUENA - INASISTENCIA', 'descripcion' => 'NOTA BUENA - INASISTENCIA', 'identificador' => "nota_buena_inasistencia"]);
        TipoJustificacion::create(['nombre' => 'NOTA BUENA - RETARDO GRAVE', 'descripcion' => 'NOTA BUENA - RETARDO GRAVE', 'identificador' => "nota_buena_retardo_grave"]);
        TipoJustificacion::create(['nombre' => 'NOTA BUENA - RETARDO LEVE', 'descripcion' => 'NOTA BUENA - RETARDO LEVE', 'identificador' => "nota_buena_retardo_leve"]);
        TipoJustificacion::create(['nombre' => 'OFICIO', 'descripcion' => 'OFICIO', 'identificador' => "oficio"]);
        TipoJustificacion::create(['nombre' => 'OMISIÓN', 'descripcion' => 'OMISIÓN', 'identificador' => "omision"]);
        TipoJustificacion::create(['nombre' => 'OTRA', 'descripcion' => 'OTRA', 'identificador' => "otra"]);
        TipoJustificacion::create(['nombre' => 'RELOJ DESCOMPUESTO', 'descripcion' => 'RELOJ DESCOMPUESTO', 'identificador' => "reloj_descompuesto"]);
        TipoJustificacion::create(['nombre' => 'SUSPENSIÓN POR NOMBRAMIENTO', 'descripcion' => 'SUSPENSIÓN POR NOMBRAMIENTO', 'identificador' => "suspension_por_nombramiento"]);
        TipoJustificacion::create(['nombre' => 'SUSPENSIONES', 'descripcion' => 'SUSPENSIONES', 'identificador' => "suspensiones"]);
        TipoJustificacion::create(['nombre' => 'TOLERANCIA', 'descripcion' => 'TOLERANCIA', 'identificador' => "tolerancia"]);
        TipoJustificacion::create(['nombre' => 'VACACIONES', 'descripcion' => 'VACACIONES', 'identificador' => "vacaciones"]);
    }
}
