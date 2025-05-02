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
        Schema::create('publicacion_coleccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('coleccion_id')->constrained('colecciones')->onDelete('cascade'); 
            $table->boolean('status')->default(1); // 1 = Activo, 0 = Inactivo
            $table->text('descripcion');
            $table->dateTime('fecha_publicacion')->default(now());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion_coleccion');
    }
};
