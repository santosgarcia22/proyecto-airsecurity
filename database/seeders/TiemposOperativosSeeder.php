<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TiemposOperativosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

          DB::table('tiempos_operativos')->insert([
            [
                'vuelo_id' => 1,
                'desabordaje_inicio' => Carbon::now(),
                'desabordaje_fin' => Carbon::now()->addMinutes(15),
                'abordaje_inicio' => Carbon::now()->addMinutes(30),
                'abordaje_fin' => Carbon::now()->addMinutes(60),
                'inspeccion_cabina_inicio' => Carbon::now()->addMinutes(20),
                'inspeccion_cabina_fin' => Carbon::now()->addMinutes(25),
                'aseo_ingreso' => Carbon::now()->addMinutes(10),
                'aseo_salida' => Carbon::now()->addMinutes(30),
                'tripulacion_ingreso' => Carbon::now()->addMinutes(35),
                'cierre_puertas' => Carbon::now()->addMinutes(70),
            ],
        ]);
    }
}
