<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\TipoPago;
use Illuminate\Database\Seeder;

class TiposPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoPago::create([
            'nombre' => 'TRANSFERENCIA BANCARIA', 
            'abreviatura' => 'TB', 
            'identificador' => "TB"
        ]);
        TipoPago::create([
            'nombre' => 'CHEQUE', 
            'abreviatura' => 'C', 
            'identificador' => "C"
        ]);
        
    }
}
