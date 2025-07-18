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
        Schema::create('acceso', function (Blueprint $table) {
            $table->id('numero_id');
            $table->string('nombre');
            $table->bigInteger('tipo')->unsigned();
            $table->foreign('tipo')->references('id_tipo')->on('tipos');
            $table->string('posicion');
            $table->datetime('ingreso');
            $table->datetime('salida');
            $table->datetime('Sicronizacion');
            $table->string('id');
            $table->string('objetos');
            $table->bigInteger('vuelo')->unsigned();
            $table->foreign('vuelo')->references('id_vuelo')->on('vuelo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acceso');
    }
};
