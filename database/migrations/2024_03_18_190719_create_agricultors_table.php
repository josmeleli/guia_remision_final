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
        Schema::create('agricultors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ruc');
            $table->string('razon_social');
            $table->string('direccion');
            $table->string('apellidos')->nullable();
            $table->string('nombres')->nullable();
            $table->string('dni')->unique()->nullable();
            // Puedes agregar más columnas si es necesario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agricultors');
    }
};
