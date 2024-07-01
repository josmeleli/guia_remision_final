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
        Schema::create('transportistas', function (Blueprint $table) {
            $table->id();
            $table->string('unidad_tecnica');
            $table->string('campo')->nullable();
            $table->bigInteger('RUC')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('codigo')->nullable();
            $table->string('zona')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportistas');
    }
};
