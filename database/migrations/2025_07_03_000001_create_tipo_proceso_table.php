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
        Schema::create('tipo_proceso', function (Blueprint $table) {
            $table->id('id_tipo_proceso');
            $table->string('descripcion', 75);
            $table->string('estado', 2);
            $table->unsignedBigInteger('id_empresa');
            $table->timestamps();
            
            $table->foreign('id_empresa')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_proceso');
    }
};
