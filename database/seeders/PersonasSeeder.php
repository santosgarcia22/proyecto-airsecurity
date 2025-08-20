<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('personas')->insert([
            [
                'nombre' => 'Juan Pérez',
                'identificacion' => 'JP123',
                'empresa' => 'AirSupport',
                'rol' => 'AGENTE'
            ],
            [
                'nombre' => 'María López',
                'identificacion' => 'ML456',
                'empresa' => 'AirSupport',
                'rol' => 'COORDINADOR'
            ],
            [
                'nombre' => 'Carlos Ruiz',
                'identificacion' => 'CR789',
                'empresa' => 'AirSupport',
                'rol' => 'LIDER_VUELO'
            ],
        ]);
    }
}
