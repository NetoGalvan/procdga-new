<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMINISTRADOR
        $user = User::create([
            'nombre' => 'ADMINISTRADOR',
            'apellido_paterno' => '',
            'apellido_materno' => '',
            'email' => 'admin@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'admin',
            'numero_empleado' => 1103721,
            'rfc' => 'GAPJ9502229VA',
            'curp' => 'GAPJ950222HDFRMR01',
            'puesto' => 'ADMINISTRADOR DEL SISTEMA PROCDGA',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUPER_ADMIN');

        // P01 - MOVIMIENTOS PERSONAL

        // SUB_EA
        $user = User::create([
            'nombre' => 'DANIEL',
            'apellido_paterno' => 'GUDIÑO',
            'apellido_materno' => 'MARTINEZ',
            'email' => 'daniel.gudiño@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'DDDD0000009VA',
            'numero_empleado' => 321652,
            'rfc' => 'DDDD0000009VA',
            'curp' => 'DDDD000000HDFRSS01',
            'puesto' => 'SUBDIRECTOR DE ENLACE ADMINISTRATIVO DIRECCIÓN GENERAL DE TECNOLOGÍAS Y COMUNICACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');
        /* $user->assignRole('INI_CAND'); */

        // TITULAR_EA
        $user = User::create([
            'nombre' => 'ERNESTO',
            'apellido_paterno' => 'CHAVEZ',
            'apellido_materno' => 'ZAMUDIO',
            'email' => 'ernesto.chavez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'EEEE0000009VA',
            'numero_empleado' => 321653,
            'rfc' => 'EEEE0000009VA',
            'curp' => 'EEEE000000HDFRSS01',
            'puesto' => 'TITULAR DE ENLACE ADMINISTRATIVO DIRECCIÓN GENERAL DE TECNOLOGÍAS Y COMUNICACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TITULAR_EA');

        // SUB_EA
        $user = User::create([
            'nombre' => 'EDUARDO',
            'apellido_paterno' => 'CHAVEZ',
            'apellido_materno' => 'DIAZ',
            'email' => 'eduardo.chavez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'ECDD0000009VA',
            'numero_empleado' => 321654,
            'rfc' => 'ECDD0000009VA',
            'curp' => 'ECDD000000HDFRSS01',
            'puesto' => 'SUBDIRECTOR DE ENLACE ADMINISTRATIVO UNIDAD DE INTELIGENCIA FINANCIERA EN EL D.F.',
            'area_id' => Area::select('area_id')->where('identificador', '139')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');
        /* $user->assignRole('INI_CAND'); */

        // TITULAR_EA
        $user = User::create([
            'nombre' => 'ERWIN',
            'apellido_paterno' => 'MORALES',
            'apellido_materno' => 'MARTINEZ',
            'email' => 'erwin.morales@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'EMMZ0000009VA',
            'numero_empleado' => 321655,
            'rfc' => 'EMMZ0000009VA',
            'curp' => 'EMMZ000000HDFRSS01',
            'puesto' => 'TITULAR DE ENLACE ADMINISTRATIVO UNIDAD DE INTELIGENCIA FINANCIERA EN EL D.F.',
            'area_id' => Area::select('area_id')->where('identificador', '139')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TITULAR_EA');

        // COO_EVAL
        $user = User::create([
            'nombre' => 'ANTONIO',
            'apellido_paterno' => 'SANCHEZ',
            'apellido_materno' => 'SANCHEZ',
            'email' => 'antonio.sanchez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'ASSE0000009VA',
            'numero_empleado' => 321657,
            'rfc' => 'ASSE0000009VA',
            'curp' => 'ASSE000000HDFRSS01',
            'puesto' => 'COORDINADOR DE EVALUACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('COO_EVAL');

        // JUD_MP
        $user = User::create([
            'nombre' => 'IVAN',
            'apellido_paterno' => 'GARCIA',
            'apellido_materno' => '',
            'email' => 'ivan.garcia@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'IGGI0000009VA',
            'numero_empleado' => 321658,
            'rfc' => 'IGGI0000009VA',
            'curp' => 'IGGI000000HDFRSS01',
            'puesto' => 'JUD DE MOVIMIENTOS DE PERSONAL',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_MP');

        // DGA
        $user = User::create([
            'nombre' => 'JESUS',
            'apellido_paterno' => 'JOLALPA',
            'apellido_materno' => 'MORALES',
            'email' => 'jesus.jolalpa@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'JJMZ0000009VA',
            'numero_empleado' => 321659,
            'rfc' => 'JJMZ0000009VA',
            'curp' => 'JJMZ000000HDFRSS01',
            'puesto' => 'DIRECTOR GENERAL DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('DGA');

        // P02 - TRÁMITES ISSSTE

        $user = User::create([
            'nombre' => 'ERASMO',
            'apellido_paterno' => 'FERRERO',
            'apellido_materno' => 'MONTENEGRO',
            'email' => 'erasmo.ferrero@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'EFMO0000008SA',
            'numero_empleado' => 21530,
            'rfc' => 'EFMO0000008SA',
            'curp' => 'EFMO000000HDFRSS01',
            'puesto' => 'SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true,
        ]);
        $user->assignRole('JUD_PRES');
        /* $user->assignRole('ADMN_INC_19'); */

        // P03 - HOJAS DE SERVICIO Y P04 - COMPROBANTES DE SERVICIO

        // SE USA UN JUD_PRES, PERO YA SE AGREGO UNO PARA EL AREA 137 EN EL P07
        $user = User::create([
            'nombre' => 'HELGA',
            'apellido_paterno' => 'ESPINOZA',
            'apellido_materno' => 'LOPEZ',
            'email' => 'helga.espinoza@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121111',
            'nombre_usuario' => 'ELHP000000ET0',
            'rfc' => 'ELHP000000ET0',
            'curp' => 'ELHP000000HDFRSN37',
            'puesto' => 'ENCARGADA DE LA JEFATURA DE OFICINA DE JUBILACIONES, KARDEX Y HOJAS DE SERVICIO',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('KARDEX');

        $user = User::create([
            'nombre' => 'CARMEN',
            'apellido_paterno' => 'ZAPATA',
            'apellido_materno' => 'DIRECT',
            'email' => 'carmen.zapata.direct@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121112',
            'nombre_usuario' => 'ZDAP000000ET0',
            'rfc' => 'ZDAP000000ET0',
            'curp' => 'ZDAP000000HDFRSN37',
            'puesto' => 'DIRECTOR DE RECURSOS HUMANOS',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('DRH');

        // PARA PRUEBAS
        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'KARDEX',
            'apellido_materno' => 'PRUEBA',
            'email' => 'usuario.kardex@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121113',
            'nombre_usuario' => 'KPUP000000ET0',
            'rfc' => 'KPUP000000ET0',
            'curp' => 'KPUP000000HDFRSN37',
            'puesto' => 'ENCARGADA DE LA JEFATURA DE OFICINA DE JUBILACIONES, KARDEX Y HOJAS DE SERVICIO',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('KARDEX');

        // P06 - SERVICIO SOCIAL
        // Usuario de PROG_SS tiene que pertenecer a esta área, porque hay tareas especificamente para ella.
        $user = User::create([
            'nombre' => 'GABRIELA',
            'apellido_paterno' => 'ARREDONDO',
            'apellido_materno' => 'ARREDONDO',
            'email' => 'gabriela.arredondo.arredondo@finanzas.cdmx.gob.mx',
            'numero_empleado' => '78965412',
            'nombre_usuario' => 'ARAG0000007WA',
            'rfc' => 'ARAG0000007WA',
            'curp' => 'ARAG000000HMCMRD07',
            'puesto' => 'ENCARGADA DE LO REFERENTE AL SERVICIO SOCIAL',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('PROG_SS');

        $user = User::create([
            'nombre' => 'ITZEL',
            'apellido_paterno' => 'RAMIREZ',
            'apellido_materno' => 'RAMIREZ',
            'email' => 'itzel.ramirez.ramirez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25896312',
            'nombre_usuario' => 'RARI0000007WA',
            'rfc' => 'RARI0000007WA',
            'curp' => 'RARI000000HMCMRD07',
            'puesto' => 'ENCARGADA DE LO REFERENTE AL SERVICIO SOCIAL',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');

        $user = User::create([
            'nombre' => 'CARLOS',
            'apellido_paterno' => 'URBINA',
            'apellido_materno' => 'TELLO',
            'email' => 'carlos.urbina.tello@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25412596',
            'nombre_usuario' => 'URTC0000007WA',
            'rfc' => 'URTC0000007WA',
            'curp' => 'URTC000000HMCMRD07',
            'puesto' => 'DIRECTOR DE ADMINISTRACIÓN DE CAPITAL HUMANO ',
            'area_id' => Area::select('area_id')->where('identificador', '95.1')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('AUTORIZADOR_CARTA_INICIO_SS');
        $user->assignRole('AUTORIZADOR_CARTA_TERMINO_SS');

        // USUARIOS PARA ENTREGAR Y QUE HAGAN PRUEBAS
        $user = User::create([
            'nombre' => 'JUAN',
            'apellido_paterno' => 'VAZQUEZ',
            'apellido_materno' => 'TORRALBA',
            'email' => 'juan.vazquez.torralba@finanzas.cdmx.gob.mx',
            'numero_empleado' => '14522563',
            'nombre_usuario' => 'TOVJ0000007WA',
            'rfc' => 'TOVJ0000007WA',
            'curp' => 'TOVJ000000HMCMRD07',
            'puesto' => 'ENCARGADO DE LO REFERENTE AL SERVICIO SOCIAL',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('PROG_SS');

        $user = User::create([
            'nombre' => 'CINTHYA PAOLA',
            'apellido_paterno' => 'CABRERA',
            'apellido_materno' => 'HERNANDEZ',
            'email' => 'cinthya.cabrera.hernandez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '52364485',
            'nombre_usuario' => 'CAHC0000007WA',
            'rfc' => 'CAHC0000007WA',
            'curp' => 'CAHC000000HMCMRD07',
            'puesto' => 'ENCARGADA DE LO REFERENTE AL SERVICIO SOCIAL',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');
        $user->assignRole('ENLACE_TIEMPO_EXTRA');
        $user->assignRole('ENLACE_PREMIO_PUNTUALIDAD');

        // P07 - PAGO DE PRESTACIONES

        // PROCESO 07
        // SE USA UN SUB_EA, EN ST02 PERO YA SE AGREGARON PARA EL ÁREA 137 Y PARA EL ÁREA 11 EN EL P08
        $user = User::create([
            'nombre' => 'NOE',
            'apellido_paterno' => 'MARTINEZ',
            'apellido_materno' => 'RODRIGUEZ',
            'email' => 'noe.martinez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121114',
            'nombre_usuario' => 'MRNP000000ET0',
            'rfc' => 'MRNP000000ET0',
            'curp' => 'MRNP000000HDFRSN37',
            'puesto' => 'JEFE DE OFICINAS DE PRESTACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JO_PRES');

        $user = User::create([
            'nombre' => 'ANGEL',
            'apellido_paterno' => 'CASTRO',
            'apellido_materno' => 'LOPETTEGUI',
            'email' => 'angel.castro@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121115',
            'nombre_usuario' => 'CLAP000000ET0',
            'rfc' => 'CLAP000000ET0',
            'curp' => 'CLAP000000HDFRSN37',
            'puesto' => 'JUD DE RECURSOS HUMANOS 137',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RH');

        $user = User::create([
            'nombre' => 'MIRNA',
            'apellido_paterno' => 'SAGUERO',
            'apellido_materno' => 'HANG',
            'email' => 'mirna.saguero@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121116',
            'nombre_usuario' => 'SHMP000000ET0',
            'rfc' => 'SHMP000000ET0',
            'curp' => 'SHMP000000HDFRSN37',
            'puesto' => 'JUD DE RECURSOS HUMANOS 11',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RH');

        $user = User::create([
            'nombre' => 'TANIA',
            'apellido_paterno' => 'MESA',
            'apellido_materno' => 'ROSALES',
            'email' => 'tania.meza@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121117',
            'nombre_usuario' => 'MRTP000000ET0',
            'rfc' => 'MRTP000000ET0',
            'curp' => 'MRTP000000HDFRSN37',
            'puesto' => 'JUD DE PRESTACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_PRES');

        $user = User::create([
            'nombre' => 'JOSE',
            'apellido_paterno' => 'SANCHEZ',
            'apellido_materno' => 'CRUZ',
            'email' => 'jose.sanchez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121118',
            'nombre_usuario' => 'SCJP000000ET0',
            'rfc' => 'SCJP000000ET0',
            'curp' => 'SCJP000000HDFRSN37',
            'puesto' => 'SUBDIRECTOR DE PRESTACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_PRES');

        // PARA PRUEBAS
        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JEFE',
            'apellido_materno' => 'PRESTACIONES',
            'email' => 'usuario.jefe.oficinas.prestaciones@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121119',
            'nombre_usuario' => 'JPUP000000ET0',
            'rfc' => 'JPUP000000ET0',
            'curp' => 'JPUP000000HDFRSN37',
            'puesto' => 'JEFE DE OFICINAS DE PRESTACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JO_PRES');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'RH P07 11',
            'email' => 'usuario.jud.recursos.humanos.p07.11@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121110',
            'nombre_usuario' => 'JRHU000000ET1',
            'rfc' => 'JRHU000000ET1',
            'curp' => 'JRHU000000HDFRSN11',
            'puesto' => 'JUD DE RECURSOS HUMANOS 11',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RH');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'RH P07 138',
            'email' => 'usuario.jud.recursos.humanos.p07.138@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121121',
            'nombre_usuario' => 'JRHU000000ET8',
            'rfc' => 'JRHU000000ET8',
            'curp' => 'JRHU000000HDFRSN38',
            'puesto' => 'JUD DE RECURSOS HUMANOS 138',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RH');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'SUB_EA',
            'apellido_materno' => 'P07',
            'email' => 'usuario.sub.ea.p07.11@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121131',
            'nombre_usuario' => 'SUPU000000ET7',
            'rfc' => 'SUPU000000ET7',
            'curp' => 'SUPU000000HDFRSN37',
            'puesto' => 'SUB ENLACE ADMINISTRARTIVO P07',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'PRES P07',
            'email' => 'usuario.jud.pres.p07@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121141',
            'nombre_usuario' => 'JUPU000000ET7',
            'rfc' => 'JUPU000000ET7',
            'curp' => 'JUPU000000HDFRSN37',
            'puesto' => 'JUD DE PRESTACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_PRES');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'SUB',
            'apellido_materno' => 'PRES P07',
            'email' => 'usuario.sub.pres.p07@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121151',
            'nombre_usuario' => 'SPRU000000ET7',
            'rfc' => 'SPRU000000ET7',
            'curp' => 'SPRU000000HDFRSN37',
            'puesto' => 'SUBDIRECTOR DE PRESTACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_PRES');

        // P08 - SOLICITA SERVICIOS

        $user = User::create([
            'nombre' => 'ALEJANDRO',
            'apellido_paterno' => 'RAMIREZ',
            'apellido_materno' => 'COLMENARES',
            'email' => 'alejandro.ramirez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121161',
            'nombre_usuario' => 'RCAP000000ET0',
            'rfc' => 'RCAP000000ET0',
            'curp' => 'RCAP000000HDFRSN37',
            'puesto' => 'ENLACE ADMINISTRATIVO',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RM');

        $user = User::create([
            'nombre' => 'EDGAR',
            'apellido_paterno' => 'LÓPEZ',
            'apellido_materno' => 'HERNÁNDEZ',
            'email' => 'edgar.lopez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121171',
            'nombre_usuario' => 'LHEP000000ET0',
            'rfc' => 'LHEP000000ET0',
            'curp' => 'LHEP000000HDFRSN37',
            'puesto' => 'JUD DE MANTENIMIENTO',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_MTTO');

        $user = User::create([
            'nombre' => 'PAOLA',
            'apellido_paterno' => 'ALVARADO',
            'apellido_materno' => 'CARRILLO DE ALBORNOZ',
            'email' => 'paola.alvarado@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121181',
            'nombre_usuario' => 'ACPP000000ET0',
            'rfc' => 'ACPP000000ET0',
            'curp' => 'ACPP000000HDFRSN37',
            'puesto' => 'JUD DE SERVICIOS TELEFÓNICOS',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_TELEFONIA');

        $user = User::create([
            'nombre' => 'ALEXANDRE',
            'apellido_paterno' => 'RUIZ',
            'apellido_materno' => 'GOMEZ',
            'email' => 'alex.ruiz@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121191',
            'nombre_usuario' => 'RGAP000000ET0',
            'rfc' => 'RGAP000000ET0',
            'curp' => 'RGAP000000HDFRSN37',
            'puesto' => 'JUD DE LIMPIEZA',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_LIMPIEZA');

        $user = User::create([
            'nombre' => 'JUAN MANUEL',
            'apellido_paterno' => 'AGUIRRE',
            'apellido_materno' => 'GALLEGOS',
            'email' => 'juanm.aguirre@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121101',
            'nombre_usuario' => 'AGJP000000ET0',
            'rfc' => 'AGJP000000ET0',
            'curp' => 'AGJP000000HDFRSN37',
            'puesto' => 'SUBDIRECTOR DE CONSERVACIÓN Y MANTENIMIENTO',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_CONS');

        $user = User::create([
            'nombre' => 'RAUL',
            'apellido_paterno' => 'CORTES',
            'apellido_materno' => 'TAPIA',
            'email' => 'raul.cortes@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121211',
            'nombre_usuario' => 'CTRP000000ET0',
            'rfc' => 'CTRP000000ET0',
            'curp' => 'CTRP000000HDFRSN37',
            'puesto' => 'JUD DE TRANSPORTE',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_TRANSPORTE');

        $user = User::create([
            'nombre' => 'ALFREDO',
            'apellido_paterno' => 'BANDERAS',
            'apellido_materno' => 'RIVERA',
            'email' => 'alfredo.banderas@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121311',
            'nombre_usuario' => 'BRAP000000ET0',
            'rfc' => 'BRAP000000ET0',
            'curp' => 'BRAP000000HDFRSN37',
            'puesto' => 'JUD DE IMPRESIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_IMPRE');

        $user = User::create([
            'nombre' => 'GUADALUPE',
            'apellido_paterno' => 'GOMEZ',
            'apellido_materno' => 'GOMEZ',
            'email' => 'guadalupe.gomez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121411',
            'nombre_usuario' => 'GGGP000000ET0',
            'rfc' => 'GGGP000000ET0',
            'curp' => 'GGGP000000HDFRSN37',
            'puesto' => 'SUBDIRECTOR DE ENLACE ADMINISTRATIVO',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');

        // PARA PRUEBAS
        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'RECURSOS MATERIALES',
            'email' => 'usuario.jud.recursos.materiales@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121511',
            'nombre_usuario' => 'JRMP000000ET0',
            'rfc' => 'JRMP000000ET0',
            'curp' => 'JRMP000000HDFRSN37',
            'puesto' => 'ENLACE ADMINISTRATIVO',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RM');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'MANTENIMIENTO',
            'email' => 'usuario.jud.mantenimiento@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121611',
            'nombre_usuario' => 'JMUP000000ET0',
            'rfc' => 'JMUP000000ET0',
            'curp' => 'JMUP000000HDFRSN37',
            'puesto' => 'JUD DE MANTENIMIENTO',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_MTTO');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'TELEFONIA',
            'email' => 'usuario.jud.telefonia@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121711',
            'nombre_usuario' => 'JTUP000000ET0',
            'rfc' => 'JTUP000000ET0',
            'curp' => 'JTUP000000HDFRSN37',
            'puesto' => 'JUD DE SERVICIOS TELEFÓNICOS',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_TELEFONIA');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'LIMPIEZA',
            'email' => 'usuario.jud.limpieza@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121811',
            'nombre_usuario' => 'JLUP000000ET0',
            'rfc' => 'JLUP000000ET0',
            'curp' => 'JLUP000000HDFRSN37',
            'puesto' => 'JUD DE LIMPIEZA',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_LIMPIEZA');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'TRANSPORTE',
            'email' => 'usuario.jud.transporte@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121911',
            'nombre_usuario' => 'JVUP000000ET0',
            'rfc' => 'JVUP000000ET0',
            'curp' => 'JVUP000000HDFRSN37',
            'puesto' => 'JUD DE TRANSPORTE',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_TRANSPORTE');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'JUD',
            'apellido_materno' => 'IMPRESIONES',
            'email' => 'usuario.jud.impresiones@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22121011',
            'nombre_usuario' => 'JIUP000000ET0',
            'rfc' => 'JIUP000000ET0',
            'curp' => 'JIUP000000HDFRSN37',
            'puesto' => 'JUD DE IMPRESIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_IMPRE');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'ADMINP08',
            'email' => 'usuario.enlace.admin.p08@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122111',
            'nombre_usuario' => 'EAUP000000ET8',
            'rfc' => 'EAUP000000ET8',
            'curp' => 'EAUP000000HDFRSN38',
            'puesto' => 'SUBDIRECTOR DE ENLACE ADMINISTRATIVO',
            'area_id' => Area::select('area_id')->where('identificador', '11.5')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ENLACE_TIEMPO_EXTRA');
        $user->assignRole('ENLACE_PREMIO_PUNTUALIDAD');
        $user->assignRole('SUB_EA');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'SUB',
            'apellido_materno' => 'CONS',
            'email' => 'usuario.sub.cons@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22123111',
            'nombre_usuario' => 'SCUP000000ET0',
            'rfc' => 'SCUP000000ET0',
            'curp' => 'SCUP000000HDFRSN37',
            'puesto' => 'SUBDIRECTOR DE CONSERVACIÓN Y MANTENIMIENTO',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_CONS');

        // P11 - SELECCIÓN DE CANDIDATOS

        $user = User::create([
            'nombre' => 'MILAN',
            'apellido_paterno' => 'GARCIA',
            'apellido_materno' => 'MARTINEZ',
            'email' => 'milan.garcia@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22896111',
            'nombre_usuario' => 'SCUP11110ET0',
            'rfc' => 'SCUP11110ET0',
            'curp' => 'SCUP111111HDFRSN85',
            'puesto' => 'SUBDIRECTOR',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SRIO_FZAS');

        $user = User::create([
            'nombre' => 'ALAN',
            'apellido_paterno' => 'QUINTERO',
            'apellido_materno' => 'MACHA',
            'email' => 'alan.quintero@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22784111',
            'nombre_usuario' => 'QUAL11110ET0',
            'rfc' => 'QUAL11110ET0',
            'curp' => 'QUAL111111HDFRSN85',
            'puesto' => 'SUBDIRECTOR ADJUNTO',
            'area_id' => Area::select('area_id')->where('identificador', '999.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('EVAL');

        // P12 - INCIDENCIAS

        $user = User::create([
            'nombre' => 'JAVIER',
            'apellido_paterno' => 'MARTINEZ',
            'apellido_materno' => '',
            'email' => 'jmartinez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'DOME9602177WA',
            'numero_empleado' => 1103726,
            'rfc' => 'DOME9602177WA',
            'curp' => 'DOME960217HDFRSS01',
            'puesto' => 'INICIADOR DE JUSTIFICACIONES',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true,
        ]);
        $user->assignRole('EMPLEADO_GRAL');
        $user->assignRole('INI_JUST');

        $user = User::create([
            'nombre' => 'INÉS',
            'apellido_paterno' => 'RUBIO',
            'apellido_materno' => 'AYALA',
            'email' => 'ines.ayala@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'IRAY0000008SA',
            'numero_empleado' => 21532,
            'rfc' => 'IRAY0000008SA',
            'curp' => 'IRAY000000HDFRSS02',
            'puesto' => 'CONTROL DE KARDEX',
            'area_id' => Area::select('area_id')->where('identificador', '999.1')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true,
        ]);
        $user->assignRole('CTRL_KDX');

        $user = User::create([
            'nombre' => 'ISIDORA',
            'apellido_paterno' => 'CARRILLO',
            'apellido_materno' => 'TORRES',
            'email' => 'isidora.carrillo@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'ICTO0000008S9',
            'numero_empleado' => 21533,
            'rfc' => 'ICTO0000008S9',
            'curp' => 'ICTO000000HDFRSSS9',
            'puesto' => 'CAPTURISTAL DE KARDEX',
            'area_id' => Area::select('area_id')->where('identificador', '999.1')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true,
        ]);
        $user->assignRole('CAPT_KDX');

        // P15 - ASISTENCIA

        $user = User::create([
            'nombre' => 'AITOR',
            'apellido_paterno' => 'RIBA',
            'apellido_materno' => 'CHECA',
            'email' => 'aitor.riba@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'ARCH0000008SA',
            'numero_empleado' => 21535,
            'rfc' => 'ARCH0000008SA',
            'curp' => 'ARCH000000HDFRSS01',
            'puesto' => 'CONTROL ASISTENCIA',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('CONTROL_ASISTENCIA');

        // 16 - PAGO DE TIEMPO EXTRA

        $user = User::create([
            'nombre' => 'BERNARDINO',
            'apellido_paterno' => 'ARJONA',
            'apellido_materno' => 'ELORZA',
            'email' => 'bernardino.arjona@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'BAEL0000008SA',
            'numero_empleado' => 352752,
            'rfc' => 'BAEL0000008SA',
            'curp' => 'BAEL000000HDFRSS01',
            'puesto' => 'JUD DE NOMINAS',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_TIEMPO_EXTRA');

        $user = User::create([
            'nombre' => 'SUB',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'BENITO JUAREZ',
            'email' => 'sub.enlace.jr@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'SUBB0000008SA',
            'numero_empleado' => 253005,
            'rfc' => 'SUBB0000008SA',
            'curp' => 'SUBB000000HDFRSS01',
            'puesto' => 'Encargado de asignar horas extras a los empleados',
            'area_id' => Area::select('area_id')->where('identificador', '11.201')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_TIEMPO_EXTRA');
        $user->assignRole('OPER_PREMIO_PUNTUALIDAD');

        $user = User::create([
            'nombre' => 'SUB',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'CORUÑA',
            'email' => 'subb.enlacee.jrr@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'SUBC0000008SA',
            'numero_empleado' => 696009,
            'rfc' => 'SUBC0000008SA',
            'curp' => 'SUBJ000000HDFRSS01',
            'puesto' => 'Encargado de asignar horas extras a los empleados',
            'area_id' => Area::select('area_id')->where('identificador', '11.202')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_TIEMPO_EXTRA');
        $user->assignRole('OPER_PREMIO_PUNTUALIDAD');

        // P19 - INCENTIVO EMPLEADO DEL MES

        // PROCESO P19
        $user = User::create([
            'nombre' => 'ANA',
            'apellido_paterno' => 'CASTILLO',
            'apellido_materno' => 'COLMENARES',
            'email' => 'ana.castillo@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22124111',
            'nombre_usuario' => 'CCAP000000ET0',
            'rfc' => 'CCAP000000ET0',
            'curp' => 'CCAP000000HDFRSN37',
            'puesto' => 'JUD DE PRESTACIONES Y CAPACITACIÓN DE PERSONAL',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_INC_19');

        $user = User::create([
            'nombre' => 'JUAN',
            'apellido_paterno' => 'LUGO',
            'apellido_materno' => 'TESORERIA',
            'email' => 'juan.lugo@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22125111',
            'nombre_usuario' => 'LTJP000000ET0',
            'rfc' => 'LTJP000000ET0',
            'curp' => 'LTJP000000HDFRSN37',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 11.2',
            'area_id' => Area::select('area_id')->where('identificador', '11.2')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');
        $user->assignRole('SUB_EA');
        $user->assignRole('OPER_TIEMPO_EXTRA');
        $user->assignRole('ENLACE_TIEMPO_EXTRA');
        $user->assignRole('ENLACE_PREMIO_PUNTUALIDAD');

        $user = User::create([
            'nombre' => 'JUAN',
            'apellido_paterno' => 'LUGO',
            'apellido_materno' => 'AT BENITO',
            'email' => 'juan.lugo.benito@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22126111',
            'nombre_usuario' => 'LABP000000ET0',
            'rfc' => 'LABP000000ET0',
            'curp' => 'LABP000000HDFRSN37',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 11.201',
            'area_id' => Area::select('area_id')->where('identificador', '11.201')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');


        $user = User::create([
            'nombre' => 'JUAN',
            'apellido_paterno' => 'LUGO',
            'apellido_materno' => 'AT ARAGON',
            'email' => 'juan.lugo.aragon@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22127111',
            'nombre_usuario' => 'LAAP000000ET0',
            'rfc' => 'LAAP000000ET0',
            'curp' => 'LAAP000000HDFRSN37',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 11.205',
            'area_id' => Area::select('area_id')->where('identificador', '11.205')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');
        $user->assignRole('OPER_PREMIO_PUNTUALIDAD');

        $user = User::create([
            'nombre' => 'MONICA',
            'apellido_paterno' => 'PIMENTEL',
            'apellido_materno' => 'DIRECCION DE ADM',
            'email' => 'monica.pimentel@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22128111',
            'nombre_usuario' => 'PMDP000000ET0',
            'rfc' => 'PMDP000000ET0',
            'curp' => 'PMDP000000HDFRSN37',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 137.2',
            'area_id' => Area::select('area_id')->where('identificador', '137.2')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');

        $user = User::create([
            'nombre' => 'MONICA',
            'apellido_paterno' => 'PIMENTEL',
            'apellido_materno' => 'DIREC ADM RECURSOS FINANCIEROS',
            'email' => 'monica.pimentel.recursos.financieros@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22129111',
            'nombre_usuario' => 'PMRF000000ET0',
            'rfc' => 'PMRF000000ET0',
            'curp' => 'PMRF000000HDFRSN37',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 137.201',
            'area_id' => Area::select('area_id')->where('identificador', '137.201')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');

        $user = User::create([
            'nombre' => 'MONICA',
            'apellido_paterno' => 'PIMENTEL',
            'apellido_materno' => 'DIREC ADM RECURSOS HUMANOS',
            'email' => 'monica.pimentel.recursos.humanos@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22120111',
            'nombre_usuario' => 'PMRH000000ET0',
            'rfc' => 'PMRH000000ET0',
            'curp' => 'PMRH000000HDFRSN37',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 137.205',
            'area_id' => Area::select('area_id')->where('identificador', '137.205')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');

        // PARA PRUEBAS
        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ADMIN',
            'apellido_materno' => 'INCENTIVO EMPLEADO',
            'email' => 'usuario.admin.incentivo.empleado@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122131',
            'nombre_usuario' => 'AIEU000000ET0',
            'rfc' => 'AIEU000000ET0',
            'curp' => 'AIEU000000HDFRSN37',
            'puesto' => 'JUD DE PRESTACIONES Y CAPACITACIÓN DE PERSONAL',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_INC_19');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'ADMINP19 FISCALIZACIÓN',
            'email' => 'usuario.enlace.admin.p19.11.3@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122112',
            'nombre_usuario' => 'EAUP000000EI9',
            'rfc' => 'EAUP000000EI9',
            'curp' => 'EAUP000000HDFRSN19',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 11.3',
            'area_id' => Area::select('area_id')->where('identificador', '11.3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');
        $user->assignRole('SUB_EA');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'ADMINP19 FISCALIZACIÓN AUDIT DIRECTAS',
            'email' => 'usuario.enlace.admin.p19.11.303@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122113',
            'nombre_usuario' => 'EAUA000000EI9',
            'rfc' => 'EAUA000000EI9',
            'curp' => 'EAUA000000HDFRSN19',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 11.303',
            'area_id' => Area::select('area_id')->where('identificador', '11.303')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'ADMINP19 FISCALIZACIÓN REVIS FISCALES',
            'email' => 'usuario.enlace.admin.p19.11.304@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122114',
            'nombre_usuario' => 'EAUF000000EI9',
            'rfc' => 'EAUF000000EI9',
            'curp' => 'EAUF000000HDFRSN19',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 11.304',
            'area_id' => Area::select('area_id')->where('identificador', '11.304')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'ADMINP19 PROCU FISCAL',
            'email' => 'usuario.enlace.admin.p19.95@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122115',
            'nombre_usuario' => 'EAUP000000EI5',
            'rfc' => 'EAUP000000EI5',
            'curp' => 'EAUP000000HDFRSN95',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 95',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');
        $user->assignRole('SUB_EA');

        $user = User::create([
            'nombre' => 'USUARIO',
            'apellido_paterno' => 'ENLACE',
            'apellido_materno' => 'ADMINP19 FISCALIZACIÓN CONTRALORIA',
            'email' => 'usuario.enlace.admin.p19.95.1@finanzas.cdmx.gob.mx',
            'numero_empleado' => '22122116',
            'nombre_usuario' => 'EAUC000000EI5',
            'rfc' => 'EAUC000000EI5',
            'curp' => 'EAUC000000HDFRSN95',
            'puesto' => 'SUB_EA Y OPER_INC_19 PRUEBAS SUBPROCESO 95.1',
            'area_id' => Area::select('area_id')->where('identificador', '95.1')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_INC_19');
        $user->assignRole('SUB_EA');

        // P20 - PREMIO DE PUNTUALIDAD

        $user = User::create([
            'nombre' => 'ALEJANDRO',
            'apellido_paterno' => 'MEDINA',
            'apellido_materno' => 'TORRES',
            'email' => 'alejandro.medina.torres@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25632002',
            'nombre_usuario' => 'META0000007WA',
            'rfc' => 'META0000007WA',
            'curp' => 'META000000HMCMRD07',
            'puesto' => 'SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_PREMIO_PUNTUALIDAD');

        $user = User::create([
            'nombre' => 'JESSICA',
            'apellido_paterno' => 'MARTINEZ',
            'apellido_materno' => 'TORRES',
            'email' => 'jessica.martinez.torres@finanzas.cdmx.gob.mx',
            'numero_empleado' => '58962225',
            'nombre_usuario' => 'MATJ0000007WA',
            'rfc' => 'MATJ0000007WA',
            'curp' => 'MATJ000000HMCMRD07',
            'puesto' => 'OPERADOR DE PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_PREMIO_PUNTUALIDAD');

        // USUARIOS PARA ENTREGAR Y QUE HAGAN PRUEBAS
        $user = User::create([
            'nombre' => 'ENRIQUE',
            'apellido_paterno' => 'SOLORZANO',
            'apellido_materno' => 'JUAREZ',
            'email' => 'enrique.solorzano.juarez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '20025963',
            'nombre_usuario' => 'SOJE0000007WA',
            'rfc' => 'SOJE0000007WA',
            'curp' => 'SOJE000000HMCMRD07',
            'puesto' => 'SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_PREMIO_PUNTUALIDAD');

        $user = User::create([
            'nombre' => 'FABIOLA',
            'apellido_paterno' => 'GUZMAN',
            'apellido_materno' => 'LARA',
            'email' => 'fabiola.guzman.lara@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25482000',
            'nombre_usuario' => 'GULF0000007WA',
            'rfc' => 'GULF0000007WA',
            'curp' => 'GULF000000HMCMRD07',
            'puesto' => 'OPERADOR DE PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_PREMIO_PUNTUALIDAD');

        // P21 - PREMIO DE ADMINISTRACIÓN

        $user = User::create([
            'nombre' => 'SAUL',
            'apellido_paterno' => 'JUAREZ',
            'apellido_materno' => 'JARAMILLO',
            'email' => 'saul.juarez.jaramillo@finanzas.cdmx.gob.mx',
            'numero_empleado' => '52000014',
            'nombre_usuario' => 'JUJS0000007WA',
            'rfc' => 'JUJS0000007WA',
            'curp' => 'JUJS000000HMCMRD07',
            'puesto' => 'ADMINISTRADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_PA_21');

        $user = User::create([
            'nombre' => 'ARTURO',
            'apellido_paterno' => 'LANDA',
            'apellido_materno' => 'ROCHE',
            'email' => 'arturo.landa.roche@finanzas.cdmx.gob.mx',
            'numero_empleado' => '20310259',
            'nombre_usuario' => 'LARA0000007WA',
            'rfc' => 'LARA0000007WA',
            'curp' => 'LARA000000HMCMRD07',
            'puesto' => 'OPERADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_PA_21');

        $user = User::create([
            'nombre' => 'ELENA',
            'apellido_paterno' => 'MOTA',
            'apellido_materno' => 'REYES',
            'email' => 'elena.mota.reyes@finanzas.cdmx.gob.mx',
            'numero_empleado' => '78541002',
            'nombre_usuario' => 'MORE0000007WA',
            'rfc' => 'MORE0000007WA',
            'curp' => 'MORE000000HMCMRD07',
            'puesto' => 'AUTORIZADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('AUTZ_PA_21');

        $user = User::create([
            'nombre' => 'LAURA',
            'apellido_paterno' => 'CRUZ',
            'apellido_materno' => 'TOVAR',
            'email' => 'laura.cruz.tovar@finanzas.cdmx.gob.mx',
            'numero_empleado' => '55569542',
            'nombre_usuario' => 'CRTL0000007WA',
            'rfc' => 'CRTL0000007WA',
            'curp' => 'CRTL000000HMCMRD07',
            'puesto' => 'OPERADOR DE CURSOS DE CAPACITACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_CAP_21');

        // USUARIOS PARA PROBAR CON DIFERENTE UNIDAD ADMINISTRATIVA
        $user = User::create([
            'nombre' => 'JKHJKHKJH',
            'apellido_paterno' => 'HJKHKJH',
            'apellido_materno' => 'GVBJH',
            'email' => 'hjghjgghmmm@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25630025',
            'nombre_usuario' => 'PYXJ0000007WA',
            'rfc' => 'PYXJ0000007WA',
            'curp' => 'PYXJ000000HMCMRD07',
            'puesto' => 'ADMINISTRADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_PA_21');

        $user = User::create([
            'nombre' => 'HJJKVHGHJG',
            'apellido_paterno' => 'JKHJKHKJHK',
            'apellido_materno' => 'BHJGUYB',
            'email' => 'asasasasasasxxcv@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25004788',
            'nombre_usuario' => 'CCFL0000007WA',
            'rfc' => 'CCFL0000007WA',
            'curp' => 'CCFL000000HMCMRD07',
            'puesto' => 'OPERADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_PA_21');

        $user = User::create([
            'nombre' => 'SADFDSF',
            'apellido_paterno' => 'FDFEWF',
            'apellido_materno' => 'DFSFSDF',
            'email' => 'asdfrewdvgji@finanzas.cdmx.gob.mx',
            'numero_empleado' => '596999369',
            'nombre_usuario' => 'WLFP0000007WA',
            'rfc' => 'WLFP0000007WA',
            'curp' => 'WLFP000000HMCMRD07',
            'puesto' => 'AUTORIZADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('AUTZ_PA_21');

        $user = User::create([
            'nombre' => 'SDFERFCRE',
            'apellido_paterno' => 'CRFCWRRUZ',
            'apellido_materno' => 'TOFR4W4RFVAR',
            'email' => 'asddfCS.sad@finanzas.cdmx.gob.mx',
            'numero_empleado' => '24582223',
            'nombre_usuario' => 'ZPSK0000007WA',
            'rfc' => 'ZPSK0000007WA',
            'curp' => 'ZPSK000000HMCMRD07',
            'puesto' => 'OPERADOR DE CURSOS DE CAPACITACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_CAP_21');

        // USUARIOS PARA ENTREGAR Y QUE HAGAN PRUEBAS
        $user = User::create([
            'nombre' => 'ROSA',
            'apellido_paterno' => 'TREJO',
            'apellido_materno' => 'TREJO',
            'email' => 'rosa.trejo.trejo@finanzas.cdmx.gob.mx',
            'numero_empleado' => '00023510',
            'nombre_usuario' => 'TRTR0000007WA',
            'rfc' => 'TRTR0000007WA',
            'curp' => 'TRTR000000HMCMRD07',
            'puesto' => 'ADMINISTRADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_PA_21');

        $user = User::create([
            'nombre' => 'ARACELI',
            'apellido_paterno' => 'RENDON',
            'apellido_materno' => 'CRUZ',
            'email' => 'araceli.rendon.cruz@finanzas.cdmx.gob.mx',
            'numero_empleado' => '99625140',
            'nombre_usuario' => 'RECA0000007WA',
            'rfc' => 'RECA0000007WA',
            'curp' => 'RECA000000HMCMRD07',
            'puesto' => 'AUTORIZADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('AUTZ_PA_21');

        $user = User::create([
            'nombre' => 'PEDRO',
            'apellido_paterno' => 'MALAGON',
            'apellido_materno' => 'REYNOSO',
            'email' => 'pedro.malagon.reynoso@finanzas.cdmx.gob.mx',
            'numero_empleado' => '85455501',
            'nombre_usuario' => 'MARP0000007WA',
            'rfc' => 'MARP0000007WA',
            'curp' => 'MARP000000HMCMRD07',
            'puesto' => 'OPERADOR DE CURSOS DE CAPACITACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_CAP_21');

        $user = User::create([
            'nombre' => 'JORGE',
            'apellido_paterno' => 'PEDRAZA',
            'apellido_materno' => 'MORALES',
            'email' => 'jorge.pedraza.morales@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25800014',
            'nombre_usuario' => 'PEMJ0000007WA',
            'rfc' => 'PEMJ0000007WA',
            'curp' => 'PEMJ000000HMCMRD07',
            'puesto' => 'OPERADOR DE PREMIO DE ADMINISTRACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_PA_21');

        // P22 - REPORTES DÍAS EFECTIVAMENTE LABORADOS

        $user = User::create([
            'nombre' => 'EZEQUIEL',
            'apellido_paterno' => 'FLORES',
            'apellido_materno' => 'FLORES',
            'email' => 'ezequiel.flores.flores@finanzas.cdmx.gob.mx',
            'numero_empleado' => '66632015',
            'nombre_usuario' => 'EZEQ0000007WA',
            'rfc' => 'EZEQ0000007WA',
            'curp' => 'EZEQ000000HMCMRD07',
            'puesto' => 'ADMINISTRADOR DE REPORTES',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_REP_22');

        // USUARIOS PARA ENTREGAR Y QUE HAGAN PRUEBAS
        $user = User::create([
            'nombre' => 'ERNESTO',
            'apellido_paterno' => 'PRIETO',
            'apellido_materno' => 'DELGADO',
            'email' => 'ernesto.prieto.delgado@finanzas.cdmx.gob.mx',
            'numero_empleado' => '25222563',
            'nombre_usuario' => 'PRDE0000007WA',
            'rfc' => 'PRDE0000007WA',
            'curp' => 'PRDE000000HMCMRD07',
            'puesto' => 'ADMINISTRADOR DE REPORTES',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMN_REP_22');

        // P23 - SOLICITUD DE EXPEDIENTES

        $user = User::create([
            'nombre' => 'HOMERO',
            'apellido_paterno' => 'HERNANDEZ',
            'apellido_materno' => 'HERNANDEZ',
            'email' => 'homero.hernandez.hdz@finanzas.cdmx.gob.mx',
            'numero_empleado' => '02333145',
            'nombre_usuario' => 'HOME0000007WA',
            'rfc' => 'HOME0000007WA',
            'curp' => 'HOME000000HMCMRD07',
            'puesto' => 'OPERADOR DE DIGITALIZACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_DIG_23');

        $user = User::create([
            'nombre' => 'EDUARDO',
            'apellido_paterno' => 'RENDON',
            'apellido_materno' => 'ESPINOZA',
            'email' => 'eduardo.rendon.espinoza@finanzas.cdmx.gob.mx',
            'numero_empleado' => '58520015',
            'nombre_usuario' => 'REEE0000007WA',
            'rfc' => 'REEE0000007WA',
            'curp' => 'REEE000000HMCMRD07',
            'puesto' => 'INICIADOR DE LA SOLICITUD DE EXPEDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('INI_EXP_23');

        $user = User::create([
            'nombre' => 'KARLA',
            'apellido_paterno' => 'RAMIREZ',
            'apellido_materno' => 'BALDERAS',
            'email' => 'karlas.ramirez.balderas@finanzas.cdmx.gob.mx',
            'numero_empleado' => '21540245',
            'nombre_usuario' => 'RABK0000007WA',
            'rfc' => 'RABK0000007WA',
            'curp' => 'RABK000000HMCMRD07',
            'puesto' => 'CONTROLADOR DE LA SOLICITUD DE EXPEDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('CTRL_EXP_23');

        $user = User::create([
            'nombre' => 'BERENICE',
            'apellido_paterno' => 'ALTAIR',
            'apellido_materno' => 'TORRES',
            'email' => 'berenice.altair.torres@finanzas.cdmx.gob.mx',
            'numero_empleado' => '52300325',
            'nombre_usuario' => 'ALTB0000007WA',
            'rfc' => 'ALTB0000007WA',
            'curp' => 'ALTB000000HMCMRD07',
            'puesto' => 'OPERADOR DE EXPEDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_EXP_23');

        // USUARIOS PARA ENTREGAR Y QUE HAGAN PRUEBAS
        $user = User::create([
            'nombre' => 'DANIEL',
            'apellido_paterno' => 'ESPARZA',
            'apellido_materno' => 'REAL',
            'email' => 'daniel.esparza.real@finanzas.cdmx.gob.mx',
            'numero_empleado' => '55596248',
            'nombre_usuario' => 'ESRD0000007WA',
            'rfc' => 'ESRD0000007WA',
            'curp' => 'ESRD000000HMCMRD07',
            'puesto' => 'OPERADOR DE DIGITALIZACIÓN',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_DIG_23');

        $user = User::create([
            'nombre' => 'PEDRO JUAN',
            'apellido_paterno' => 'BALDERAS',
            'apellido_materno' => 'NIÑO',
            'email' => 'pedro.balderas.nino@finanzas.cdmx.gob.mx',
            'numero_empleado' => '63236694',
            'nombre_usuario' => 'BANP0000007WA',
            'rfc' => 'BANP0000007WA',
            'curp' => 'BANP000000HMCMRD07',
            'puesto' => 'INICIADOR DE LA SOLICITUD DE EXPEDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('INI_EXP_23');

        $user = User::create([
            'nombre' => 'BRENDA',
            'apellido_paterno' => 'DOMINGUEZ',
            'apellido_materno' => 'JUAREZ',
            'email' => 'brenda.dominguez.juarez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11147803',
            'nombre_usuario' => 'DOJB0000007WA',
            'rfc' => 'DOJB0000007WA',
            'curp' => 'DOJB000000HMCMRD07',
            'puesto' => 'CONTROLADOR DE LA SOLICITUD DE EXPEDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('CTRL_EXP_23');

        $user = User::create([
            'nombre' => 'RAUL',
            'apellido_paterno' => 'ZAMUDIO',
            'apellido_materno' => 'PIMENTEL',
            'email' => 'raul.zamudio.pimentel@finanzas.cdmx.gob.mx',
            'numero_empleado' => '09968857',
            'nombre_usuario' => 'ZAPR0000007WA',
            'rfc' => 'ZAPR0000007WA',
            'curp' => 'ZAPR000000HMCMRD07',
            'puesto' => 'OPERADOR DE EXPEDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '95')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('OPER_EXP_23');

        // P24 - DIRECTORIO

        // ADMIN_ALFA
        $user = User::create([
            'nombre' => 'JOSE',
            'apellido_paterno' => 'HERNANDEZ',
            'apellido_materno' => 'LOPEZ',
            'email' => 'jose.hernandez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'JHLL0000009VA',
            'numero_empleado' => 21586,
            'rfc' => 'JHLL0000009VA',
            'curp' => 'JHLL000000HDFRSS01',
            'puesto' => 'SUBDIRECTOR DE ORGANIZACION Y METODOS',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_ALFA');

        // ADMIN_PLAZAS
        $user = User::create([
            'nombre' => 'JAVIER',
            'apellido_paterno' => 'LOPEZ',
            'apellido_materno' => 'MARTINEZ',
            'email' => 'javier.lopez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'JLMM0000009VA',
            'numero_empleado' => 21589,
            'rfc' => 'JLMM0000009VA',
            'curp' => 'JLMM000000HDFRSS01',
            'puesto' => 'ENCARGADA DE LA JEFATURA DE UNIDAD DEPARTAMENTAL DE MOVIMIENTOS DE PERSONAL',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_PLAZAS');

        // P31 - VIATINET

        $user = User::create([
            'nombre' => 'LUCIANO',
            'apellido_paterno' => 'ROSELL',
            'apellido_materno' => 'MATEOS',
            'email' => 'luciano.rosell@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'LRMA0000008S1',
            'numero_empleado' => 21880,
            'rfc' => 'LRMA0000008S1',
            'curp' => 'LRMA000000HDFRSS98',
            'puesto' => 'ENLACE',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ENLACE_CAPTURA_VIATICO');

        $user = User::create([
            'nombre' => 'CANDELA',
            'apellido_paterno' => 'ALBEROLA',
            'apellido_materno' => 'ALMAZÁN',
            'email' => 'candela.alberola@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'CAAL0000008S1',
            'numero_empleado' => 21541,
            'rfc' => 'CAAL0000008S1',
            'curp' => 'CAAL000000HDFRSS98',
            'puesto' => 'TITULAR DEL ÓRGANO',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TITULAR_ORGANO');

        $user = User::create([
            'nombre' => 'EMILIA',
            'apellido_paterno' => 'ESPAÑOL',
            'apellido_materno' => 'TÉLLEZ',
            'email' => 'emilia.español@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'EETE0000008S9',
            'numero_empleado' => 21542,
            'rfc' => 'EETE0000008S9',
            'curp' => 'EETE000000HDFRSS78',
            'puesto' => 'TITULAR DEL ÓRGANO',
            'area_id' => Area::select('area_id')->where('identificador', '139')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ENLACE_CAPTURA_VIATICO');

        $user = User::create([
            'nombre' => 'JOAQUINA',
            'apellido_paterno' => 'CHAVES',
            'apellido_materno' => 'ESPAÑOL',
            'email' => 'joaquina.chaves@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'JCES0000008S9',
            'numero_empleado' => 21543,
            'rfc' => 'JCES0000008S9',
            'curp' => 'JCES000000HDFRSS78',
            'puesto' => 'ENLACE',
            'area_id' => Area::select('area_id')->where('identificador', '139')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TITULAR_ORGANO');

        $user = User::create([
            'nombre' => 'ELVIA',
            'apellido_paterno' => 'MARTINEZ',
            'apellido_materno' => 'CASTRO',
            'email' => 'elvia.martinez@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'EMCA0000008S9',
            'numero_empleado' => 21580,
            'rfc' => 'EMCA0000008S9',
            'curp' => 'EMCA000000HDFRSS78',
            'puesto' => 'TITULAR DE ADMINISTRACIÓN DE FINANZAS',
            'area_id' => Area::select('area_id')->where('identificador', '137')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TITULAR_ADMINISTRACION');

        $user = User::create([
            'nombre' => 'ANGEL',
            'apellido_paterno' => 'VILLARREAL',
            'apellido_materno' => 'ORTIZ',
            'email' => 'angel.villarreal@finanzas.cdmx.gob.mx',
            'nombre_usuario' => 'AVOR0000008S9',
            'numero_empleado' => 21581,
            'rfc' => 'AVOR0000008S9',
            'curp' => 'AVOR000000HDFRSS78',
            'puesto' => 'JUD DE VIÁTICOS',
            'area_id' => Area::select('area_id')->where('identificador', '3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('AUTORIZADOR_VIATICO');

        // P32 - TRÁMITES KARDEX

        $user = User::create([
            'nombre' => 'JORGE',
            'apellido_paterno' => 'MARIN',
            'apellido_materno' => 'CHANG',
            'email' => 'jorge.marin@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11223344',
            'nombre_usuario' => 'JMAC000000ET0',
            'rfc' => 'JMAC000000ET0',
            'curp' => 'JMAC000000HDFRSN37',
            'puesto' => 'CAPTURA KARDEX INICADOR DE PROCESO',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('CAPTURA_KARDEX');

        $user = User::create([
            'nombre' => 'ANDRES',
            'apellido_paterno' => 'MARIN',
            'apellido_materno' => 'CREMS',
            'email' => 'andres.crems@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11223144',
            'nombre_usuario' => 'CREM000000ET0',
            'rfc' => 'CREM000000ET0',
            'curp' => 'CREM000000HDFRSN37',
            'puesto' => 'CAPTURA KARDEX INICADOR DE PROCESO',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('CAPTURA_KARDEX');

        $user = User::create([
            'nombre' => 'REYNALDO',
            'apellido_paterno' => 'ZOTO',
            'apellido_materno' => 'SANCHEZ',
            'email' => 'reynaldo.zoto@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11223341',
            'nombre_usuario' => 'REYZ000000ET0',
            'rfc' => 'REYZ000000ET0',
            'curp' => 'REYZ000000HDFRSN37',
            'puesto' => 'ADMIN KARDEX ASIGNA LOS TRÁMITES AL USUARIO CORRESPONDIENTE',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_KARDEX');

        $user = User::create([
            'nombre' => 'OLIVIA',
            'apellido_paterno' => 'GOMEZ',
            'apellido_materno' => 'CHUC',
            'email' => 'olivia.chuc@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11223342',
            'nombre_usuario' => 'OLIC000000ET0',
            'rfc' => 'OLIC000000ET0',
            'curp' => 'OLIC000000HDFRSN37',
            'puesto' => 'TECNICO OPERATIVO KARDEX CAPTURA INFORMACIÓN DEL TRÁMITE EN CURSO',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TECNICO_OPERATIVO_KARDEX');

        $user = User::create([
            'nombre' => 'MARICRUZ',
            'apellido_paterno' => 'VELEZ',
            'apellido_materno' => 'POMODORO',
            'email' => 'maricruz.pomodoro@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11213343',
            'nombre_usuario' => 'POMO000000ET0',
            'rfc' => 'POMO000000ET0',
            'curp' => 'POMO000000HDFRSN37',
            'puesto' => 'TECNICO OPERATIVO KARDEX CAPTURA INFORMACIÓN DEL TRÁMITE EN CURSO',
            'area_id' => Area::select('area_id')->where('identificador', '999')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TECNICO_OPERATIVO_KARDEX');

        $user = User::create([
            'nombre' => 'ARTURO',
            'apellido_paterno' => 'CRUZ',
            'apellido_materno' => 'LLAMAS',
            'email' => 'arturo.llamas@finanzas.cdmx.gob.mx',
            'numero_empleado' => '11223343',
            'nombre_usuario' => 'ARTU000000ET0',
            'rfc' => 'ARTU000000ET0',
            'curp' => 'ARTU000000HDFRSN37',
            'puesto' => 'TECNICO OPERATIVO KARDEX CAPTURA INFORMACIÓN DEL TRÁMITE EN CURSO',
            'area_id' => Area::select('area_id')->where('identificador', '3')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('TECNICO_OPERATIVO_KARDEX');

    }
}
