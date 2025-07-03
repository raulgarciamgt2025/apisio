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
        Schema::create('periodo', function (Blueprint $table) {
            $table->id('id_periodo');
            $table->string('label', 50);
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_fin');
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
        Schema::dropIfExists('periodo');
    }
};
