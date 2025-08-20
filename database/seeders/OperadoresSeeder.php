<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         DB::table('operadores')->insert([
            ['codigo' => 'AVA', 'nombre' => 'Avianca'],
            ['codigo' => 'LAT', 'nombre' => 'Latam'],
            ['codigo' => 'AMX', 'nombre' => 'Aeroméxico'],
        ]);

    }
}
