<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  

class DemorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

          DB::table('demoras')->insert([
            [
                'vuelo_id' => 1,
                'motivo' => 'Retraso en abastecimiento de combustible',
                'minutos' => 20,
                'agente_id' => 1, // FK personas
            ],
        ]);
    }
}
