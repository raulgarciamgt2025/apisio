<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('id_documento');
            $table->bigInteger('id_configuracion');
            $table->datetime('fecha_grabo')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('id_usuario_grabo')->unsigned();
            $table->string('descripcion', 150);
            $table->bigInteger('id_usuario_editor')->unsigned();
            $table->bigInteger('id_usuario_responsable')->unsigned();
            $table->char('estado', 1);
            $table->integer('id_empresa');
            
            // Indexes
            $table->index('id_configuracion');
            $table->index('id_usuario_grabo');
            $table->index('id_usuario_editor');
            $table->index('id_usuario_responsable');
            $table->index('id_empresa');
            
            // Add CHECK constraint for estado
            DB::statement("ALTER TABLE documentos ADD CONSTRAINT chk_estado CHECK (estado IN ('E', 'F', 'O'))");
            
            // Note: Foreign key constraints commented out since table already exists
            // Uncomment these once you verify the referenced tables exist and have correct column names
            
            // $table->foreign('id_configuracion')->references('id_configuracion')->on('periodo_area_proceso')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_empresa')->references('id_empresa')->on('empresa')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_usuario_grabo')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_usuario_editor')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_usuario_responsable')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
