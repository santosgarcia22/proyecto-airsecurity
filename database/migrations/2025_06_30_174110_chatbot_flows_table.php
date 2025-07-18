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
        Schema::create('chatbot_flows', function (Blueprint $table) {
    $table->id();
    $table->string('texto');              // texto de la opción o mensaje
    $table->foreignId('parent_id')->nullable()->constrained('chatbot_flows'); // pregunta anterior
    $table->boolean('es_final')->default(false); // si es una respuesta final
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
