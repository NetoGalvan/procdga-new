<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeederReales extends Seeder
{
    public function run()
    {
        $user = User::create([
            'nombre' => 'HECTOR',
            'apellido_paterno' => 'LOPEZ',
            'apellido_materno' => 'LOPEZ',
            'email' => 'hector.lopez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '55886637',
            'nombre_usuario' => 'hector.lopez',
            'rfc' => 'MELV420315JP1',
            'curp' => 'MELV420315HDFRSN37',
            'puesto' => ' ',
            'area_id' => Area::select('area_id')->where('identificador', '138')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RM');
        $user->assignRole('JUD_IMPRE');
        $user->assignRole('JUD_LIMPIEZA');
        $user->assignRole('JUD_MTTO');
        $user->assignRole('JUD_TELEFONIA');
        $user->assignRole('JUD_TRANSPORTE');
        $user->assignRole('SUB_CONS');
        $user->assignRole('SUB_EA');

        $user = User::create([
            'nombre' => 'JOSE MANUEL',
            'apellido_paterno' => 'SALAZAR',
            'apellido_materno' => 'SALAZAR',
            'email' => 'jmanelsm017@gmail.com',
            'numero_empleado' => '52305890',
            'nombre_usuario' => 'SAMM741029DB9',
            'rfc' => 'SAMM741029DB9',
            'curp' => 'SAMM741029HHGLRN06',
            'puesto' => 'JUD DE TELEFONIA',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RM');
        $user->assignRole('JUD_TELEFONIA');
        
        $user = User::create([
            'nombre' => 'NADIA IVONNE',
            'apellido_paterno' => 'VALDEZ',
            'apellido_materno' => 'HERNÁNDEZ',
            'email' => 'nvaldez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '975933',
            'nombre_usuario' => 'VAHN8102251Z5',
            'rfc' => 'VAHN8102251Z5',
            'curp' => 'VAHN810225MDFLRD02',
            'puesto' => 'SECRETARIA',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RM');
        $user->assignRole('JUD_TELEFONIA');

        $user = User::create([
            'nombre' => 'GENARO RAUL',
            'apellido_paterno' => 'CORTES',
            'apellido_materno' => 'TAPIA',
            'email' => 'gcortes@finanzas.cdmx.gob.mx',
            'numero_empleado' => '830826',
            'nombre_usuario' => 'COTG661202TJ7',
            'rfc' => 'COTG661202TJ7',
            'curp' => 'COTG661202HDFRPN05',
            'puesto' => 'JUD DE TRANSPORTE',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('JUD_RM');
        $user->assignRole('JUD_TRANSPORTE');

        $user = User::create([
            'nombre' => 'AAAAAA',
            'apellido_paterno' => 'AAAAAA',
            'apellido_materno' => 'AAAAAA',
            'email' => 'AAAAAA@gmail.com',
            'numero_empleado' => '25522552',
            'nombre_usuario' => 'COTG661202TJ9',
            'rfc' => 'COTG661202TJ9',
            'curp' => 'COTG661202HDFRPN09',
            'puesto' => 'AAAAAA',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_TIEMPO_EXTRA');

        $user = User::create([
            'nombre' => 'BBBBB',
            'apellido_paterno' => 'BBBBB',
            'apellido_materno' => 'BBBBB',
            'email' => 'BBBBB@finanzas.cdmx.gob.mx',
            'numero_empleado' => '58855885',
            'nombre_usuario' => 'COTG661202TJ1',
            'rfc' => 'COTG661202TJ1',
            'curp' => 'COTG661202HDFRPN01',
            'puesto' => 'BBBBB',
            'area_id' => Area::select('area_id')->where('identificador', '999.4')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('ADMIN_TIEMPO_EXTRA');

        $user = User::create([
            'nombre' => 'ULISES',
            'apellido_paterno' => 'SALAZAR',
            'apellido_materno' => 'BERNABEL',
            'email' => 'usalazar@finanzas.cdmx.gob.mx',
            'numero_empleado' => '5423831',
            'nombre_usuario' => 'SABU0000008RL',
            'rfc' => 'SABU970924567',
            'curp' => 'SABU970924HMCLRL08',
            'puesto' => 'USUARIO PARA PRUEBAS',
            'area_id' => Area::select('area_id')->where('identificador', '11.2')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');
        $user->assignRole('INI_JUST');

        $user = User::create([
            'nombre' => 'EDGAR',
            'apellido_paterno' => 'RUEDA',
            'apellido_materno' => 'GARCIA',
            'email' => 'erueda@finanzas.cdmx.gob.mx',
            'numero_empleado' => '6389024',
            'nombre_usuario' => 'RUGE0000003RD',
            'rfc' => 'RUGE920416893',
            'curp' => 'RUGE920416HMCDRD03',
            'puesto' => 'USUARIO PARA PRUEBAS',
            'area_id' => Area::select('area_id')->where('identificador', '11')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('SUB_EA');
        $user->assignRole('INI_JUST');

        $user = User::create([
            'nombre' => 'FABIAN',
            'apellido_paterno' => 'MARTINEZ',
            'apellido_materno' => 'TOLEDO',
            'email' => 'fmartinez@finanzas.cdmx.gob.mx',
            'numero_empleado' => '3759240',
            'nombre_usuario' => 'MATF0000002LB',
            'rfc' => 'MATF940220492',
            'curp' => 'MATF940220HMCRLB02',
            'puesto' => 'USUARIO PARA PRUEBAS',
            'area_id' => Area::select('area_id')->where('identificador', '11.201')->get()[0]->area_id,
            'password' => Hash::make('12345678'),
            'change_password' => true
        ]);
        $user->assignRole('INI_JUST');
    }
}
