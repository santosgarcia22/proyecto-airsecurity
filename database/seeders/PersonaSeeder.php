<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
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
                'identificacion' => 'JP12345',
                'empresa' => 'AeroServicios',
                'rol' => 'AGENTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María Gómez',
                'identificacion' => 'MG54321',
                'empresa' => 'SkyLine',
                'rol' => 'OFICIAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos López',
                'identificacion' => 'CL98765',
                'empresa' => 'FlyHigh',
                'rol' => 'COORDINADOR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
