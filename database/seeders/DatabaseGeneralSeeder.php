<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseGeneralSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // GENERALES
        $this->call(DependenciasSeeder::class);
        $this->call(UnidadesAdministrativasSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UsersSeederReales::class);
        $this->call(CodigoPostalSeeder::class);
        $this->call(TipoFirmaSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(EntidadesFederativasSeeder::class);
        $this->call(MunicipiosSeeder::class);
        $this->call(FormatosSeeder::class);
        $this->call(TiposAmbitosSeeder::class);
        $this->call(PlazasSeeder::class);
        $this->call(EmpleadoSeeder::class);
        $this->call(EmpleadosPlazasSeeder::class);
        $this->call(NivelesSalarialesSeeder::class);
        $this->call(SituacionesPlazasSeeder::class);
        $this->call(UniversosSeeder::class);
        $this->call(LineamientosSeeder::class);
    }
}
