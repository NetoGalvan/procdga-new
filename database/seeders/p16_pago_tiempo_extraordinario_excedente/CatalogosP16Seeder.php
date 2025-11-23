<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use App\Models\Catalogo;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class CatalogosP16Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $catalogoPresupuestoAnual = Catalogo::create([
        //     'nombre' => 'PRESUPUESTO ANUAL EXTRAORDINARIO/EXCEDENTE',
        //     'identificador' => 'catalogo_presupuesto_extra_excedente',
        //     'descripcion' => 'Presupuesto Anual de Tiempo Extraordinadio y Excedente.',
        //     'proceso_id' => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
        //     'ruta' => 'tiempo.extraordinario.excedente.catalogo.anual'
        // ]);

        // $catalogoPresupuestoAnual->syncRoles([Role::where('name', 'ADMIN_TIEMPO_EXTRA')->first()->id]);

        $catalogoPivelSalarial = Catalogo::create([
            'nombre' => 'TABULADOR DE SUELDOS',
            'identificador' => 'catalogo_tabulador_sueldos',
            'descripcion' => 'Tabuladores de sueldos autorizados usados para calcular el pago de tiempo extra o excedente.',
            'proceso_id' => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
            'ruta' => 'tiempo.extraordinario.excedente.catalogo.tabuladores'
        ]);

        $catalogoPivelSalarial->syncRoles([Role::where('name', 'ADMIN_TIEMPO_EXTRA')->first()->id]);
    }
}
