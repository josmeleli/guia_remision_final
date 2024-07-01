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
        Schema::create('guias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_emision');
            $table->string('nro_guia')->unique();
            $table->string('nro_ticket')->nullable();
            $table->date('fecha_partida');
            $table->string('punto_partida');
            $table->string('punto_llegada');
            $table->string('producto');
            $table->string('peso_bruto');
            $table->string('estado');
            $table->unsignedBigInteger('agricultor_id');
            $table->unsignedBigInteger('transportista_id');
            $table->timestamps();

            $table->foreign('agricultor_id')->references('id')->on('agricultors')->onDelete('cascade');
            $table->foreign('transportista_id')->references('id')->on('transportistas')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guias');
    }
};
