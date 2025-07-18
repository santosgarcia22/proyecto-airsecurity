<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotFlow;

class ChatbotFlowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Pregunta raíz
        $inicio = ChatbotFlow::create([
            'texto' => '¿Sobre qué tema necesitas ayuda?',
            'parent_id' => null,
            'es_final' => false,
        ]);

        // Opciones raíz
        $horarios = ChatbotFlow::create([
            'texto' => 'Horarios',
            'parent_id' => $inicio->id,
            'es_final' => false,
        ]);

        $precios = ChatbotFlow::create([
            'texto' => 'Precios',
            'parent_id' => $inicio->id,
            'es_final' => false,
        ]);

        $soporte = ChatbotFlow::create([
            'texto' => 'Soporte Técnico',
            'parent_id' => $inicio->id,
            'es_final' => false,
        ]);

        $whatsapp = ChatbotFlow::create([
            'texto' => 'https://wa.me/50312345678?text=Hola%20necesito%20ayuda%20con%20mi%20servicio',
            'parent_id' => $inicio->id,
            'es_final' => true,
        ]);

        // Subopciones: Horarios
        ChatbotFlow::create([
            'texto' => 'Los vuelos operan de 8:00 a.m. a 5:00 p.m.',
            'parent_id' => $horarios->id,
            'es_final' => true,
        ]);

        ChatbotFlow::create([
            'texto' => 'El mantenimiento está disponible 24/7.',
            'parent_id' => $horarios->id,
            'es_final' => true,
        ]);

        // Subopciones: Precios
        ChatbotFlow::create([
            'texto' => 'Vuelo VIP tiene un costo de $500 por tramo.',
            'parent_id' => $precios->id,
            'es_final' => true,
        ]);

        ChatbotFlow::create([
            'texto' => 'Transporte de carga cuesta $2 por kg.',
            'parent_id' => $precios->id,
            'es_final' => true,
        ]);

        // Subopciones: Soporte Técnico
        ChatbotFlow::create([
            'texto' => 'Para soporte de sistema, escribe a sistemas@tuempresa.com',
            'parent_id' => $soporte->id,
            'es_final' => true,
        ]);

        ChatbotFlow::create([
            'texto' => 'Para problemas con la app, escriba al 7000-0000.',
            'parent_id' => $soporte->id,
            'es_final' => true,
        ]);
    }
    
}
