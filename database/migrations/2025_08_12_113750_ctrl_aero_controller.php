<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //

         Schema::create('control_aeronave', function (Blueprint $t) {
            $t->bigIncrements('id_control_aeronave');

            // Datos base
            $t->date('fecha')->nullable();
            $t->string('origen', 100)->nullable();
            $t->string('numero_vuelo', 50)->nullable();
            $t->time('hora_llegada')->nullable();
            $t->string('posicion_llegada', 100)->nullable();
            $t->string('matricula_operador', 200)->nullable();
            $t->string('coordinador_lider', 150)->nullable();
            // Procesos / tiempos
            $t->time('desabordaje_inicio')->nullable();
            $t->time('desabordaje_fin')->nullable();
            $t->time('inspeccion_cabina_inicio')->nullable();
            $t->time('inspeccion_cabina_fin')->nullable();
            $t->time('aseo_ingreso')->nullable();
            $t->time('aseo_salida')->nullable();
            $t->time('tripulacion_ingreso')->nullable();
            $t->time('salida_itinerario')->nullable();
            $t->time('abordaje_inicio')->nullable();
            $t->time('abordaje_fin')->nullable();
            $t->time('cierre_puertas')->nullable();
            // Seguridad
            $t->string('agente_nombre', 150)->nullable();
            $t->string('agente_id', 100)->nullable();
            $t->string('agente_firma')->nullable(); // path del archivo
            // Demoras / pax
            $t->unsignedInteger('demora_tiempo')->nullable(); // en minutos
            $t->string('demora_motivo', 255)->nullable();
            $t->string('destino', 100)->nullable();
            $t->unsignedInteger('total_pax')->nullable();
            $t->time('hora_real_salida')->nullable();

            //datop de acceso
            $t->string('nombre', 100)->nullable();
            $t->string('id', 10)->nullable();
            $t->time('hora_entrada')->nullable();
            $t->time('hora-salida')->nullable();
            $t->time('hora-entrada1')->nullable();
            $t->time('hora-salida1')->nullable();
            $t->string('herraminetas')->nullable();
            $t->string('empresa')->nullable();
            $t->string('motivo')->nullable();
            $t->string('firma')->nullable();

            $t->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
