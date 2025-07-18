<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('usuarios_app', function (Blueprint $table) {
        $table->boolean('activo')->default(true)->after('password');
    });
}
public function down()
{
    Schema::table('usuarios_app', function (Blueprint $table) {
        $table->dropColumn('activo');
    });
}

};