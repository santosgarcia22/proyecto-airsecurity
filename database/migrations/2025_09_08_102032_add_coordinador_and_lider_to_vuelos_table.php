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
            //

            // Si aún no existen…
            if (!Schema::hasColumn('vuelos', 'coordinador_id')) {
                $table->unsignedBigInteger('coordinador_id')->nullable()->after('total_pax');
                $table->foreign('coordinador_id')
                      ->references('id')->on('personas')
                      ->onDelete('set null');
            }

            if (!Schema::hasColumn('vuelos', 'lider_vuelo_id')) {
                $table->unsignedBigInteger('lider_vuelo_id')->nullable()->after('coordinador_id');
                $table->foreign('lider_vuelo_id')
                      ->references('id')->on('personas')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vuelos', function (Blueprint $table) {
            //

                   if (Schema::hasColumn('vuelos', 'coordinador_id')) {
                $table->dropForeign(['coordinador_id']);
                $table->dropColumn('coordinador_id');
            }
            if (Schema::hasColumn('vuelos', 'lider_vuelo_id')) {
                $table->dropForeign(['lider_vuelo_id']);
                $table->dropColumn('lider_vuelo_id');
            }
        });
    }
};