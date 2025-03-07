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
        Schema::create('fotos_publicaciones', function (Blueprint $table) {
            $table->id();

            // Clave foránea que referencia a publicaciones
            $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');

            // Campo para la ruta de la imagen
            $table->string('ruta_foto');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_publicaciones');
    }
};
