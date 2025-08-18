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
       Schema::table('control_aeronave', function (Blueprint $table) {
            // Si tu MySQL/MariaDB soporta JSON, úsalo:
            $table->json('accesos')->nullable()->after('firma');
            // Si tu motor no soporta JSON, puedes usar:
            // $table->longText('accesos')->nullable()->after('firma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('control_aeronave', function (Blueprint $table) {
            $table->dropColumn('accesos');
        });
    }
};