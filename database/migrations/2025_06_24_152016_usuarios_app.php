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
        Schema::create('usuarios_app', function (Blueprint $table) {
        $table->id('id_usuario');
        $table->string('usuario')->unique();
        $table->string('email')->nullable();
        $table->string('password');
        $table->string('nombre_completo')->nullable();
        $table->boolean('activo')->default(true);
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
