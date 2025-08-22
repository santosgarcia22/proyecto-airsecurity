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

          Schema::create('accesos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('vuelo_id');
                $table->foreign('vuelo_id')->references('id')->on('vuelos');              
                // Datos del acceso de personal
                $table->string('nombre',120);
                $table->string('identificacion',50)->nullable();
                $table->string('empresa',150)->nullable();
                $table->string('herramientas',120)->nullable();
                $table->string('motivo_entrada',20)->nullable();
                $table->time('hora_entrada')->nullable();
                $table->time('hora_salida')->nullable();
                $table->time('hora_entrada1')->nullable();
                $table->time('hora_salida2')->nullable();
                $table->string('firma_path')->nullable(); // path del archivo
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