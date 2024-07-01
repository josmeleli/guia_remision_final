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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa');
            $table->string('placa1')->nullable();
            $table->string('dueño')->nullable();
            $table->string('num_ejes')->nullable();
            $table->string('codigo');
            $table->unsignedBigInteger('id_transportista')->nullable();
            $table->foreign('id_transportista')->references('id')->on('transportistas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
