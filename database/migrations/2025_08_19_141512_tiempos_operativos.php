<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('tiempos_operativos', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('vuelo_id');
      $table->time('desabordaje_inicio')->nullable();
      $table->time('desabordaje_fin')->nullable();
      $table->time('abordaje_inicio')->nullable();
      $table->time('abordaje_fin')->nullable();
      $table->time('inspeccion_cabina_inicio')->nullable();
      $table->time('inspeccion_cabina_fin')->nullable();
      $table->time('aseo_ingreso')->nullable();
      $table->time('aseo_salida')->nullable();
      $table->time('tripulacion_ingreso')->nullable();
      $table->time('cierre_puerta')->nullable();
      $table->timestamps();

      $table->foreign('vuelo_id')
        ->references('id')->on('vuelos')
        ->cascadeOnDelete();
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