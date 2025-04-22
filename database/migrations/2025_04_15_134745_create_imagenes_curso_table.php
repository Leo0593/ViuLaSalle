<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotos_curso', function (Blueprint $table) {
            $table->id();

            // Relación con curso usando foreignId
            $table->foreignId('curso_id')->constrained('curso')->onDelete('cascade');

            // Ruta de la imagen
            $table->string('ruta_imagen');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos_curso');
    }
};
