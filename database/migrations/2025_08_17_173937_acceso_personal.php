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
    Schema::create('accesos_personal', function (Blueprint $t) {
                $t->bigIncrements('id_personal');
                // FK al control
                $t->unsignedBigInteger('control_id');
                $t->foreign('control_id')
                ->references('id_control_aeronave')->on('control_aeronave')
                ->onDelete('cascade');
                // Datos del acceso de personal
                $t->string('nombre',150);
                $t->string('id',50)->nullable();
                $t->time('hora_entrada')->nullable();
                $t->time('hora_salida')->nullable();
                $t->time('hora_entrada1')->nullable();
                $t->time('hora_salida1')->nullable();
                $t->string('herramientas',255)->nullable();
                $t->string('empresa',150)->nullable();
                $t->string('motivo',400)->nullable();
                $t->string('firma')->nullable(); // path del archivo
                $t->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void {
        Schema::dropIfExists('accesos_personal');
    }
};