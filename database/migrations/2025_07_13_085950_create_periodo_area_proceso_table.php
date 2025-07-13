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
        Schema::create('periodo_area_proceso', function (Blueprint $table) {
            $table->id('id_configuracion');
            $table->integer('id_periodo');
            $table->integer('id_area');
            $table->integer('id_proceso');
            $table->bigInteger('id_usuario_asigno')->unsigned();
            $table->datetime('fecha_asigno')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('id_empresa');
            
            // Indexes
            $table->index('id_empresa');
            $table->index('id_periodo');
            $table->index('id_area');
            $table->index('id_proceso');
            $table->index('id_usuario_asigno');
            
            // Note: Foreign key constraints commented out until table structure is verified
            // Uncomment these once you verify the referenced tables exist and have correct column names
            
            // $table->foreign('id_empresa')->references('id_empresa')->on('empresa')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_periodo')->references('id_periodo')->on('periodo')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_area')->references('id_area')->on('area')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_proceso')->references('id_proceso')->on('proceso')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('id_usuario_asigno')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodo_area_proceso');
    }
};
