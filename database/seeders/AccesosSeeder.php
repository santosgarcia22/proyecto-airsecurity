<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccesosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

          DB::table('accesos')->insert([
            [
                'vuelo_id' => 1,
                'nombre' => 'Técnico de mantenimiento',
                'identificacion' => 'TEC001',
                'empresa' => 'AirSupport',
                'herramientas' => 1,
                'motivo_entrada' => 'Revisión de cabina',
                'hora_entrada' => Carbon::now(),
                'hora_salida' => Carbon::now()->addMinutes(30),
                'firma_path' => 'firmas/tec001.png'
            ],
        ]);
    }
}
