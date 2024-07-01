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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agricultor_id');
            $table->foreign('agricultor_id')->references('id')->on('agricultors')->onDelete('cascade');
            $table->timestamps();
            $table->decimal('adelanto', 20, 2); // Cambiado a decimal para manejar números
            $table->string('tipo_pago');
            $table->decimal('precio_unitario', 10, 2); // Cambiado a decimal para manejar números
            $table->string('num_pago');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
