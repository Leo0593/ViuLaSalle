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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            
            // Modificación: Permitir que 'id_evento' sea nulo
            $table->foreignId('id_evento')->nullable()->constrained('eventos')->onDelete('set null'); 

            // Otros campos
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
        Schema::dropIfExists('publicaciones');
    }
};
