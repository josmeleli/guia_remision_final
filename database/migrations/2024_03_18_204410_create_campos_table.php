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
        Schema::create('campos', function (Blueprint $table) {
            $table->id();
            $table->string('acopiadora');
            $table->string('ubigeo');
            $table->string('zona');
            $table->string('ingenio');
            $table->foreignId('carga_id')->constrained('cargas')->onDelete('cascade'); // Llave foránea a la tabla cargas
            $table->foreignId('agricultor_id')->constrained('agricultors')->onDelete('cascade'); // Llave foránea a la tabla agricultores
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campos');
    }
};
