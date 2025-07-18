<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class usuariospAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = array([
            'usuario' => 'Prueba3',
            'created_at'=>Carbon::now(),
            'email' => 'prueba3@gmail.com',
            'created_at'=>Carbon::now(),
            'password' => hash::make('12345'),
            'created_at'=>Carbon::now(),
            'nombre_completo' => 'Prueba app 3',
            'created_at'=>Carbon::now()
        ]);


        DB::table('usuarios_app')->insert($data);
    }
}
