<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VuelosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
DB::table('vuelos')->insert([
            [
                'fecha' => Carbon::now()->toDateString(),
                'origen' => 'SAL',
                'destino' => 'MIA',
                'numero_vuelo_llegando' => 'AV123',
                'numero_vuelo_saliendo' => 'AV124',
                'matricula' => 'N123AV',
                'operador_id' => 1,   // FK operadores
                'posicion_llegada' => 'A1',
                'hora_llegada_real' => Carbon::now(),
                'hora_salida_itinerario' => Carbon::now()->addHours(2),
                'hora_salida_pushback' => Carbon::now()->addHours(2)->addMinutes(15),
                'total_pax' => 120,
               
            ],
        ]);

    }
}
