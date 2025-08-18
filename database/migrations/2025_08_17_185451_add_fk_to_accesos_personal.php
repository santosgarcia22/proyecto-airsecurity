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
        // Asegura tipo correcto
        Schema::table('accesos_personal', function (Blueprint $table) {
            // Si tu Laravel soporta change(): require doctrine/dbal instalado
            // $table->unsignedBigInteger('control_id')->change();
        });

        // Elimina FK previa si existe
        $fk = DB::selectOne("
            SELECT CONSTRAINT_NAME AS name
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'accesos_personal'
              AND COLUMN_NAME = 'control_id'
              AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1
        ");
        if ($fk) {
            DB::statement('ALTER TABLE accesos_personal DROP FOREIGN KEY '.$fk->name);
        }

        // Elimina índice con el nombre conflictivo si existe
        $idx = DB::selectOne("
            SHOW INDEX FROM accesos_personal WHERE Key_name = 'accesos_personal_control_id_foreign'
        ");
        if ($idx) {
            DB::statement('ALTER TABLE accesos_personal DROP INDEX accesos_personal_control_id_foreign');
        }

        // Crea la FK con un nombre NUEVO para evitar choques
        Schema::table('accesos_personal', function (Blueprint $table) {
            $table->foreign('control_id', 'fk_accesos_control')
                  ->references('id_control_aeronave')->on('control_aeronave')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('accesos_personal', function (Blueprint $table) {
            $table->dropForeign('fk_accesos_control');
        });
    }
};
