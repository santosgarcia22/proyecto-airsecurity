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
       Schema::table('vuelos', function (Blueprint $table) {
            $table->unsignedBigInteger('coordinador_id')->nullable()->after('total_pax');
            $table->unsignedBigInteger('lider_vuelo_id')->nullable()->after('coordinador_id');

            $table->foreign('coordinador_id')->references('id')->on('personas')->nullOnDelete();
            $table->foreign('lider_vuelo_id')->references('id')->on('personas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vuelos', function (Blueprint $table) {
            $table->dropForeign(['coordinador_id']);
            $table->dropForeign(['lider_vuelo_id']);
            $table->dropColumn(['coordinador_id','lider_vuelo_id']);
        });
    }
};