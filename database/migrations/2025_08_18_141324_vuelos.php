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

       Schema::create('vuelos', function (Blueprint $table) {
    $table->id();
    $table->date('fecha');
    $table->string('origen', 10);
    $table->string('destino', 10);
    $table->string('numero_vuelo_llegando', 20);
    $table->string('numero_vuelo_saliendo', 20);
    $table->string('matricula', 20);

    $table->unsignedBigInteger('operador_id');
    $table->string('posicion_llegada', 20);
    $table->dateTime('hora_llegada_real');
    $table->dateTime('hora_salida_itinerario');
    $table->dateTime('hora_salida_pushback');
    $table->bigInteger('total_pax');

    $table->foreign('operador_id')->references('id')->on('operadores');

    $table->timestamps();
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
