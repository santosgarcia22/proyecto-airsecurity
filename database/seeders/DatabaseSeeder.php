<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(usuariospAppSeeder::class);
        $this->call(ChatbotFlowsSeeder::class);

        $this->call([
        OperadoresSeeder::class,
        VuelosSeeder::class,
        AccesosSeeder::class,
        TiemposOperativosSeeder::class,
        DemorasSeeder::class,
    ]);


    }
}