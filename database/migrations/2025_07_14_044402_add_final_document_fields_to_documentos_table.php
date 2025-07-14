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
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('archivo_final', 255)->nullable()->after('archivo');
            $table->unsignedBigInteger('id_usuario_cargo_archivo_final')->nullable()->after('archivo_final');
            $table->timestamp('fecha_cargo_archivo_final')->nullable()->after('id_usuario_cargo_archivo_final');
            
            $table->foreign('id_usuario_cargo_archivo_final')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropForeign(['id_usuario_cargo_archivo_final']);
            $table->dropColumn(['archivo_final', 'id_usuario_cargo_archivo_final', 'fecha_cargo_archivo_final']);
        });
    }
};
