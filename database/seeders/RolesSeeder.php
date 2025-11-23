<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'SUPER_ADMIN',
            'label'=> 'SUPER_ADMIN',
            'descripcion' =>  'Realiza cualquier acción dentro del sistema',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'EMPLEADO_GRAL',
            'label'=> 'EMPLEADO_GRAL',
            'descripcion' => 'Usa los autoprocesos del sistema procdga',
            'tipo' => 'USUARIO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'SUB_EA',
            'label'=> 'SUB_EA',
            'descripcion' => 'Responsabilidad de iniciar y dar seguimiento a tareas específicas de los procesos',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'TITULAR_EA',
            'label'=> 'TITULAR_EA',
            'descripcion' => 'Autoriza procesos iniciados por el EA',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'COO_EVAL',
            'label'=> 'COO_EVAL',
            'descripcion' => 'Evalúa a los candidatos a técnico operativo',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_MP',
            'label'=> 'JUD_MP',
            'descripcion' => 'Envío de documentos al SUN para las altas, bajas y reanudaciones del personal',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'DGA',
            'label'=> 'DGA',
            'descripcion' => 'Autoriza movimientos de personal',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_PRES',
            'label'=> 'JUD_PRES',
            'descripcion' => 'Jefe de Unidad Departamental del Área de Prestaciones',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'DRH',
            'label'=> 'DRH',
            'descripcion' => 'Encargado de autorizar las hojas de servicio y comprobantes de servicio',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'INI_JUST',
            'label'=> 'INI_JUST',
            'descripcion' => 'Encargado de generar las incidencias para los empleados.',
            'tipo' => 'AREA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'CTRL_KDX',
            'label'=> 'CTRL_KDX',
            'descripcion' => 'Encargado de llevar el contro del Kardex en la Unidad Departamental de Prestaciones.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'CAPT_KDX',
            'label'=> 'CAPT_KDX',
            'descripcion' => 'Encargado de llevar a cabo la captura de incidencias en el Kardex.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'KARDEX',
            'label'=> 'KARDEX',
            'descripcion' => 'Encargado de generar las hojas de servicio y comprobantes de servicio',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'QA_KDX',
            'label'=> 'QA_KDX',
            'descripcion' => 'Encargado de llevar el control de calidad de las capturas en el Kardex.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'ADMIN_ALFA',
            'label'=> 'ADMIN_ALFA',
            'descripcion' => 'Responsable de iniciar el proceso y hacer la carga del listado ALFABÉTICO de cada quincena.',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'ADMIN_PLAZAS',
            'label'=> 'ADMIN_PLAZAS',
            'descripcion' => 'Encargada de la Administración de plazas adscritas a la Secretaría de Finanzas.',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'PROG_SS',
            'label'=> 'PROG_SS',
            'descripcion' => 'Encargado de todo lo referente al Servicio Social y Practicas Profesionales.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'AUTORIZADOR_CARTA_INICIO_SS',
            'label'=> 'AUTORIZADOR_CARTA_INICIO_SS',
            'descripcion' => 'Encargado de firmar las cartas de inicio.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'AUTORIZADOR_CARTA_TERMINO_SS',
            'label'=> 'AUTORIZADOR_CARTA_TERMINO_SS',
            'descripcion' => 'Encargado de firmar las cartas de termino.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'ADMIN_PREMIO_PUNTUALIDAD',
            'label'=> 'ADMIN_PREMIO_PUNTUALIDAD',
            'descripcion' => 'Responsable de iniciar el proceso de premio de puntualidad y asistencia para cada unidad administrativa.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'ENLACE_PREMIO_PUNTUALIDAD',
            'label'=> 'ENLACE_PREMIO_PUNTUALIDAD',
            'descripcion' => 'Responsabilidad de iniciar y dar seguimiento a tareas específicas de los procesos',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'OPER_PREMIO_PUNTUALIDAD',
            'label'=> 'OPER_PREMIO_PUNTUALIDAD',
            'descripcion' => 'Responsable de agregar y evaluar a los empleados solicitantes del premio.',
            'tipo' => 'AREA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'ADMN_PA_21',
            'label'=> 'ADMN_PA_21',
            'descripcion' => 'Responsable de iniciar el proceso, lanzar la convocatoria para que los operadores del premio registren a todos aquellos empleados que quieran partcipar asignar junto con el comité evaluación.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'AUTZ_PA_21',
            'label'=> 'AUTZ_PA_21',
            'descripcion' => 'Responsable de autorizar y concentrar cada una de las solicitudes capturadas por el operador del premio de administración.',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'OPER_PA_21',
            'label'=> 'OPER_PA_21',
            'descripcion' => 'Responsable de atender a los empleados que soliciten su evaluación para la partcipación en el proceso,capturar la evaluación de desempeño y cursos tomados por el empleado.',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'OPER_CAP_21',
            'label'=> 'OPER_CAP_21',
            'descripcion' => 'Responsable de validar los cursos de capacitación que el empleado a incluido en el formato de capacitación y conocimiento del puesto.',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'ADMN_REP_22',
            'label'=> 'ADMN_REP_22',
            'descripcion' => 'Responsable de seleccionar el tipo de reporte y el periodo de evaluación.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'OPER_DIG_23',
            'label'=> 'OPER_DIG_23',
            'descripcion' => 'Es el responsable de todas las tareas de generación de ficha de expediante, carga y actualización de expediente digital.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'INI_EXP_23',
            'label'=> 'INI_EXP_23',
            'descripcion' => 'Responsable de iniciar la solicitud de préstamo de un expediente.',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'CTRL_EXP_23',
            'label'=> 'CTRL_EXP_23',
            'descripcion' => 'Responsable de autorizar o rechazar la solicitud de un expediente.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'OPER_EXP_23',
            'label'=> 'OPER_EXP_23',
            'descripcion' => 'Responsable de preparar los expedientes y atender la solicitudes de préstamo.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JO_PRES',
            'label'=> 'JO_PRES',
            'descripcion' => 'Responsable del area de Recursos Humanos',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_RH',
            'label'=> 'JUD_RH',
            'descripcion' => 'Responsable del area de Recursos Humanos',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'SUB_PRES',
            'label'=> 'SUB_PRES',
            'descripcion' => 'Responsable del area de Recursos Humanos',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_RM',
            'label'=> 'JUD_RM',
            'descripcion' => 'Jefe de Unidad Departamental de Recursos Materiales en cada una de las unidades administrativas.',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_MTTO',
            'label'=> 'JUD_MTTO',
            'descripcion' => 'Jefe de Unidad Departamental de Mantenimiento.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_TELEFONIA',
            'label'=> 'JUD_TELEFONIA',
            'descripcion' => 'Jefe de Unidad Departamental de Telefonía.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_TRANSPORTE',
            'label'=> 'JUD_TRANSPORTE',
            'descripcion' => 'Jefe de Unidad Departamental de Transporte.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_IMPRE',
            'label'=> 'JUD_IMPRE',
            'descripcion' => 'Jefe de Unidad Departamental de Impresiones.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'JUD_LIMPIEZA',
            'label'=> 'JUD_LIMPIEZA',
            'descripcion' => 'Jefe de Unidad Departamental de Limpieza y Estibas.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'INI_CAND',
            'label'=> 'INI_CAND',
            'descripcion' => 'Responsable de iniciar y dar seguimiento a tareas',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'EVAL',
            'label'=> 'EVAL',
            'descripcion' => 'Evaluador de candidatos estructura',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'SRIO_FZAS',
            'label'=> 'SRIO_FZAS',
            'descripcion' => 'Autorizador de candidatos estructura',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'SUB_CONS',
            'label'=> 'SUB_CONS',
            'descripcion' => 'Subdirector de Conservación y Mantenimiento.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'ADMN_INC_19',
            'label'=> 'ADMN_INC_19',
            'descripcion' => 'Responsable de iniciar el proceso incentivo empleado.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'OPER_INC_19',
            'label'=> 'OPER_INC_19',
            'descripcion' => 'Responsable de agregar y evaluar a los empleados solicitantes del premio.',
            'tipo' => 'AREA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'ADMIN_TEXT',
            'label'=> 'ADMIN_TEXT',
            'descripcion' => 'Responsable de agregar y evaluar a los empleados solicitantes del premio.',
            'tipo' => 'AREA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'CONTROL_ASISTENCIA',
            'label'=> 'CONTROL_ASISTENCIA',
            'descripcion' =>  '',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'ADMIN_TIEMPO_EXTRA',
            'label'=> 'ADMIN_TIEMPO_EXTRA',
            'descripcion' => 'Jefe de Unidad Departamental de Nóminas.',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'OPER_TIEMPO_EXTRA',
            'label'=> 'OPER_TIEMPO_EXTRA',
            'descripcion' => 'Sub enlace de asignación de horas por empleado',
            'tipo' => 'AREA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'ENLACE_CAPTURA_VIATICO',
            'label'=> 'ENLACE_CAPTURA_VIATICO',
            'descripcion' =>  'Captura/crea un viático de su dependencia',
            'tipo' => 'AREA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'TITULAR_ORGANO',
            'label'=> 'TITULAR_ORGANO',
            'descripcion' => 'Revisa y firma viáticos de su dependencia',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'TITULAR_ADMINISTRACION',
            'label'=> 'TITULAR_ADMINISTRACION',
            'descripcion' =>  'Revisa y firma la solicitudes de viáticos',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'AUTORIZADOR_VIATICO',
            'label'=> 'AUTORIZADOR_VIATICO',
            'descripcion' =>  'Revisa, firma y autoriza o rechaza viáticos de todas las dependencias',
            'tipo' => 'GOBIERNO',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'CAPTURA_KARDEX',
            'label'=> 'CAPTURA_KARDEX',
            'descripcion' =>  'Inicia y selecciona el tramite kardex a llevar a cabo',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'ADMIN_KARDEX',
            'label'=> 'ADMIN_KARDEX',
            'descripcion' =>  'Asigna el tramite al usuario que llevara a cabo la captura de información',
            'tipo' => 'DEPENDENCIA',
            'cantidad_usuarios' => 1
        ]);
        Role::create([
            'name' => 'TECNICO_OPERATIVO_KARDEX',
            'label'=> 'TECNICO_OPERATIVO_KARDEX',
            'descripcion' =>  'Captura la información de tramite que tiene asignado',
            'tipo' => 'USUARIO',
            'cantidad_usuarios' => null
        ]);
        Role::create([
            'name' => 'ENLACE_TIEMPO_EXTRA',
            'label'=> 'ENLACE_TIEMPO_EXTRA',
            'descripcion' => 'Responsabilidad de iniciar y dar seguimiento a tareas específicas de los procesos',
            'tipo' => 'AREA_PRINCIPAL',
            'cantidad_usuarios' => 1
        ]);
    }
}
